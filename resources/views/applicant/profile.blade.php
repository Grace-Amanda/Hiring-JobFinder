<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - My Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #121212; --card-dark: #1e1e1e; --primary-orange: #ff512f;
            --text-light: #ffffff; --text-muted: #aaaaaa; --border-dark: #333333;
        }
        body { margin: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: column; height: 100vh; }
        
        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-dark); background: var(--bg-dark); z-index: 10; position: sticky; top: 0;}
        .header .logo { font-size: 24px; font-weight: bold; color: var(--primary-orange); }
        
        .main-content { flex: 1; overflow-y: auto; padding: 20px; padding-bottom: 100px; max-width: 600px; margin: 0 auto; width: 100%; box-sizing: border-box; }
        
        /* Form Styling */
        .profile-card { background: var(--card-dark); padding: 20px; border-radius: 15px; border: 1px solid var(--border-dark); margin-bottom: 20px;}
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 8px; color: var(--text-muted); }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid var(--border-dark); border-radius: 8px; background: var(--bg-dark); color: var(--text-light); box-sizing: border-box; outline: none; transition: border 0.3s; }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--primary-orange); }
        
        /* Buttons */
        .btn-save { width: 100%; padding: 15px; background: linear-gradient(135deg, #ff512f 0%, #f9d423 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-logout { width: 100%; padding: 15px; background: transparent; color: #ff5252; border: 2px solid #ff5252; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 20px; transition: 0.3s;}
        .btn-logout:hover { background: #ff5252; color: white; }

        /* Notifikasi */
        .alert-success { background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(76, 175, 80, 0.3); }

        /* Navigasi */
        .bottom-nav { position: fixed; bottom: 0; width: 100%; background: var(--card-dark); display: flex; justify-content: space-around; padding: 15px 0; border-top: 1px solid var(--border-dark); z-index: 20; }
        .nav-item { color: var(--text-muted); font-size: 24px; text-decoration: none; }
        .nav-item.active { color: var(--primary-orange); }
        .desktop-nav { display: none; }

        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            .desktop-nav { display: flex; gap: 30px; align-items: center; }
            .desktop-nav a { color: var(--text-muted); font-size: 20px; text-decoration: none; }
            .desktop-nav a.active { color: var(--primary-orange); }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo">Hiring</div>
        <div class="desktop-nav">
            <a href="{{ url('/applicant/home') }}"><i class="fas fa-layer-group"></i></a>
            <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
            <a href="{{ url('/applicant/profile') }}" class="active"><i class="fas fa-user"></i></a>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="profile-card">
            <h2 style="margin-top: 0; color: var(--primary-orange);">Data Diri Pelamar</h2>
            
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
                    <input type="text" name="education" value="{{ $profile->education ?? '' }}" placeholder="Contoh: Univ. Kristen Petra - Sistem Informasi">
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
                        <small style="color:#4caf50;"><i class="fas fa-check"></i> KTP sudah terunggah.</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Upload Ijazah (PDF max 2MB)</label>
                    <input type="file" name="document_ijazah" accept=".pdf">
                    @if(isset($profile->document_ijazah))
                        <small style="color:#4caf50;"><i class="fas fa-check"></i> Ijazah sudah terunggah.</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Upload CV (PDF max 2MB)</label>
                    <input type="file" name="document_cv" accept=".pdf">
                    @if(isset($profile->document_cv))
                        <small style="color:#4caf50;"><i class="fas fa-check"></i> CV sudah terunggah.</small>
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
        <a href="{{ url('/applicant/home') }}" class="nav-item"><i class="fas fa-layer-group"></i></a>
        <a href="{{ route('messages.index') }}" class="nav-item"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/applicant/profile') }}" class="nav-item active"><i class="fas fa-user"></i></a>
    </nav>

</body>
</html>