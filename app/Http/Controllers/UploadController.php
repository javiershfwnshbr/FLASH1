<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function index()
    {
        $uploads = Upload::latest()->get();
        
        // Fetch visitors
        $visitors = [];
        try {
            $visitors = \App\Models\Visitor::latest()->take(100)->get();
        } catch (\Exception $e) {
            // Silently fail if table not migrated yet
        }
        
        // Compute dashboard stats
        $totalUploads = $uploads->count();
        $aiCount = $uploads->where('verdict', 'AI')->count();
        $humanCount = $uploads->where('verdict', 'Human')->count();
        
        $aiPercentage = $totalUploads > 0 ? round(($aiCount / $totalUploads) * 100, 1) : 0;
        $humanPercentage = $totalUploads > 0 ? round(($humanCount / $totalUploads) * 100, 1) : 0;
        
        return view('admin.dashboard', compact(
            'uploads', 
            'totalUploads', 
            'aiCount', 
            'humanCount', 
            'aiPercentage', 
            'humanPercentage',
            'visitors'
        ));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:10240', // Max 10MB
                'filename' => 'required|string',
                'filesize' => 'required|string',
                'resolution' => 'required|string',
                'verdict' => 'required|string',
                'ai_score' => 'required|numeric',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                
                $isVercel = env('RUNNING_ON_VERCEL') || env('VERCEL') || isset($_SERVER['VERCEL']);
                $apiKey = env('IMGBB_API_KEY');
                $filename = null;

                if ($apiKey) {
                    // Upload to ImgBB cloud storage
                    $base64Image = base64_encode(file_get_contents($file->getRealPath()));
                    $response = \Illuminate\Support\Facades\Http::withoutVerifying()->asForm()->post('https://api.imgbb.com/1/upload', [
                        'key' => $apiKey,
                        'image' => $base64Image,
                    ]);

                    if ($response->failed()) {
                        throw new \Exception('Gagal mengunggah foto ke ImgBB: ' . $response->body());
                    }

                    $responseData = $response->json();
                    if (!isset($responseData['success']) || !$responseData['success']) {
                        throw new \Exception('Format respons ImgBB tidak valid: ' . json_encode($responseData));
                    }

                    // Store the cloud URL in the filename column
                    $filename = $responseData['data']['url'];
                } else {
                    if ($isVercel) {
                        throw new \Exception('IMGBB_API_KEY tidak dikonfigurasi di Environment Vercel. Harap tambahkan IMGBB_API_KEY di dasbor Vercel Anda.');
                    }

                    // Fallback to local storage for local development
                    $uploadPath = public_path('uploads');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $filename = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                }

                // Log upload data to SQLite database
                $upload = Upload::create([
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'filesize' => $request->input('filesize'),
                    'resolution' => $request->input('resolution'),
                    'verdict' => $request->input('verdict'),
                    'ai_score' => $request->input('ai_score'),
                    'camera_model' => $request->input('camera_model', '-'),
                    'date_taken' => $request->input('date_taken', '-'),
                    'time_taken' => $request->input('time_taken', '-'),
                    'gps_coordinates' => $request->input('gps', '-'),
                    'social_media' => $request->input('social_media', '-'),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Upload saved successfully!',
                    'data' => $upload
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: No file found in request.'
            ], 400);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Upload Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $upload = Upload::findOrFail($id);
        
        // Remove physical file (only if it is a local path and not a cloud URL)
        if (!filter_var($upload->filename, FILTER_VALIDATE_URL)) {
            $isVercel = env('RUNNING_ON_VERCEL') || env('VERCEL') || isset($_SERVER['VERCEL']);
            $filePath = ($isVercel ? '/tmp/uploads/' : public_path('uploads/')) . $upload->filename;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        // Delete database record
        $upload->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Riwayat unggahan berhasil dihapus!');
    }
}
