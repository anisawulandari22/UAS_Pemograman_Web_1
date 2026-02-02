<?php
session_start();

include '../koneksi/connection.php';

if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$conn = mysqli_connect("localhost", "root", "", "my_daily_glam");

if (isset($_POST['add_wishlist'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    
    $gambar_name = "";
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar_name = time() . "_" . uniqid() . "." . $extension; 
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_dir . $gambar_name);
    }

    $query_add = "INSERT INTO skincare_inventory (user_id, nama_produk, brand, jenis, status, gambar) 
                  VALUES ('$user_id', '$nama', '$brand', '$jenis', 'Wishlist', '$gambar_name')";
    mysqli_query($conn, $query_add);
    header("Location: wishlist.php");
    exit;
}

if (isset($_GET['bought_id'])) {
    $bought_id = mysqli_real_escape_string($conn, $_GET['bought_id']);
    mysqli_query($conn, "UPDATE skincare_inventory SET status = 'Aktif' WHERE id = '$bought_id' AND user_id = '$user_id'");
    header("Location: wishlist.php");
    exit;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .nav-link { padding: 12px 25px; color: #666; display: flex; align-items: center; gap: 15px; text-decoration: none; transition: 0.3s; }
        .nav-link:hover { background: var(--bg-soft); border-radius: 15px; margin: 0 10px; }
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

        .btn-add { background: var(--pink-gradient); color: white; border: none; border-radius: 30px; padding: 10px 24px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3); transition: 0.3s; }
        .btn-add:hover { transform: scale(1.05); box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4); }

        .wishlist-card { background: white; border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 10px 20px rgba(255, 182, 193, 0.1); transition: 0.3s; height: 100%; }
        .wishlist-card:hover { transform: translateY(-5px); }
        .btn-buy { background: var(--pink-gradient); color: white; border: none; border-radius: 12px; padding: 10px; width: 80%; font-weight: 600; text-decoration: none; display: inline-block; text-align: center; transition: 0.3s; }
        .btn-buy:hover { opacity: 0.9; color: white; }
    </style>
</head>
<body>

    <span class="flower flower-1">local_florist</span>
    <span class="flower flower-2">filter_vintage</span>

    <header class="top-header">
        <a href="../dashboard.php" class="text-decoration-none fw-bold" style="color:var(--pink-dark); font-size:22px;">
            <span class="material-symbols-rounded" style="vertical-align: middle;">face_retouching_natural</span> My Daily Glam
        </a>
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
                <p class="text-muted"><?php echo mysqli_num_rows($result); ?> item tersimpan di impianmu</p>
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
                            <?php 
                                $img_path = (!empty($row['gambar']) && file_exists("../uploads/".$row['gambar'])) 
                                            ? "../uploads/".$row['gambar'] 
                                            : "https://via.placeholder.com/300x300/FFF5F7/D02090?text=Beauty+Product"; 
                            ?>
                            <div style="height: 200px; overflow: hidden; background: #fdfdfd;">
                                <img src="<?php echo $img_path; ?>" class="w-100 h-100" alt="Produk" style="object-fit: cover;">
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted small mb-1 text-uppercase fw-bold"><?php echo htmlspecialchars($row['brand']); ?></p>
                                <h6 class="fw-bold mb-3"><?php echo htmlspecialchars($row['nama_produk']); ?></h6>
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <a href="wishlist.php?bought_id=<?php echo $row['id']; ?>" class="btn-buy" onclick="return confirm('Pindahkan ke koleksi utama?')">
                                        <span class="material-symbols-rounded" style="font-size: 18px; vertical-align: middle;">check_circle</span> Dibeli
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-light rounded-3 text-danger d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;" onclick="return confirm('Hapus dari wishlist?')">
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
            <div class="modal-content" style="border-radius: 25px; border: none; box-shadow: 0 15px 30px rgba(0,0,0,0.1);">
                <div class="modal-body p-5">
                    <div class="text-center mb-4">
                        <span class="material-symbols-rounded" style="font-size: 3rem; color: var(--pink-primary);">favorite</span>
                        <h4 class="fw-bold mt-2" style="color: var(--pink-dark);">Wishlist Baru</h4>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control rounded-pill px-3" placeholder="Contoh: Glow Serum" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Merek (Brand)</label>
                            <input type="text" name="brand" class="form-control rounded-pill px-3" placeholder="Contoh: Beauty Glow" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="jenis" class="form-select rounded-pill px-3">
                                <option value="Serum">Serum</option>
                                <option value="Moisturizer">Pelembab</option>
                                <option value="Toner">Toner</option>
                                <option value="Cleanser">Pembersih</option>
                                <option value="Sunscreen">Tabir Surya</option>
                                <option value="Masker">Masker</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Unggah Foto (Opsional)</label>
                            <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
if(file_exists('../includes/footer.php')) {
    require_once '../includes/footer.php';
}
?>

</body>
</html>
