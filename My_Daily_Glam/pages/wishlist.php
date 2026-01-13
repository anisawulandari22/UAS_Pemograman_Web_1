<?php
$host = "localhost"; $user = "root"; $pass = ""; $db = "my_daily_glam";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!isset($_COOKIE['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$user_id = $_COOKIE['user_id'];

if (isset($_POST['add_wishlist'])) {
    $nama = $_POST['nama_produk'];
    $brand = $_POST['brand'];
    $jenis = $_POST['jenis'];
    $query_add = "INSERT INTO skincare_inventory (user_id, nama_produk, brand, jenis, status) 
                  VALUES ('$user_id', '$nama', '$brand', '$jenis', 'Wishlist')";
    mysqli_query($conn, $query_add);
    header("Location: wishlist.php");
}

$query = "SELECT * FROM skincare_inventory WHERE user_id = '$user_id' AND status = 'Wishlist' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - MyDailyGlam</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    
    <style>
        :root {
            --pink-primary: #FF69B4;
            --pink-gradient: linear-gradient(135deg, #FF69B4, #DA70D6);
            --pink-dark: #D02090;
            --bg-soft: #FFF5F7;
        }

        body { background-color: var(--bg-soft); font-family: 'Poppins', sans-serif; overflow-x: hidden; position: relative; }

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

        .sidebar { height: 100vh; width: 260px; position: fixed; background: white; border-right: 1px solid #FFE4E9; z-index: 1000; }
        .nav-link { padding: 12px 25px; color: #666; display: flex; align-items: center; gap: 15px; text-decoration: none; }
        .nav-link.active { color: white !important; background: var(--pink-gradient); margin: 5px 15px; border-radius: 15px; }
        
        .main-content { margin-left: 260px; padding: 40px; }
        .top-header { background: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #FFE4E9; position: sticky; top: 0; z-index: 1001; }

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

        .btn-add { background: var(--pink-gradient); color: white; border: none; border-radius: 30px; padding: 10px 24px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3); }

        .wishlist-card { background: white; border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 10px 20px rgba(255, 182, 193, 0.1); transition: 0.3s; }
        .wishlist-card:hover { transform: translateY(-5px); }
        .btn-buy { background: var(--pink-gradient); color: white; border: none; border-radius: 12px; padding: 10px; width: 80%; font-weight: 600; text-decoration: none; display: inline-block; text-align: center; }
    </style>
</head>
<body>

    <span class="flower flower-1">local_florist</span>
    <span class="flower flower-2">filter_vintage</span>

    <header class="top-header">
        <a href="../dashboard.php" class="text-decoration-none fw-bold" style="color:var(--pink-dark); font-size:22px;">My Daily Glam</a>
        <a href="../logout.php" class="btn-logout-pill">
            <span class="material-symbols-rounded" style="font-size: 20px;">logout</span> Keluar
        </a>
    </header>

    <div class="sidebar">
        <nav class="nav flex-column mt-2">
            <a class="nav-link" href="../dashboard.php"><span class="material-symbols-rounded">home</span> Beranda</a>
            <a class="nav-link" href="journal.php"><span class="material-symbols-rounded">auto_stories</span> Jurnal</a>
            <a class="nav-link" href="products.php"><span class="material-symbols-rounded">inventory_2</span> Produk</a>
            <a class="nav-link active" href="wishlist.php"><span class="material-symbols-rounded">favorite</span> Wishlist</a>
            <a class="nav-link" href="mood.php"><span class="material-symbols-rounded">mood</span> Mood</a>
            <a class="nav-link" href="../reports/reports.php"><span class="material-symbols-rounded">monitoring</span> Laporan</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-bold" style="color: var(--pink-dark);">Wishlist Saya</h2>
                <p class="text-muted"><?php echo mysqli_num_rows($result); ?> item tersimpan</p>
            </div>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addWishlistModal">
                <span class="material-symbols-rounded">add</span> Tambah Wishlist
            </button>
        </div>

        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="wishlist-card">
                            <img src="https://via.placeholder.com/300x300/FFF5F7/D02090?text=Beauty" class="card-img-top" alt="Produk">
                            <div class="card-body p-4">
                                <p class="text-muted small mb-1"><?php echo $row['brand']; ?></p>
                                <h6 class="fw-bold mb-3"><?php echo $row['nama_produk']; ?></h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn-buy">Beli Sekarang</button>
                                    <a href="delete_wishlist.php?id=<?php echo $row['id']; ?>" class="btn btn-light rounded-3 text-danger" onclick="return confirm('Hapus dari wishlist?')">
                                        <span class="material-symbols-rounded">delete</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 mt-5">
                    <span class="material-symbols-rounded" style="font-size: 4rem; color: #ddd; display: block; margin-bottom: 20px;">heart_broken</span>
                    <p class="text-muted">Wishlist masih kosong. Yuk, cari produk impianmu!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="addWishlistModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 25px; border: none;">
                <div class="modal-body p-5">
                    <h4 class="fw-bold mb-4" style="color: var(--pink-dark);">Wishlist Baru</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control rounded-pill" placeholder="Contoh: Glow Serum" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Merek (Brand)</label>
                            <input type="text" name="brand" class="form-control rounded-pill" placeholder="Contoh: Beauty Glow" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="jenis" class="form-select rounded-pill">
                                <option value="Serum">Serum</option>
                                <option value="Moisturizer">Pelembab (Moisturizer)</option>
                                <option value="Toner">Toner</option>
                                <option value="Cleanser">Pembersih (Cleanser)</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="add_wishlist" class="btn text-white fw-bold rounded-pill" style="background: var(--pink-gradient); padding: 12px;">Simpan ke Wishlist</button>
                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<?php
require_once '../includes/footer.php';
?>

</body>
</html>
