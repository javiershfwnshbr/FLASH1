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
            'humanPercentage'
        ));
    }

    public function store(Request $request)
    {
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
            
            // Create uploads folder inside public folder if not exists
            $uploadPath = public_path('uploads');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Save image with unique filename
            $filename = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

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
            'message' => 'Failed to upload image.'
        ], 400);
    }

    public function destroy($id)
    {
        $upload = Upload::findOrFail($id);
        
        // Remove physical file from public/uploads
        $filePath = public_path('uploads/' . $upload->filename);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        
        // Delete database record
        $upload->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Riwayat unggahan berhasil dihapus!');
    }
}
