<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Sign Up</title>
    <style>
        body { margin: 0; background: #1a1a1a; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px 0; }
        .auth-card { background: white; color: #333; padding: 30px; border-radius: 20px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(255, 81, 47, 0.3); }
        .auth-card h2 { text-align: center; color: #ff512f; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; outline: none; }
        .form-group input[type="file"] { padding: 7px; font-size: 13px; }
        .btn-submit { width: 100%; padding: 12px; background: linear-gradient(90deg, #ff512f, #f9d423); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .text-center { text-align: center; margin-top: 15px; font-size: 14px; }
        .text-center a { color: #ff512f; text-decoration: none; font-weight: bold; }
        .error-msg { color: red; font-size: 12px; margin-bottom: 10px; }
        
        /* Class tambahan untuk menyembunyikan elemen */
        .hidden { display: none; }
        
        /* Desain pemisah form */
        .section-title { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 10px 0; border-bottom: 1px solid #eee; padding-bottom: 5px; }
    </style>
</head>
<body>

    <div class="auth-card">
        <h2>Create Account</h2>

        @if ($errors->any())
            <div class="error-msg">
                <ul style="padding-left: 15px; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>What Role?</label>
                <select name="role" id="role-selector" required onchange="toggleForm()">
                    <option value="" disabled selected>Pilih Peran Anda...</option>
                    <option value="applicant">Applicant (Pencari Kerja)</option>
                    <option value="employer">Employer (Perusahaan)</option>
                </select>
            </div>

            <div id="core-account-fields" class="hidden">
                <div class="section-title">Informasi Login</div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="contoh@email.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ketik ulang password">
                </div>
            </div>

            <div id="applicant-fields" class="hidden">
                <div class="section-title">Profil Pelamar</div>
                <div class="form-group">
                    <label>Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" name="full_name" placeholder="Masukkan nama asli" class="applicant-input">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" class="applicant-input">
                </div>
                <div class="form-group">
                    <label>Kota Domisili</label>
                    <input type="text" name="location_applicant" placeholder="Contoh: Surabaya" class="applicant-input">
                </div>
                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <select name="education" class="applicant-input">
                        <option value="" disabled selected>Pilih Pendidikan...</option>
                        <option value="SMA">SMA / SMK Sederajat</option>
                        <option value="D3">Diploma (D3)</option>
                        <option value="S1">Sarjana (S1)</option>
                        <option value="S2">Magister (S2)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Upload KTP (PDF)</label>
                    <input type="file" name="document_ktp" accept=".pdf" class="applicant-input">
                </div>
                <div class="form-group">
                    <label>Upload Ijazah Terakhir (PDF)</label>
                    <input type="file" name="document_ijazah" accept=".pdf" class="applicant-input">
                </div>
                <div class="form-group">
                    <label>Upload CV (PDF)</label>
                    <input type="file" name="document_cv" accept=".pdf" class="applicant-input">
                </div>
            </div>

            <div id="employer-fields" class="hidden">
                <div class="section-title">Profil Perusahaan</div>
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="company_name" placeholder="Nama PT / Instansi" class="employer-input">
                </div>
                <div class="form-group">
                    <label>Bidang Industri</label>
                    <select name="company_type" class="employer-input">
                        <option value="" disabled selected>Pilih Bidang...</option>
                        <option value="Technology">Technology / IT</option>
                        <option value="Finance">Finance & Banking</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Creative">Creative & Media</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lokasi Perusahaan</label>
                    <input type="text" name="location_employer" placeholder="Kota operasional" class="employer-input">
                </div>
                <div class="form-group">
                    <label>Upload NPWP Perusahaan (PDF)</label>
                    <input type="file" name="document_npwp" accept=".pdf" class="employer-input">
                </div>
                <div class="form-group">
                    <label>Upload Dokumen Legal/NIB (PDF)</label>
                    <input type="file" name="document_nib" accept=".pdf" class="employer-input">
                </div>
            </div>

            <button type="submit" id="submit-btn" class="btn-submit hidden">Sign Up</button>
        </form>

        <div class="text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>

    <script>
    function toggleForm() {
        const role = document.getElementById('role-selector').value;
        
        const coreFields = document.getElementById('core-account-fields');
        const applicantDiv = document.getElementById('applicant-fields');
        const employerDiv = document.getElementById('employer-fields');
        const submitBtn = document.getElementById('submit-btn');

        const coreInputs = coreFields.querySelectorAll('input');
        const applicantInputs = document.querySelectorAll('.applicant-input');
        const employerInputs = document.querySelectorAll('.employer-input');

        // Munculkan form utama
        if (role !== "") {
            coreFields.classList.remove('hidden');
            submitBtn.classList.remove('hidden');
            coreInputs.forEach(input => input.disabled = false);
        }

        if (role === 'applicant') {
            applicantDiv.classList.remove('hidden');
            employerDiv.classList.add('hidden');
            
            // Aktifkan form pelamar
            applicantInputs.forEach(input => {
                input.disabled = false; 
                input.required = true;
            });
            // MATIKAN form perusahaan (Browser akan mengabaikan ini)
            employerInputs.forEach(input => {
                input.disabled = true; 
                input.required = false;
            });
            
        } else if (role === 'employer') {
            employerDiv.classList.remove('hidden');
            applicantDiv.classList.add('hidden');
            
            // Aktifkan form perusahaan
            employerInputs.forEach(input => {
                input.disabled = false; 
                input.required = true;
            });
            // MATIKAN form pelamar (Browser akan mengabaikan ini)
            applicantInputs.forEach(input => {
                input.disabled = true; 
                input.required = false;
            });
        }
    }
</script>

</body>
</html>