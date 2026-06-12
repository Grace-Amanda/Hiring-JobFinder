<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiirng - Sign Up</title>
    <style>
        body { margin: 0; background: #1a1a1a; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-card { background: white; color: #333; padding: 30px; border-radius: 20px; width: 100%; max-width: 350px; box-shadow: 0 10px 25px rgba(255, 81, 47, 0.3); }
        .auth-card h2 { text-align: center; color: #ff512f; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; outline: none; }
        .btn-submit { width: 100%; padding: 12px; background: linear-gradient(90deg, #ff512f, #f9d423); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .text-center { text-align: center; margin-top: 15px; font-size: 14px; }
        .text-center a { color: #ff512f; text-decoration: none; font-weight: bold; }
        .error-msg { color: red; font-size: 12px; margin-bottom: 10px; }
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

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>What Role?</label>
                <select name="role" required>
                    <option value="" disabled selected>Pilih Peran Anda...</option>
                    <option value="applicant">Applicant (Pencari Kerja)</option>
                    <option value="employer">Employer (Perusahaan)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Full Name / Company Name</label>
                <input type="text" name="name" placeholder="Masukkan nama..." required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="contoh@email.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Ketik ulang password" required>
            </div>

            <button type="submit" class="btn-submit">Sign Up</button>
        </form>

        <div class="text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>

</body>
</html>