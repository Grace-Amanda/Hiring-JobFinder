<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Company Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--bg-dark:#13131a;--card-dark:#1c1c24;--border-dark:#2d2d3a;--primary-orange:#ff512f;--gradient-orange:linear-gradient(135deg,#ff512f 0%,#f09819 100%);--text-light:#ffffff;--text-muted:#a1a1aa}
        body,html{margin:0;padding:0;background:linear-gradient(135deg,#0f0f13 0%,#1a1a24 100%);color:var(--text-light);font-family:'Plus Jakarta Sans',sans-serif;min-height:100vh;display:flex;flex-direction:column}
        .bg-shapes{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
        .shape1,.shape2{position:absolute;filter:blur(50px)}
        .shape1{top:-10%;left:-10%;width:50vw;height:50vw;background:radial-gradient(circle,rgba(255,81,47,.15) 0%,transparent 60%)}
        .shape2{bottom:0;right:-10%;width:60vw;height:60vw;background:radial-gradient(circle,rgba(240,152,25,.1) 0%,transparent 60%)}
        .grid-pattern{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:40px 40px}
        
        /* STANDAR LOGO & NAV */
        .top-nav{padding:20px 5%;display:flex;justify-content:space-between;align-items:center;z-index:10;position:relative}
        .logo{font-size:28px;font-weight:800;color:var(--primary-orange);letter-spacing:-1px;text-shadow:0 4px 10px rgba(255,81,47,.3);display:flex;align-items:baseline;gap:8px}
        .logo span{font-size:14px;font-weight:500;color:var(--text-muted);letter-spacing:1px;text-transform:uppercase}
        .desktop-menu{display:none;gap:40px}
        .desktop-menu a{color:var(--text-muted);text-decoration:none;font-size:16px;font-weight:500;transition:.3s}
        .desktop-menu a.active,.desktop-menu a:hover{color:var(--text-light)}

        .main-content{flex:1;padding:20px 5% 120px;max-width:650px;margin:0 auto;width:100%;box-sizing:border-box;z-index:5;position:relative}
        .profile-card{background:rgba(28,28,36,.4);backdrop-filter:blur(20px);padding:30px;border-radius:24px;border:1px solid var(--border-dark);box-shadow:0 25px 50px -12px rgba(0,0,0,.5);margin-bottom:25px}
        
        .form-group{margin-bottom:20px}
        .form-group label{display:block;font-size:14px;font-weight:700;margin-bottom:10px;color:var(--text-muted);letter-spacing:.3px}
        .form-group input,.form-group select{width:100%;background:rgba(28,28,36,.8);backdrop-filter:blur(10px);border:1px solid var(--border-dark);border-radius:16px;color:var(--text-light);padding:15px 20px;font-size:15px;outline:0;font-family:inherit;transition:.3s;box-sizing:border-box}
        .form-group input:focus,.form-group select:focus{border-color:var(--primary-orange);box-shadow:0 0 15px rgba(255,81,47,.15)}
        
        .document-status{display:block;margin-top:8px;font-size:13px;color:#4ade80;font-weight:500}
        .text-error { display: block; margin-top: 8px; font-size: 13px; color: #f87171; font-weight: 500; }
        
        .btn-save,.btn-logout{width:100%;padding:16px;border-radius:16px;font-size:16px;font-weight:800;cursor:pointer;margin-top:10px;transition:.3s;display:flex;justify-content:center;align-items:center;gap:10px}
        .btn-save{background:var(--gradient-orange);color:#fff;border:none;box-shadow:0 10px 20px rgba(255,81,47,.2)}
        .btn-save:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(255,81,47,.4)}
        .btn-logout{background:transparent;color:#f87171;border:2px solid #f87171}
        .btn-logout:hover{background:rgba(248,113,113,.1)}
        
        .alert-success{background:rgba(74,222,128,.1);color:#4ade80;padding:15px 20px;border-radius:16px;margin-bottom:25px;border:1px solid rgba(74,222,128,.2);font-weight:500;font-size:15px}
        .alert-danger { background: rgba(248, 113, 113, 0.1); color: #f87171; padding: 15px 20px; border-radius: 16px; margin-bottom: 25px; border: 1px solid rgba(248, 113, 113, 0.2); font-weight: 500; font-size: 15px;}
        
        .bottom-nav{position:fixed;bottom:0;left:0;width:100%;background:rgba(19,19,26,.95);backdrop-filter:blur(10px);border-top:1px solid var(--border-dark);display:flex;justify-content:space-around;padding:20px 0 calc(20px + env(safe-area-inset-bottom));z-index:50}
        .bottom-nav a{color:var(--text-muted);font-size:22px;transition:.3s;text-decoration:none}
        .bottom-nav a.active{color:var(--primary-orange)}
        @media (min-width:768px){.bottom-nav{display:none}.desktop-menu{display:flex}.main-content{padding-top:40px}}
    </style>
</head>
<body>
    <div class="bg-shapes"><div class="grid-pattern"></div><div class="shape1"></div><div class="shape2"></div></div>

    <header class="top-nav">
        <div class="logo">Hiring <span>Employer</span></div>
        <div class="desktop-menu">
            <a href="{{ url('/employer/dashboard') }}">Candidates</a>
            <a href="{{ url('/employer/calendar') }}">Calendar</a>
            <a href="{{ route('messages.index') }}">Messages</a>
            <a href="{{ url('/employer/profile') }}" class="active">Profile</a>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle" style="margin-right:8px"></i> {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> Gagal menyimpan profil. Cek kembali data Anda.
            </div>
        @endif

        <div class="profile-card">
            <h2 style="margin:0 0 25px;color:var(--text-light);font-weight:800;font-size:24px;letter-spacing:-.5px">Profil Perusahaan</h2>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Status Pencarian Kandidat</label>
                    <select name="status">
                        <option value="active_searching" {{ old('status', $profile->status ?? '') == 'active_searching' ? 'selected' : '' }}>Aktif Membuka Lowongan</option>
                        <option value="unactive" {{ old('status', $profile->status ?? '') == 'unactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name ?? Auth::user()->name) }}" required>
                    @error('company_name') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Lokasi / Kota</label>
                    <input type="text" name="location_employer" value="{{ old('location_employer', $profile->location_employer ?? '') }}">
                    @error('location_employer') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Bidang Industri / Tipe Perusahaan</label>
                    <input type="text" name="company_type" value="{{ old('company_type', $profile->company_type ?? '') }}" placeholder="Misal: Information Technology, Finance...">
                    @error('company_type') <span class="text-error">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group">
                    <label>Upload NPWP Perusahaan (JPG/PNG/PDF max 2MB)</label>
                    <input type="file" name="document_npwp" accept=".jpg,.jpeg,.png,.pdf">
                    @if(isset($profile->document_npwp)) 
                        <small class="document-status"><i class="fas fa-check-circle"></i> NPWP sudah terunggah.</small> 
                    @endif
                    @error('document_npwp') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Upload Dokumen Legal / NIB (PDF max 2MB)</label>
                    <input type="file" name="document_nib" accept=".pdf,.jpg,.jpeg,.png">
                    @if(isset($profile->document_nib)) 
                        <small class="document-status"><i class="fas fa-check-circle"></i> NIB sudah terunggah.</small> 
                    @endif
                    @error('document_nib') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan Profil</button>
            </form>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf <button type="submit" class="btn-logout" onclick="localStorage.removeItem('api_token');"><i class="fas fa-sign-out-alt"></i> Logout Akun</button>
        </form>
    </main>

    <nav class="bottom-nav">
        <a href="{{ url('/employer/dashboard') }}"><i class="fas fa-users"></i></a>
        <a href="{{ url('/employer/calendar') }}"><i class="fas fa-calendar-alt"></i></a>
        <a href="{{ route('messages.index') }}"><i class="fas fa-comment-dots"></i></a>
        <a href="{{ url('/employer/profile') }}" class="active"><i class="fas fa-building"></i></a>
    </nav>
</body>
</html>