<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Console - Flash AI Suite</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS v3 via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            cyberDark: '#020617',
            cyberCard: '#0f172a',
            flashYellow: '#ffcc00',
            flashBlue: '#00f0ff',
            cyberGray: '#94a3b8',
            cyberBorder: 'rgba(255,255,255,0.06)'
          },
          fontFamily: {
            sans: ['Outfit', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
          },
          boxShadow: {
            'glow-yellow': '0 0 20px rgba(255, 234, 0, 0.25)',
            'glow-blue': '0 0 20px rgba(0, 240, 255, 0.25)',
            'glow-card': '0 10px 30px -10px rgba(0, 0, 0, 0.8)'
          }
        }
      }
    }
  </script>
  
  <style>
    body {
      min-height: 100vh;
      overflow-x: hidden;
      transition: background 0.3s ease, color 0.3s ease;
    }
    .dark body {
      background: radial-gradient(circle at 50% 50%, #0f172a 0%, #020617 100%);
    }
    .light body {
      background: radial-gradient(circle at 50% 50%, #f8fafc 0%, #e2e8f0 100%);
    }
    .glass-card {
      transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .dark class-card, .dark .glass-card {
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.05);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    }
    .light class-card, .light .glass-card {
      background: rgba(255, 255, 255, 0.8);
      border: 1px solid rgba(15, 23, 42, 0.08);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
    }
  </style>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="text-slate-900 dark:text-white pb-24">

  <!-- Background glow -->
  <div class="absolute top-[-10%] right-[-10%] w-[45%] h-[45%] bg-flashYellow/5 rounded-full blur-[130px] pointer-events-none"></div>
  <div class="absolute bottom-[-10%] left-[-10%] w-[45%] h-[45%] bg-flashBlue/5 rounded-full blur-[130px] pointer-events-none"></div>

  <!-- Header -->
  <header class="container mx-auto px-4 py-4 flex justify-between items-center relative z-10 border-b border-slate-200/50 dark:border-white/5">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-flashYellow to-flashBlue flex items-center justify-center shadow-glow-yellow">
        <i data-lucide="shield-check" class="w-5.5 h-5.5 text-black stroke-[2.5]"></i>
      </div>
      <div>
        <h1 class="text-xl font-black tracking-wider uppercase font-sans">
          Flash <span class="text-transparent bg-clip-text bg-gradient-to-r from-flashYellow to-flashBlue">AI</span> Admin
        </h1>
        <p class="text-[9px] text-slate-500 dark:text-cyberGray tracking-widest uppercase font-mono">Upload Monitor Console</p>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <!-- Dark mode switch -->
      <button id="btnThemeToggle" class="p-2.5 rounded-xl bg-white/70 dark:bg-cyberCard/80 text-slate-600 dark:text-cyberGray hover:text-slate-900 dark:hover:text-white transition-all border border-slate-200 dark:border-white/5">
        <i id="themeToggleIcon" data-lucide="sun" class="w-4 h-4"></i>
      </button>

      <!-- Back to scanner -->
      <a href="/" class="flex items-center gap-2 px-4 py-2 text-xs md:text-sm font-bold bg-gradient-to-r from-flashYellow to-flashBlue text-black rounded-xl hover:scale-105 active:scale-95 transition-transform duration-200 shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke Scanner
      </a>
    </div>
  </header>

  <main class="container mx-auto px-4 mt-8 max-w-6xl relative z-10">

    <!-- Flash message -->
    @if(session('success'))
      <div class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs md:text-sm font-semibold flex items-center gap-2.5 shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    <!-- Statistics Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <!-- Card 1: Total -->
      <div class="glass-card rounded-2xl p-5 border-white/5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-500 dark:text-cyberGray border border-slate-200 dark:border-white/10 shadow-sm">
          <i data-lucide="images" class="w-6 h-6"></i>
        </div>
        <div>
          <h4 class="text-xs font-bold text-slate-500 dark:text-cyberGray uppercase tracking-wider font-mono">Total Unggahan</h4>
          <p class="text-2xl font-black mt-0.5">{{ $totalUploads }} <span class="text-xs text-slate-400 font-normal">foto</span></p>
        </div>
      </div>

      <!-- Card 2: AI Detects -->
      <div class="glass-card rounded-2xl p-5 border-white/5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 border border-orange-500/20 shadow-glow-yellow">
          <i data-lucide="cpu" class="w-6 h-6 animate-pulse"></i>
        </div>
        <div>
          <h4 class="text-xs font-bold text-slate-500 dark:text-cyberGray uppercase tracking-wider font-mono">Terdeteksi Rekayasa AI</h4>
          <p class="text-2xl font-black mt-0.5 text-orange-500">{{ $aiCount }} <span class="text-xs text-orange-400/80 font-normal">({{ $aiPercentage }}%)</span></p>
        </div>
      </div>

      <!-- Card 3: Human Originals -->
      <div class="glass-card rounded-2xl p-5 border-white/5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-flashBlue/10 flex items-center justify-center text-flashBlue border border-flashBlue/20 shadow-glow-blue">
          <i data-lucide="user" class="w-6 h-6"></i>
        </div>
        <div>
          <h4 class="text-xs font-bold text-slate-500 dark:text-cyberGray uppercase tracking-wider font-mono">Asli (Foto Manusia)</h4>
          <p class="text-2xl font-black mt-0.5 text-flashBlue">{{ $humanCount }} <span class="text-xs text-flashBlue/80 font-normal">({{ $humanPercentage }}%)</span></p>
        </div>
      </div>
    </div>

    <!-- History Panel -->
    <div class="glass-card rounded-2xl border-white/5 overflow-hidden">
      <div class="p-5 border-b border-slate-200 dark:border-white/5 flex justify-between items-center">
        <h3 class="text-sm font-bold uppercase tracking-wider font-mono text-flashYellow flex items-center gap-2">
          <i data-lucide="history" class="w-4 h-4"></i> Monitor Log Riwayat Foto Pengguna
        </h3>
        <span class="text-xs px-2.5 py-0.5 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/5 rounded-full text-slate-500 dark:text-cyberGray font-mono font-bold">{{ $uploads->count() }} Entry</span>
      </div>

      @if($uploads->isEmpty())
        <div class="p-16 text-center text-slate-500 dark:text-cyberGray">
          <i data-lucide="folder-open" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
          <p class="font-bold text-sm">Belum ada riwayat foto yang diunggah.</p>
          <p class="text-xs opacity-75 mt-1">Gunakan scanner di halaman utama untuk mulai merekam data.</p>
        </div>
      @else
        <div class="overflow-x-auto text-xs md:text-sm">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-100/50 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/5 text-[10px] uppercase tracking-wider font-bold text-slate-500 dark:text-cyberGray">
                <th class="py-3.5 px-4 w-28">Pratinjau Foto</th>
                <th class="py-3.5 px-4 w-48">Detail Berkas</th>
                <th class="py-3.5 px-4 w-32">Analisis Hasil</th>
                <th class="py-3.5 px-4">Metadata EXIF & Lokasi</th>
                <th class="py-3.5 px-4 text-center w-20">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($uploads as $upload)
                <tr class="border-b border-slate-200/50 dark:border-white/5 hover:bg-slate-100/30 dark:hover:bg-white/[0.005] transition-colors">
                  <!-- Thumbnail Image -->
                  <td class="py-4 px-4">
                    <a href="{{ asset('uploads/' . $upload->filename) }}" target="_blank" class="block w-20 h-20 rounded-xl overflow-hidden bg-slate-200 dark:bg-black/30 border border-slate-300 dark:border-white/5 hover:border-flashYellow transition-all group relative">
                      <img src="{{ asset('uploads/' . $upload->filename) }}" alt="Preview" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" onerror="this.onerror=null; this.src='https://placehold.co/100x100/1e293b/ffcc00?text=No+File';">
                      <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[8px] font-bold">
                        Buka Asli <i data-lucide="external-link" class="w-2 h-2 ml-1"></i>
                      </div>
                    </a>
                  </td>

                  <!-- File Specs -->
                  <td class="py-4 px-4 font-mono leading-relaxed">
                    <span class="font-bold text-slate-900 dark:text-white break-all block max-w-[170px]" title="{{ $upload->original_name }}">{{ $upload->original_name }}</span>
                    <span class="text-[10px] text-slate-500 dark:text-cyberGray/80 block mt-1">Size: {{ $upload->filesize }}</span>
                    <span class="text-[10px] text-slate-500 dark:text-cyberGray/80 block">Res: {{ $upload->resolution }}</span>
                    <span class="text-[9px] text-slate-400 dark:text-cyberGray/50 block mt-1.5" title="{{ $upload->created_at }}">{{ $upload->created_at->diffForHumans() }}</span>
                  </td>

                  <!-- Analysis Result -->
                  <td class="py-4 px-4">
                    @if($upload->verdict === 'AI')
                      <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-orange-500/10 border border-orange-500/25 text-orange-500 uppercase tracking-wider shadow-glow-yellow mb-1.5">
                        <i data-lucide="cpu" class="w-3 h-3"></i> AI REKAYASA
                      </span>
                      <span class="block text-xs font-mono font-bold text-orange-400">Confidence: {{ $upload->ai_score }}%</span>
                    @else
                      <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-flashBlue/10 border border-flashBlue/25 text-flashBlue uppercase tracking-wider shadow-glow-blue mb-1.5">
                        <i data-lucide="user" class="w-3 h-3"></i> ASLI MANUSIA
                      </span>
                      <span class="block text-xs font-mono font-bold text-flashBlue">Confidence: {{ 100 - $upload->ai_score }}%</span>
                    @endif
                  </td>

                  <!-- Metadata EXIF -->
                  <td class="py-4 px-4 leading-normal text-xs">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                      <p><span class="font-semibold text-slate-500 dark:text-cyberGray">Kamera / HP:</span> <span class="font-bold text-slate-700 dark:text-slate-200">{{ $upload->camera_model }}</span></p>
                      <p><span class="font-semibold text-slate-500 dark:text-cyberGray">Tanggal Ambil:</span> <span class="font-bold text-slate-700 dark:text-slate-200">{{ $upload->date_taken }} {{ $upload->time_taken !== '-' ? $upload->time_taken : '' }}</span></p>
                      <p><span class="font-semibold text-slate-500 dark:text-cyberGray">Asal Sosmed:</span> <span class="font-bold text-slate-700 dark:text-slate-200">{{ $upload->social_media }}</span></p>
                      <p class="flex items-center gap-1">
                        <span class="font-semibold text-slate-500 dark:text-cyberGray">Lokasi GPS:</span>
                        @if($upload->gps_coordinates !== '-')
                          <a href="https://www.google.com/maps?q={{ urlencode($upload->gps_coordinates) }}" target="_blank" class="font-mono text-emerald-500 dark:text-emerald-400 font-bold hover:underline inline-flex items-center gap-0.5">
                            {{ $upload->gps_coordinates }} <i data-lucide="map" class="w-3 h-3"></i>
                          </a>
                        @else
                          <span class="font-mono font-semibold text-slate-400">-</span>
                        @endif
                      </p>
                    </div>
                  </td>

                  <!-- Action Buttons -->
                  <td class="py-4 px-4 text-center">
                    <form action="{{ route('admin.uploads.destroy', $upload->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data foto ini secara permanen dari server?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-2 rounded-lg bg-red-500/10 hover:bg-red-500 hover:text-white border border-red-500/25 text-red-500 transition-all active:scale-95" title="Hapus Permanen">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <!-- ==================== TABEL LOG PENGUNJUNG ==================== -->
    <div class="mt-8 bg-white/50 dark:bg-cyberCard/40 border border-slate-200 dark:border-white/5 backdrop-blur-md rounded-2xl p-6 shadow-xl relative overflow-hidden">
      <!-- Glow effect -->
      <div class="absolute -top-40 -left-40 w-80 h-80 bg-flashBlue/10 rounded-full blur-3xl pointer-events-none"></div>

      <div class="flex items-center gap-3 mb-6 relative z-10">
        <div class="w-8 h-8 rounded-lg bg-flashBlue/10 border border-flashBlue/25 flex items-center justify-center text-flashBlue">
          <i data-lucide="users" class="w-4 h-4"></i>
        </div>
        <div>
          <h2 class="text-base font-bold text-slate-850 dark:text-white uppercase tracking-wide">Aktivitas Pengunjung Terkini</h2>
          <p class="text-[10px] text-slate-500 dark:text-cyberGray/80 mt-0.5">Mendeteksi perangkat yang mengakses link website Anda</p>
        </div>
      </div>

      @if($visitors->isEmpty())
        <div class="text-center py-10 border border-dashed border-slate-200 dark:border-white/5 rounded-2xl relative z-10">
          <i data-lucide="user-x" class="w-10 h-10 text-slate-400 mx-auto mb-2 text-cyberGray/45"></i>
          <p class="text-xs text-slate-500 dark:text-cyberGray/60">Belum ada pengunjung yang terdeteksi.</p>
        </div>
      @else
        <div class="overflow-x-auto relative z-10 rounded-xl border border-slate-200/50 dark:border-white/5">
          <table class="w-full text-left border-collapse bg-slate-50/20 dark:bg-black/10">
            <thead>
              <tr class="border-b border-slate-200/50 dark:border-white/5 bg-slate-100/50 dark:bg-white/[0.02] text-[10px] uppercase font-bold text-slate-500 dark:text-cyberGray tracking-wider">
                <th class="py-3.5 px-4 w-12 text-center">No</th>
                <th class="py-3.5 px-4 w-40">IP Address</th>
                <th class="py-3.5 px-4 w-48">Perangkat / HP</th>
                <th class="py-3.5 px-4">User-Agent</th>
                <th class="py-3.5 px-4 w-44">Waktu Masuk</th>
              </tr>
            </thead>
            <tbody>
              @foreach($visitors as $index => $visitor)
                <tr class="border-b border-slate-200/50 dark:border-white/5 hover:bg-slate-100/30 dark:hover:bg-white/[0.005] transition-colors text-xs">
                  <td class="py-3 px-4 text-center font-mono font-bold text-slate-400">{{ $index + 1 }}</td>
                  <td class="py-3 px-4 font-mono font-semibold text-slate-600 dark:text-emerald-400">{{ $visitor->ip_address }}</td>
                  <td class="py-3 px-4 font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                    @if(str_contains(strtolower($visitor->device), 'iphone') || str_contains(strtolower($visitor->device), 'ipad'))
                      <i data-lucide="smartphone" class="w-3.5 h-3.5 text-flashYellow"></i>
                    @elseif(str_contains(strtolower($visitor->device), 'android'))
                      <i data-lucide="smartphone" class="w-3.5 h-3.5 text-emerald-400"></i>
                    @else
                      <i data-lucide="monitor" class="w-3.5 h-3.5 text-flashBlue"></i>
                    @endif
                    {{ $visitor->device }}
                  </td>
                  <td class="py-3 px-4 font-mono text-[10px] text-slate-500 dark:text-cyberGray/80 truncate max-w-[250px]" title="{{ $visitor->user_agent }}">
                    {{ $visitor->user_agent }}
                  </td>
                  <td class="py-3 px-4 font-mono text-[10px] text-slate-400 dark:text-cyberGray/50">
                    {{ $visitor->created_at->setTimezone('Asia/Jakarta')->format('d M Y - H:i:s') }} WIB
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

  </main>

  <script>
    lucide.createIcons();

    // ==================== THEME SYSTEM (LIGHT/DARK) ====================
    const btnThemeToggle = document.getElementById('btnThemeToggle');
    const themeToggleIcon = document.getElementById('themeToggleIcon');
    let theme = localStorage.getItem('ag_theme') || 'dark';

    function applyTheme(t) {
      if (t === 'light') {
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
        themeToggleIcon.innerHTML = '<i data-lucide="moon" class="w-4 h-4"></i>';
      } else {
        document.documentElement.classList.remove('light');
        document.documentElement.classList.add('dark');
        themeToggleIcon.innerHTML = '<i data-lucide="sun" class="w-4 h-4"></i>';
      }
      lucide.createIcons();
      localStorage.setItem('ag_theme', t);
    }

    applyTheme(theme);

    btnThemeToggle.addEventListener('click', () => {
      theme = theme === 'dark' ? 'light' : 'dark';
      applyTheme(theme);
    });
  </script>

</body>
</html>
