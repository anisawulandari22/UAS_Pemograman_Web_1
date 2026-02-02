<?php
session_start();

$is_logged_in = isset($_SESSION['is_login']) && $_SESSION['is_login'] === true;

$nama_user = $is_logged_in ? $_SESSION['username'] : "Cantik";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyDailyGlam</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --pink-primary: #FF69B4;
            --pink-light: #FFF0F5;
            --pink-gradient: linear-gradient(135deg, #FF69B4, #DA70D6);
            --pink-dark: #D02090;
            --bg-soft: #FFF5F7;
        }

        body {
            background-color: var(--bg-soft);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* --- Elemen Bunga Background --- */
        .flower {
            position: fixed;
            color: rgba(255, 182, 193, 0.2); 
            user-select: none;
            pointer-events: none;
            font-family: 'Material Symbols Rounded';
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48;
            z-index: -1;
        }
        .flower-1 { top: -50px; right: -50px; font-size: 300px; transform: rotate(20deg); }
        .flower-2 { bottom: -30px; left: -30px; font-size: 200px; transform: rotate(-15deg); }

        /* --- Top Navbar --- */
        .top-header {
            background: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #FFE4E9;
            position: sticky;
            top: 0;
            z-index: 1001;
        }
        .brand-logo {
            font-weight: 700;
            color: var(--pink-dark);
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .btn-auth-pill {
            background: var(--pink-gradient);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            border: none;
        }

        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            background: white;
            padding-top: 0;
            border-right: 1px solid #FFE4E9;
            z-index: 1000;
        }

        .nav-link {
            padding: 12px 25px;
            color: #666;
            font-weight: 500;
            display: flex;
            align-items: center; gap: 15px;
            transition: 0.3s;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            color: white !important;
            background: var(--pink-gradient);
            margin: 5px 15px;
            border-radius: 15px;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 260px;
            padding: 40px;
        }

        /* Banner Style */
        .banner-glam {
            background: var(--pink-gradient);
            border-radius: 30px; padding: 40px;
            color: white; margin-bottom: 35px;
            box-shadow: 0 10px 20px rgba(255, 105, 180, 0.2);
        }

        /* Action Cards Styling */
        .action-card {
            background: white; border: none; border-radius: 25px; padding: 20px;
            text-align: center; transition: 0.3s; cursor: pointer; height: 100%;
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.1);
            text-decoration: none; color: inherit; display: block;
        }
        .action-card:hover { transform: translateY(-5px); }
        .icon-circle {
            width: 50px; height: 50px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; margin: 0 auto 12px; color: white;
        }

        .glam-card-container {
            background: white;
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.1);
            height: 100%;
        }

        /* Mood Tracker Icons */
        .mood-icon {
            font-size: 42px !important;
            cursor: pointer;
            transition: 0.3s;
            opacity: 0.4;
        }
        .mood-icon:hover, .mood-icon.active {
            opacity: 1; transform: scale(1.2);
        }
        .mood-box { display: flex; flex-direction: column; align-items: center; cursor: pointer; }

        /* Skincare List */
        .skincare-item {
            background: #FFF9FA;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.2s;
        }
        .skincare-item:hover { background: #FFE4E9; }

        .form-check-input:checked {
            background-color: var(--pink-primary);
            border-color: var(--pink-primary);
        }

        .tag-morning { background: #FFF0A0; color: #856404; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; }
        .tag-night { background: #E0B0FF; color: #4B0082; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; }

    </style>
</head>
<body>

    <span class="flower flower-1">local_florist</span>
    <span class="flower flower-2">filter_vintage</span>

    <header class="top-header">
        <a href="dashboard.php" class="brand-logo">
            <span class="material-symbols-rounded" style="font-size: 32px;">face_retouching_natural</span>
            My Daily Glam
        </a>
        
        <?php if($is_logged_in): ?>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2 fw-semibold" style="color: var(--pink-dark);">
                    <span class="material-symbols-rounded">account_circle</span>
                    <?= htmlspecialchars($nama_user); ?>
                </div>
                <a href="logout.php" class="btn-auth-pill" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                    <span class="material-symbols-rounded" style="font-size: 20px;">logout</span> Keluar
                </a>
            </div>
        <?php else: ?>
            <a href="auth/login.php" class="btn-auth-pill">
                <span class="material-symbols-rounded" style="font-size: 20px;">login</span> Masuk
            </a>
        <?php endif; ?>
    </header>

    <div class="sidebar">
        <nav class="nav flex-column mt-2">
            <a class="nav-link active" href="dashboard.php"><span class="material-symbols-rounded">home</span> Beranda</a>
            <a class="nav-link" href="pages/journal.php"><span class="material-symbols-rounded">auto_stories</span> Jurnal</a>
            <a class="nav-link" href="pages/products.php"><span class="material-symbols-rounded">inventory_2</span> Produk</a>
            <a class="nav-link" href="pages/wishlist.php"><span class="material-symbols-rounded">favorite</span> Wishlist</a>
            <a class="nav-link" href="pages/mood.php"><span class="material-symbols-rounded">mood</span> Mood</a>
            <a class="nav-link" href="reports/reports.php"><span class="material-symbols-rounded">monitoring</span> Laporan</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="banner-glam">
            <h1 class="mb-1">Hai, <?php echo htmlspecialchars($nama_user); ?>! ✨</h1>
            <p class="mb-0">
                <?php echo $is_logged_in ? "Kulitmu bersinar hari ini. Siap untuk rutinitasmu?" : "Rawat kulitmu sekarang. Masuk untuk mencatat rutinitasmu!"; ?>
            </p>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-md">
                <a href="pages/journal.php" class="action-card" style="background: #FFF4E6;">
                    <div class="icon-circle" style="background: linear-gradient(135deg, #FFD194, #FFB347);">
                        <span class="material-symbols-rounded">auto_stories</span>
                    </div>
                    <h6 class="fw-bold mb-0">Jurnal</h6>
                </a>
            </div>
            
            <div class="col-md">
                <a href="pages/products.php" class="action-card" style="background: #F8E8FF;">
                    <div class="icon-circle" style="background: linear-gradient(135deg, #E0C3FC, #8E2DE2);">
                        <span class="material-symbols-rounded">inventory_2</span>
                    </div>
                    <h6 class="fw-bold mb-0">Produk</h6>
                </a>
            </div>

            <div class="col-md">
                <a href="pages/wishlist.php" class="action-card" style="background: #FFE8EC;">
                    <div class="icon-circle" style="background: linear-gradient(135deg, #FF9A9E, #F06292);">
                        <span class="material-symbols-rounded">favorite</span>
                    </div>
                    <h6 class="fw-bold mb-0">Wishlist</h6>
                </a>
            </div>

            <div class="col-md">
                <a href="pages/mood.php" class="action-card" style="background: #E8F4FF;">
                    <div class="icon-circle" style="background: linear-gradient(135deg, #A1C4FD, #3081ED);">
                        <span class="material-symbols-rounded">mood</span>
                    </div>
                    <h6 class="fw-bold mb-0">Mood</h6>
                </a>
            </div>

            <div class="col-md">
                <a href="reports/reports.php" class="action-card" style="background: #E0F7FA;">
                    <div class="icon-circle" style="background: linear-gradient(135deg, #4DD0E1, #00ACC1);">
                        <span class="material-symbols-rounded">monitoring</span>
                    </div>
                    <h6 class="fw-bold mb-0">Laporan</h6>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="glam-card-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">Jadwal Skincare</h5>
                        <span class="text-muted small"><?php 
                            date_default_timezone_set('Asia/Jakarta');
                            echo date('l, d F Y'); 
                        ?></span>
                    </div>
                    
                    <div class="skincare-list">
                        <div class="skincare-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="step1" checked>
                                <label class="form-check-label fw-600 ms-2" for="step1">Gentle Cleanser</label>
                            </div>
                            <span class="tag-morning">PAGI</span>
                        </div>
                        <div class="skincare-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="step2">
                                <label class="form-check-label fw-600 ms-2" for="step2">Hydrating Toner</label>
                            </div>
                            <span class="tag-morning">PAGI</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="glam-card-container text-center">
                    <h5 class="fw-bold mb-3 text-start">Pelacak Mood Harian</h5>
                    <p class="text-muted small mb-4">Bagaimana perasaanmu hari ini?</p>
                    
                    <div class="d-flex justify-content-around mb-4">
                        <div class="mood-box" onclick="setMood(this, 'Senang')">
                            <span class="material-symbols-rounded mood-icon active" style="color: #FFD700;">sentiment_very_satisfied</span>
                            <span class="small mt-2">Senang</span>
                        </div>
                        <div class="mood-box" onclick="setMood(this, 'Tenang')">
                            <span class="material-symbols-rounded mood-icon" style="color: #FFB6C1;">sentiment_satisfied</span>
                            <span class="small mt-2">Tenang</span>
                        </div>
                        <div class="mood-box" onclick="setMood(this, 'Biasa Saja')">
                            <span class="material-symbols-rounded mood-icon" style="color: #AEC6CF;">sentiment_neutral</span>
                            <span class="small mt-2">Biasa Saja</span>
                        </div>
                    </div>

                    <button onclick="saveMood()" class="btn w-100 py-3 mt-2 fw-bold" style="background: var(--pink-gradient); color: white; border-radius: 15px; border: none;">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedMood = 'Senang';

        function setMood(element, moodName) {
            document.querySelectorAll('.mood-icon').forEach(icon => {
                icon.classList.remove('active');
            });
            element.querySelector('.mood-icon').classList.add('active');
            selectedMood = moodName;
        }

        function saveMood() {
            <?php if(!$is_logged_in): ?>
                Swal.fire({
                    title: 'Ups!',
                    text: 'Kamu harus login dulu untuk menyimpan mood.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#FF69B4',
                    confirmButtonText: 'Login Sekarang'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'auth/login.php';
                    }
                });
                return;
            <?php endif; ?>

            localStorage.setItem('last_mood', selectedMood);
            Swal.fire({
                title: 'Berhasil!',
                text: `Mood "${selectedMood}" kamu telah disimpan.`,
                icon: 'success',
                confirmButtonColor: '#FF69B4',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>
