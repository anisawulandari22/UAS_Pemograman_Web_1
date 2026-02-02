<?php
session_start();

include '../koneksi/connection.php';

if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$nama_user = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

$conn = mysqli_connect("localhost", "root", "", "my_daily_glam");
$query = "SELECT * FROM skincare_inventory WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Saya - MyDailyGlam</title>
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

        body {
            background-color: var(--bg-soft);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            position: relative;
        }

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
        .btn-logout-pill {
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
        }
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            background: white;
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

        .main-content {
            margin-left: 260px;
            padding: 20px 40px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .btn-add-product {
            background: var(--pink-gradient);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-add-product:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
        }

        .search-container {
            position: relative;
            margin-bottom: 30px;
        }
        .search-input {
            width: 100%;
            padding: 15px 25px 15px 50px;
            border-radius: 20px;
            border: 1px solid #FFE4E9;
            background: white;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.05);
        }
        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--pink-primary);
        }

        .product-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            border: none;
            transition: 0.3s;
            height: 100%;
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.1);
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.15);
        }
        .brand-name {
            font-size: 0.75rem;
            color: var(--pink-primary);
            font-weight: 700;
            text-transform: uppercase;
        }
        .product-title {
            font-weight: 600;
            color: #444;
            margin: 5px 0;
        }
        .badge-category {
            background: var(--pink-light);
            color: var(--pink-primary);
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 10px;
            font-weight: 700;
        }
        .wishlist-icon {
            position: absolute;
            top: 15px; right: 15px;
            background: white;
            width: 35px; height: 35px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #eee; cursor: pointer; transition: 0.3s;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            z-index: 2;
        }
        .wishlist-icon.active { color: var(--pink-primary); }
    </style>
</head>
<body>

    <span class="flower flower-1">local_florist</span>
    <span class="flower flower-2">filter_vintage</span>

    <header class="top-header">
        <a href="../dashboard.php" class="brand-logo">
            <span class="material-symbols-rounded" style="font-size: 32px;">face_retouching_natural</span>
            My Daily Glam
        </a>
        <a href="../logout.php" class="btn-logout-pill">
            <span class="material-symbols-rounded" style="font-size: 20px;">logout</span> Keluar
        </a>
    </header>

    <div class="sidebar">
        <nav class="nav flex-column mt-2">
            <a class="nav-link" href="../dashboard.php"><span class="material-symbols-rounded">home</span> Beranda</a>
            <a class="nav-link" href="journal.php"><span class="material-symbols-rounded">auto_stories</span> Jurnal</a>
            <a class="nav-link active" href="products.php"><span class="material-symbols-rounded">inventory_2</span> Produk</a>
            <a class="nav-link" href="wishlist.php"><span class="material-symbols-rounded">favorite</span> Wishlist</a>
            <a class="nav-link" href="mood.php"><span class="material-symbols-rounded">mood</span> Mood</a>
            <a class="nav-link" href="../reports/reports.php"><span class="material-symbols-rounded">monitoring</span> Laporan</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header-section">
            <div>
                <h2 class="fw-bold mb-0" style="color: var(--pink-dark);">Produk Saya</h2>
                <p class="text-muted">Kelola koleksi produk kecantikanmu, <?= htmlspecialchars($nama_user) ?></p>
            </div>
            <a href="add_products.php" class="btn-add-product">
                <span class="material-symbols-rounded">add</span> Tambah Produk
            </a>
        </div>

        <div class="search-container">
            <span class="material-symbols-rounded search-icon">search</span>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari nama produk atau merek...">
        </div>

        <div class="row g-4" id="productGrid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 col-lg-3 product-item">
                        <div class="product-card">
                            <div class="wishlist-icon">
                                <span class="material-symbols-rounded">favorite</span>
                            </div>

                            <div style="background-color: #FFF5F7; height: 180px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <?php 
                                $path_gambar = "../uploads/" . $row['gambar'];
                                if (!empty($row['gambar']) && file_exists($path_gambar)): 
                                ?>
                                    <img src="<?php echo $path_gambar; ?>" 
                                        alt="Produk" 
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <span class="material-symbols-rounded" style="font-size: 5rem; color: #FFD1DC; opacity: 0.6;">sanitizer</span>
                                <?php endif; ?>
                            </div>

                            <div class="p-3">
                                <div class="brand-name"><?= htmlspecialchars($row['brand']) ?></div>
                                <h6 class="product-title"><?= htmlspecialchars($row['nama_produk']) ?></h6>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <span class="badge-category"><?= htmlspecialchars($row['jenis']) ?></span>
                                    <small class="text-muted" style="font-size: 11px;">🕒 <?= $row['waktu_pakai'] ?></small>
                                </div>
                                
                                <div class="d-flex gap-2 mt-3 pt-3 border-top">
                                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary w-50" style="border-radius: 10px; font-size: 12px;">
                                        <span class="material-symbols-rounded" style="font-size: 16px; vertical-align: middle;">edit</span> Edit
                                    </a>
                                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger w-50" style="border-radius: 10px; font-size: 12px;" onclick="return confirm('Apakah kamu yakin ingin menghapus produk ini?')">
                                        <span class="material-symbols-rounded" style="font-size: 16px; vertical-align: middle;">delete</span> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 mt-5"> 
                    <span class="material-symbols-rounded" style="font-size: 4rem; color: #ddd; display: block; margin-bottom: 20px;">inventory_2</span>
                    <p class="text-muted">Belum ada produk. Yuk, tambah produk pertamamu!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.product-item');
            
            items.forEach(item => {
                let text = item.innerText.toLowerCase();
                item.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>

<?php
if(file_exists('../includes/footer.php')) {
    require_once '../includes/footer.php';
}
?>

</body>
</html>
