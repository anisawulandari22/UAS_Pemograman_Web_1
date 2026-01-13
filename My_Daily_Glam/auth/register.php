<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MyDailyGlam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

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
            color: rgba(255, 255, 255, 0.4);
            user-select: none;
            font-family: 'Material Symbols Rounded';
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px; 
            width: 90%;
            max-width: 400px; 
            box-shadow: 0 20px 40px rgba(255, 20, 147, 0.1);
            z-index: 10;
            text-align: center;
            border: none;
        }

        .icon-header {
            width: 80px;
            height: 80px;
            background: linear-gradient(to bottom right, #FF69B4, #DA70D6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            box-shadow: 0 8px 15px rgba(218, 112, 214, 0.3);
        }

        h2 { 
            color: #D02090; 
            font-weight: 700; 
            font-size: 26px; 
            margin-bottom: 5px;
        }
        
        .subtitle { 
            color: #9e9e9e; 
            font-size: 14px; 
            margin-bottom: 35px; 
        }

        .input-label {
            text-align: left;
            font-weight: 700;
            color: #424242;
            font-size: 14px;
            margin-bottom: 8px;
            padding-left: 4px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: rgba(255, 20, 147, 0.05) !important;
            border-radius: 15px !important;
            border: 1px solid rgba(255, 20, 147, 0.1) !important;
            padding: 15px 20px 15px 45px !important;
            font-size: 14px;
            height: 55px;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #FF1493 !important;
            box-shadow: none;
        }

        .prefix-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #FF69B4;
            z-index: 5;
            font-size: 22px;
        }

        .suffix-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 20, 147, 0.7);
            cursor: pointer;
            background: none;
            border: none;
            z-index: 5;
        }

        .btn-glam {
            width: 100%;
            height: 55px;
            background: linear-gradient(to right, #FF1493, #FF69B4);
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: 700;
            font-size: 18px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-glam:active {
            transform: scale(0.98);
        }

        .footer-link { 
            margin-top: 20px; 
            font-size: 14px; 
            color: #757575; 
        }
        
        .footer-link a { 
            color: #FF1493; 
            font-weight: 700; 
            text-decoration: none; 
        }

        .custom-footer {
            position: absolute; 
            bottom: 0px;       
            left: 0;            
            width: 100%;         
            text-align: center;  
            font-size: 11px;
            color: #a1a1a1;
            font-family: 'Poppins', sans-serif;
            padding: 0px 0;
            z-index: 10;
        }
    </style>
</head>
<body>

    <div class="bg-gradient-custom">
        <div class="flower flower-top">local_florist</div>
        <div class="flower flower-bottom">filter_vintage</div>

        <div class="glam-card shadow-lg">
            <div class="icon-header">
                <span class="material-symbols-rounded" style="font-size: 50px;">person_add</span>
            </div>
            
            <h2>Buat Akun Glam</h2>
            <p class="subtitle">Mulai perjalanan glam anda hari ini ✨</p>
            
            <form action="register_process.php" method="POST">
                <label class="input-label">Nama Lengkap</label>
                <div class="input-group-custom">
                    <span class="material-symbols-rounded prefix-icon">person_outline</span>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama anda" required>
                </div>

                <label class="input-label">Email</label>
                <div class="input-group-custom">
                    <span class="material-symbols-rounded prefix-icon">email</span>
                    <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                </div>
                
                <label class="input-label">Password</label>
                <div class="input-group-custom">
                    <span class="material-symbols-rounded prefix-icon">lock_outline</span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                    <button type="button" class="suffix-icon" onclick="togglePass()">
                        <span class="material-symbols-rounded" id="eyeIcon">visibility_off</span>
                    </button>
                </div>
                
                <button type="submit" class="btn-glam">Daftar</button>
            </form>
            
            <div class="footer-link">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    </script>

<?php
require_once '../includes/footer.php';
?>

</body>
</html>
