<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$conn = mysqli_connect("localhost", "root", "", "my_daily_glam");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; 
    $nama_produk = mysqli_real_escape_string($conn, $_POST['product_name']);
    $brand       = mysqli_real_escape_string($conn, $_POST['brand']);
    $jenis       = mysqli_real_escape_string($conn, $_POST['category']);
    $waktu_pakai = "Pagi & Malam"; 
    $status      = "Aktif";
    $expired_date = $_POST['expired_date'];

    $final_image_db = ""; 
    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "../uploads/"; 
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $image_name = $_FILES['product_image']['name'];
        $new_filename = time() . "_" . basename($image_name);
        $target_file = $target_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            $final_image_db = $new_filename; 
        }
    }

    $sql = "INSERT INTO skincare_inventory (user_id, nama_produk, brand, jenis, waktu_pakai, status, expired_date, gambar) VALUES ('$user_id', '$nama_produk', '$brand', '$jenis', '$waktu_pakai', '$status', '$expired_date', '$final_image_db')";

    if (mysqli_query($conn, $sql)) {
        $success = true;
    } else {
        $error = "Kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru - MyDailyGlam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { 
            --pink-primary: #FF85B3;
            --pink-secondary: #FF69B4;
            --pink-gradient: linear-gradient(135deg, #FF85B3, #DA70D6); 
            --bg-soft: #FFF5F7; 
        }

        body { 
            background-color: var(--bg-soft); 
            font-family: 'Poppins', sans-serif; 
            padding: 5px 20px; 
            overflow-x: hidden;
            position: relative;
        }

        .flower-icon {
            position: absolute;
            color: rgba(255, 133, 179, 0.15);
            font-size: 6rem;
            z-index: -1;
            user-select: none;
        }

        .header-section {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 15px;
            padding-top: 15px;
            padding-bottom: 10px;
        }

        .btn-back { 
            background: #fff; 
            border: 1px solid #FFE4E8; 
            border-radius: 50%; 
            width: 42px; height: 42px; 
            display: flex; align-items: center; justify-content: center; 
            text-decoration: none; color: var(--pink-primary); 
            flex-shrink: 0; transition: 0.3s;
        }

        .btn-back:hover { background: var(--pink-primary); color: white; }

        .form-container { 
            background: white; 
            border-radius: 30px; 
            padding: 30px 40px; 
            max-width: 600px; 
            margin: 10px auto 30px; 
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.1); 
            position: relative; z-index: 1;
        }

        .upload-area {
            border: 2px dashed #FFE4E8;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 20px;
            color: #888;
        }
        .upload-area:hover { background: #FFF0F5; border-color: var(--pink-primary); }

        .btn-category { 
            border: 1px solid #FFE4E8; 
            border-radius: 15px; 
            padding: 8px 12px; 
            transition: 0.3s; 
            background: white; 
            color: #888; 
            font-size: 0.85rem;
            flex: 1 0 30%;
        }

        .btn-category.active { 
            border-color: var(--pink-primary); 
            color: var(--pink-primary) !important; 
            background: #FFF0F5; 
            font-weight: 600; 
        }

        .form-control { border-radius: 12px; border: 1px solid #FFE4E8; padding: 12px; font-size: 0.9rem; }
        .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(255, 133, 179, 0.25); border-color: var(--pink-primary); }

        .btn-save { 
            background: var(--pink-gradient); 
            color: white; border: none; border-radius: 25px; 
            padding: 12px 30px; font-weight: 600; 
            transition: 0.3s; flex: 1;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(218, 112, 214, 0.4); }

        h2 { color: #DA70D6; margin: 0; font-size: 1.6rem; }
        p.text-muted { margin: 0; font-size: 0.85rem; }
        label { color: #8b5cf6; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; display: block;}
    </style>
</head>
<body>

    <span class="material-symbols-rounded flower-icon" style="top: -20px; left: -20px;">local_florist</span>
    <span class="material-symbols-rounded flower-icon" style="bottom: 20px; right: -20px;">filter_vintage</span>

    <div class="container">
        <div class="header-section">
            <a href="../dashboard.php" class="btn-back">
                <span class="material-symbols-rounded">arrow_back</span>
            </a>
            <div>
                <h2 class="fw-bold">Tambah Produk Baru</h2>
                <p class="text-muted">Tambahkan ke koleksi kecantikanmu</p>
            </div>
        </div>

        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                
                <label>Gambar Produk</label>
                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                    <span class="material-symbols-rounded" style="font-size: 40px; color: var(--pink-primary);">upload_file</span>
                    <p class="mb-0 mt-2" id="fileNameDisplay">Klik untuk unggah gambar</p>
                    <small class="text-muted">PNG, JPG hingga 5MB</small>
                    <input type="file" name="product_image" id="fileInput" hidden accept="image/*" onchange="updateFileName(this)">
                </div>

                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="product_name" class="form-control" placeholder="misal: Glow Serum" required>
                </div>

                <div class="mb-3">
                    <label>Merek</label>
                    <input type="text" name="brand" class="form-control" placeholder="misal: Beauty Glow">
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="hidden" name="category" id="selectedCategory" value="Pembersih">
                    <div class="d-flex flex-wrap gap-2">
                        <?php 
                        $cats = ['Pembersih', 'Toner', 'Serum', 'Pelembab', 'Tabir Surya', 'Masker', 'Lainnya'];
                        foreach($cats as $index => $c): ?>
                            <button type="button" class="btn-category <?= $index==0 ? 'active' : '' ?>" onclick="setCategory(this, '<?= $c ?>')"><?= $c ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" placeholder="misal: 45000">
                </div>

                <div class="mb-3">
                    <label>Tanggal Kedaluwarsa</label>
                    <input type="date" name="expired_date" class="form-control" required>
                    <small class="text-muted" style="font-size: 0.75rem;">Penting untuk memantau keamanan produkmu ✨</small>
                </div>

                <div class="mb-4">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Bahan utama, cara pakai, manfaat..."></textarea>
                </div>

                <div class="d-flex gap-3 mt-2">
                    <a href="products.php" class="btn btn-light py-2" style="border-radius: 25px; color: #888; border: 1px solid #eee; flex: 1; display: flex; align-items: center; justify-content: center;">Batal</a>
                    <button type="submit" class="btn-save">✨ Tambah Produk</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setCategory(btn, val) {
            document.querySelectorAll('.btn-category').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('selectedCategory').value = val;
        }

        function updateFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('fileNameDisplay').innerText = input.files[0].name;
            }
        }

        <?php if(isset($success)): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Produk baru telah ditambahkan ke inventaris Anda.',
            icon: 'success',
            confirmButtonColor: '#FF69B4'
        }).then(() => {
            window.location.href = 'products.php';
        });
        <?php elseif(isset($error)): ?>
        Swal.fire({
            title: 'Kesalahan!',
            text: '<?= $error ?>',
            icon: 'error',
            confirmButtonColor: '#FF69B4'
        });
        <?php endif; ?>
    </script>
</body>
</html>
