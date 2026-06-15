<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring - Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #09090b; --card-dark: #121214; --border-dark: #27272a;
            --primary-orange: #ff512f; --gradient-orange: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
            --text-light: #ffffff; --text-muted: #a1a1aa;
        }
        
        body { margin: 0; padding: 0; background: var(--bg-dark); color: var(--text-light); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; overflow-x: hidden; }

        .bg-shapes { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
        .shape1 { position: absolute; top: -20%; left: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,81,47,0.15) 0%, transparent 60%); filter: blur(60px); }
        .shape2 { position: absolute; bottom: -20%; right: -10%; width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(240,152,25,0.1) 0%, transparent 60%); filter: blur(60px); }

        .auth-container { background: rgba(18, 18, 20, 0.6); backdrop-filter: blur(20px); border: 1px solid var(--border-dark); border-radius: 24px; padding: 40px; width: 100%; max-width: 450px; z-index: 10; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8); }
        
        .auth-header { text-align: center; margin-bottom: 30px; }
        .auth-logo { font-size: 32px; font-weight: 800; color: var(--primary-orange); letter-spacing: -1px; margin-bottom: 10px; text-shadow: 0 4px 10px rgba(255,81,47,0.3); }
        .auth-subtitle { color: var(--text-muted); font-size: 15px; }

        /* Notification Alerts */
        .alert-success { background: rgba(74, 222, 128, 0.1); border: 1px solid rgba(74, 222, 128, 0.3); color: #4ade80; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px; animation: slideDown 0.5s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .alert-error { background: rgba(248, 113, 113, 0.1); border: 1px solid rgba(248, 113, 113, 0.3); color: #f87171; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px; }

        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { display: block; font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
        .form-group input { width: 100%; padding: 15px 15px 15px 45px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-dark); border-radius: 12px; color: var(--text-light); font-size: 15px; font-family: inherit; box-sizing: border-box; transition: all 0.3s ease; outline: none; }
        .form-group input:focus { border-color: var(--primary-orange); background: rgba(255,81,47,0.05); }
        .form-group i { position: absolute; left: 18px; top: 43px; color: var(--text-muted); font-size: 16px; transition: 0.3s; }
        .form-group input:focus + i { color: var(--primary-orange); }

        .btn-submit { width: 100%; padding: 15px; border: none; border-radius: 12px; background: var(--gradient-orange); color: white; font-size: 16px; font-weight: 800; font-family: inherit; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 10px 20px rgba(255,81,47,0.3); margin-top: 10px; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 15px 25px rgba(255,81,47,0.4); }
        .btn-submit:active { transform: translateY(0); }

        .auth-footer { text-align: center; margin-top: 25px; font-size: 14px; color: var(--text-muted); }
        .auth-footer a { color: var(--primary-orange); text-decoration: none; font-weight: 700; transition: 0.3s; }
        .auth-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="shape1"></div>
        <div class="shape2"></div>
    </div>

    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">Hiring</div>
            <div class="auth-subtitle">Welcome back! Please sign in to continue.</div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> Invalid email address or password.
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="name@email.com" required autofocus>
                <i class="fas fa-envelope"></i>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <i class="fas fa-lock"></i>
            </div>

            <button type="submit" class="btn-submit">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
        </div>
    </div>

</body>
</html>