<?php
session_start();

include '../koneksi/connection.php';

if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// Inisialisasi variabel dari Session
$user_id = $_SESSION['user_id'];
$nama_user = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "my_daily_glam");

// Ambil Ringkasan Mood untuk Statistik Sederhana milik user yang sedang login
$mood_summary = mysqli_query($conn, "SELECT skor_mood, COUNT(*) as jumlah FROM mood_tracker WHERE user_id = '$user_id' GROUP BY skor_mood");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - MyDailyGlam</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    
    <style>
        :root {
            --pink-primary: #FF69B4;
            --pink-light: #FFF0F5;
            --pink-gradient: linear-gradient(135deg, #FF69B4, #DA70D6);
            --pink-dark: #D02090;
            --bg-soft: #FFF5F7;
        }

        body { background-color: var(--bg-soft); font-family: 'Poppins', sans-serif; overflow-x: hidden; position: relative; }

        .flower { position: fixed; color: rgba(255, 182, 193, 0.2); user-select: none; pointer-events: none; z-index: -1; font-family: 'Material Symbols Rounded'; font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48; }
        .flower-1 { top: -50px; right: -50px; font-size: 300px; transform: rotate(20deg); }
        .flower-2 { bottom: -30px; left: -30px; font-size: 200px; transform: rotate(-15deg); }

        .top-header { background: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #FFE4E9; position: sticky; top: 0; z-index: 1001; }
        .brand-logo { font-weight: 700; color: var(--pink-dark); font-size: 22px; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .btn-logout-pill { background: var(--pink-gradient); color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .sidebar { height: 100vh; width: 260px; position: fixed; background: white; border-right: 1px solid #FFE4E9; z-index: 1000; }
        .nav-link { padding: 12px 25px; color: #666; font-weight: 500; display: flex; align-items: center; gap: 15px; text-decoration: none; transition: 0.3s; }
        .nav-link:hover { background: var(--bg-soft); border-radius: 15px; margin: 0 10px; }
        .nav-link.active { color: white !important; background: var(--pink-gradient); margin: 5px 15px; border-radius: 15px; }
        .main-content { margin-left: 260px; padding: 40px; }

        .report-card { background: white; border-radius: 25px; padding: 25px; border: none; box-shadow: 0 10px 30px rgba(255, 182, 193, 0.1); margin-bottom: 30px; transition: 0.3s; }
        .report-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(255, 182, 193, 0.2); }
        .btn-export { border-radius: 15px; padding: 10px 20px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; text-decoration: none; }
        .btn-pdf { background-color: #FFE4E9; color: #D02090; border: 1px solid #FFB6C1; }
        .btn-excel { background-color: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7; }
        .btn-export:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <span class="flower flower-1">local_florist</span>
    <span class="flower flower-2">filter_vintage</span>

    <header class="top-header">
        <a href="../dashboard.php" class="brand-logo">
            <span class="material-symbols-rounded" style="font-size: 32px;">face_retouching_natural</span> My Daily Glam
        </a>
        <a href="../logout.php" class="btn-logout-pill">
            <span class="material-symbols-rounded" style="font-size: 20px;">logout</span> Keluar
        </a>
    </header>

    <div class="sidebar">
        <nav class="nav flex-column mt-2">
            <a class="nav-link" href="../dashboard.php">
                <span class="material-symbols-rounded">home</span> Beranda
            </a>
            <a class="nav-link" href="../pages/journal.php">
                <span class="material-symbols-rounded">auto_stories</span> Jurnal
            </a>
            <a class="nav-link" href="../pages/products.php">
                <span class="material-symbols-rounded">inventory_2</span> Produk
            </a>
            <a class="nav-link" href="../pages/wishlist.php">
                <span class="material-symbols-rounded">favorite</span> Wishlist
            </a>
            <a class="nav-link" href="../pages/mood.php">
                <span class="material-symbols-rounded">mood</span> Mood
            </a>
            <a class="nav-link active" href="reports.php">
                <span class="material-symbols-rounded">monitoring</span> Laporan
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="mb-5">
            <h2 class="fw-bold" style="color: var(--pink-dark);">Laporan & Analisis</h2>
            <p class="text-muted">Unduh laporan aktivitas harianmu, <?php echo htmlspecialchars($nama_user); ?> ✨</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 d-flex"> 
                <div class="report-card w-100 d-flex flex-column"> 
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="background: var(--pink-light); padding: 15px; border-radius: 15px; color: var(--pink-dark);">
                            <span class="material-symbols-rounded">mood</span>
                        </div>    
                        <div>
                            <h5 class="fw-bold mb-0">Mood Trend Report</h5>
                            <small class="text-muted">Analisis perasaan bulan ini</small>            
                        </div>            
                    </div> 
                    <p class="small text-muted mb-4">Lihat statistik kebahagiaanmu. Mencakup data Happy, Calm, Neutral, dan Stressed dalam format ringkas untuk membantumu memahami kondisi emosional.</p> 
                    <div class="d-flex gap-2 mt-auto"> 
                        <a href="export_mood_pdf.php" class="btn btn-export btn-pdf">
                            <span class="material-symbols-rounded">picture_as_pdf</span> PDF
                        </a>
                        <a href="export_mood_excel.php" class="btn btn-export btn-excel">
                            <span class="material-symbols-rounded">description</span> Excel
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex"> 
                <div class="report-card w-100 d-flex flex-column"> 
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="background: #E8F5E9; padding: 15px; border-radius: 15px; color: #2E7D32;">
                            <span class="material-symbols-rounded">inventory_2</span>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Product Inventory</h5>
                            <small class="text-muted">Daftar koleksi skincare & makeup</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-4">Data lengkap inventaris kecantikanmu. Mencakup nama produk, kategori, merek, dan status pemakaian untuk manajemen stok yang lebih baik.</p>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="export_products_pdf.php" class="btn btn-export btn-pdf">
                            <span class="material-symbols-rounded">picture_as_pdf</span> PDF
                        </a>
                        <a href="export_products_excel.php" class="btn btn-export btn-excel">
                            <span class="material-symbols-rounded">description</span> Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php
if(file_exists('../includes/footer.php')) {
    require_once '../includes/footer.php';
}
?>    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
