<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyDailyGlam</title>
    <link rel="stylesheet" href="../assets/style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <style>
        body, html { height: 100%; margin: 0; font-family: 'Poppins', sans-serif; overflow: hidden; }
 
        
        .bg-gradient-custom {
            background: linear-gradient(180deg, #FFE4E1 0%, #FFC0CB 100%);
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .flower {
            position: absolute;
            color: rgba(255, 255, 255, 0.5); 
            user-select: none;
            pointer-events: none;
            font-family: 'Material Symbols Rounded';
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48;
            z-index: 1;
        }
        
        .flower-top { 
            top: -90px; 
            right: -40px; 
            font-size: 200px;
        }

        .flower-bottom { 
            bottom: -50px; 
            left: -30px; 
            font-size: 120px; 
        }

        .glam-card {
            background: white; border-radius: 40px; padding: 40px; width: 90%; max-width: 450px;
            box-shadow: 0 15px 35px rgba(255, 182, 193, 0.2); z-index: 10; text-align: center;
        }

        .icon-header {
            width: 90px; height: 90px; background: linear-gradient(135deg, #FF69B4, #DA70D6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; color: white;
        }

        h2 { color: #D02090; font-weight: 700; font-size: 28px; margin-bottom: 5px; }
        .subtitle { color: #9e9e9e; font-size: 13px; margin-bottom: 35px; }

        .input-label { text-align: left; font-weight: 700; color: #333; font-size: 14px; margin-bottom: 8px; display: block; }
        .input-group-custom { position: relative; margin-bottom: 20px; }
        .prefix-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #FF4081; font-size: 22px; z-index: 5; }

        .form-control {
            background-color: #FFF5F7 !important; border-radius: 20px !important;
            border: 1px solid #FFE4E9 !important; padding: 15px 15px 15px 50px !important;
            font-size: 14px; height: 55px;
        }

        .suffix-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #FF69B4; cursor: pointer; border: none; background: none; z-index: 5; }

        .btn-glam {
            width: 100%; height: 60px; background: #F06292; border: none; border-radius: 20px;
            color: white; font-weight: 700; font-size: 18px; margin-top: 10px;
        }

        .footer-link { margin-top: 25px; font-size: 14px; }
        .footer-link a { color: #FF1493; font-weight: 700; text-decoration: none; }
    </style>
</head>
<body>
    <div class="bg-gradient-custom">
        <span class="flower flower-top">local_florist</span>
        
        <span class="flower flower-bottom">filter_vintage</span>

        <div class="glam-card">
            <div class="icon-header">
                <span class="material-symbols-rounded" style="font-size: 55px;">face_retouching_natural</span>
            </div>
            <h2>Selamat Datang!</h2>
            <p class="subtitle">Login untuk melanjutkan perjalanan glam anda ✨</p>
            
            <form action="login_process.php" method="POST">
                <label class="input-label">Email</label>
                <div class="input-group-custom">
                    <span class="material-symbols-rounded prefix-icon">mail</span>
                    <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                </div>
                <label class="input-label">Password</label>
                <div class="input-group-custom">
                    <span class="material-symbols-rounded prefix-icon">lock</span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                    <button type="button" class="suffix-icon" onclick="togglePassword()"><span class="material-symbols-rounded" id="toggleIcon">visibility_off</span></button>
                </div>
                <button type="submit" class="btn-glam">Login</button>
            </form>
            <div class="footer-link">Belum punya akun? <a href="register.php">Daftar di sini</a></div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const pw = document.getElementById('password'); const icon = document.getElementById('toggleIcon');
            if (pw.type === 'password') { pw.type = 'text'; icon.textContent = 'visibility'; } 
            else { pw.type = 'password'; icon.textContent = 'visibility_off'; }
        }
    </script>

<?php
require_once '../includes/footer.php';
?>

</body>
</html>
