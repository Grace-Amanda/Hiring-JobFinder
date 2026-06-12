<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Login</title>
    <style>
        body { margin: 0; background: #1a1a1a; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-card { background: white; color: #333; padding: 30px; border-radius: 20px; width: 100%; max-width: 350px; box-shadow: 0 10px 25px rgba(255, 81, 47, 0.3); }
        .auth-card h1 { text-align: center; color: #ff512f; margin-top: 0; font-size: 28px;}
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; outline: none; }
        .btn-submit { width: 100%; padding: 12px; background: linear-gradient(90deg, #ff512f, #f9d423); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .text-center { text-align: center; margin-top: 20px; font-size: 14px; }
        .text-center a { color: #ff512f; text-decoration: none; font-weight: bold; }
        .error-msg { background: #ffcccc; color: #cc0000; padding: 10px; border-radius: 8px; font-size: 14px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>

    <div class="auth-card">
        <h1>Hiring</h1>
        
        @if ($errors->any())
            <div class="error-msg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" placeholder="Enter your email here..." required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="Enter your password here..." required>
            </div>

            <button type="submit" class="btn-submit">Next (Login)</button>
        </form>

        <div class="text-center">
            Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>

</body>
</html>