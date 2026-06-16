<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - My Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #13131a; --card-dark: #1c1c24; --border-dark: #2d2d3a;
            --primary-orange: #ff512f; --gradient-orange: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
            --text-light: #ffffff; --text-muted: #a1a1aa;
        }
        
        body, html { margin: 0; padding: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }

        body { background: linear-gradient(135deg, #0f0f13 0%, #1a1a24 100%); }
        
        .bg-shapes { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; pointer-events: none; }
        .shape1 { position: absolute; top: -10%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,81,47,0.15) 0%, transparent 60%); filter: blur(50px); }
        .shape2 { position: absolute; bottom: 0%; right: -10%; width: 60vw; height: 60vw; background: radial-gradient(circle, rgba(240,152,25,0.1) 0%, transparent 60%); filter: blur(60px); }
        .grid-pattern { position: absolute; width: 100%; height: 100%; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; }

        .top-nav { padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 10; position: relative; }
        .logo { font-size: 28px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; text-shadow: 0 4px 10px rgba(255,81,47,0.3);}
        .desktop-menu { display: none; gap: 40px; }
        .desktop-menu a { color: var(--text-muted); text-decoration: none; font-size: 16px; font-weight: 500; transition: color 0.3s; }
        .desktop-menu a.active, .desktop-menu a:hover { color: var(--text-light); }

        .main-content { flex: 1; padding: 20px 5% 120px; max-width: 650px; margin: 0 auto; width: 100%; box-sizing: border-box; z-index: 5; position: relative; }
        
        /* Glassmorphism Profile Container */
        .profile-card { background: rgba(28, 28, 36, 0.4); backdrop-filter: blur(20px); padding: 30px; border-radius: 24px; border: 1px solid var(--border-dark); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); margin-bottom: 25px;}
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 10px; color: var(--text-muted); letter-spacing: 0.3px; }
        
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; background: rgba(28, 28, 36, 0.8); backdrop-filter: blur(10px); 
            border: 1px solid var(--border-dark); border-radius: 16px; color: var(--text-light); 
            padding: 15px 20px; font-size: 15px; outline: none; font-family: inherit; 
            transition: 0.3s; box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
            border-color: var(--primary-orange); box-shadow: 0 0 15px rgba(255,81,47,0.15); 
        }
        
        .document-status { display: block; margin-top: 8px; font-size: 13px; color: #4ade80; font-weight: 500; }

        /* Buttons Styling */
        .btn-save { 
            width: 100%; padding: 16px; background: var(--gradient-orange); color: white; 
            border: none; border-radius: 16px; font-size: 16px; font-weight: 800; 
            cursor: pointer; margin-top: 10px; box-shadow: 0 10px 20px rgba(255,81,47,0.2);
            transition: 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(255,81,47,0.4); }
        .btn-save:active { transform: translateY(0); }

        .btn-logout { 
            width: 100%; padding: 15px; background: transparent; color: #f87171; 
            border: 2px solid #f87171; border-radius: 16px; font-size: 16px; font-weight: 700; 
            cursor: pointer; margin-top: 10px; transition: 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-logout:hover { background: rgba(248, 113, 113, 0.1); border-color: #f87171; }

        .alert-success { background: rgba(74, 222, 128, 0.1); color: #4ade80; padding: 15px 20px; border-radius: 16px; margin-bottom: 25px; border: 1px solid rgba(74, 222, 128, 0.2); font-weight: 500; font-size: 15px;}

        .bottom-nav { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(19, 19, 26, 0.95); backdrop-filter: blur(10px); border-top: 1px solid var(--border-dark); display: flex; justify-content: space-around; padding: 20px 0 calc(20px + env(safe-area-inset-bottom)); z-index: 50; }
        .bottom-nav a { color: var(--text-muted); font-size: 22px; transition: 0.3s; }
        .bottom-nav a.active { color: var(--primary-orange); }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-menu { display: flex; }
            .main-content { padding-top: 40px; }
        }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="grid-pattern"></div>
        <div class="shape1"></div>
        <div class="shape2"></div>
    </div>

    <header class="top-nav">
        <div class="logo">Hiring</div>
        <div class="desktop-menu">
            <a href="{{ url('/applicant/home') }}">Discover</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/applicant/calendar') }}">Calendar</a>
            <a href="{{ url('/applicant/profile') }}" class="active">Profile</a>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="profile-card">
            <h2 style="margin-top: 0; margin-bottom: 25px; color: var(--text-light); font-weight: 800; font-size: 24px; letter-spacing: -0.5px;">Data Diri Pelamar</h2>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Status Pencarian Kerja</label>
                    <select name="status">
                        <option value="active_searching" {{ ($profile->status ?? '') == 'active_searching' ? 'selected' : '' }}>Aktif Mencari Kerja</option>
                        <option value="unactive" {{ ($profile->status ?? '') == 'unactive' ? 'selected' : '' }}>Tidak Aktif (Istirahat)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ $profile->full_name ?? Auth::user()->name }}" required>
                </div>

                <div class="form-group">
                    <label>Universitas / Pendidikan Terakhir</label>
                    <input type="text" name="education" value="{{ $profile->education ?? '' }}" placeholder="Contoh: Univ. Kristen Petra - Informatika">
                </div>

                <div class="form-group">
                    <label>Lokasi / Kota Domisili</label>
                    <input type="text" name="location" value="{{ $profile->location ?? '' }}" placeholder="Contoh: Surabaya">
                </div>

                <div class="form-group">
                    <label>Riwayat & Keahlian (Job History)</label>
                    <textarea name="job_history" rows="4" placeholder="Ceritakan keahlian dan pengalaman Anda...">{{ $profile->job_history ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>Upload KTP (JPG/PNG/PDF max 2MB)</label>
                    <input type="file" name="document_ktp" accept=".jpg,.jpeg,.png,.pdf">
                    @if(isset($profile->document_ktp))
                        <small class="document-status"><i class="fas fa-check-circle"></i> KTP sudah terunggah.</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Upload Ijazah (PDF max 2MB)</label>
                    <input type="file" name="document_ijazah" accept=".pdf">
                    @if(isset($profile->document_ijazah))
                        <small class="document-status"><i class="fas fa-check-circle"></i> Ijazah sudah terunggah.</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Upload CV (PDF max 2MB)</label>
                    <input type="file" name="document_cv" accept=".pdf">
                    @if(isset($profile->document_cv))
                        <small class="document-status"><i class="fas fa-check-circle"></i> CV sudah terunggah.</small>
                    @endif
                </div>

                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan Profil</button>
            </form>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout" onclick="localStorage.removeItem('api_token');"><i class="fas fa-sign-out-alt"></i> Logout Akun</button>
        </form>
    </main>

    <nav class="bottom-nav">
        <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/applicant/profile') }}" class="active"><i class="fas fa-user"></i></a>
    </nav>

</body>
</html>