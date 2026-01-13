<?php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "my_daily_glam";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!isset($_COOKIE['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}
$user_id = $_COOKIE['user_id'];
$nama_user = $_COOKIE['user_name'];

$res = mysqli_query($conn, "SELECT * FROM skincare_inventory WHERE user_id = '$user_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventory Report - MyDailyGlam</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            color: #444; 
            margin: 0; 
            padding: 50px; 
            background: #fff; 
            position: relative;
        }

        .navigation-bar {
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
            margin-bottom: 30px !important;
        }

        .btn-back-circle {
            background-color: #FF69B4 !important;
            color: white !important;
            width: 45px !important;
            height: 45px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(255, 105, 180, 0.3) !important;
            transition: 0.3s !important;
        }

        .btn-back-circle:hover {
            background-color: #ED4C9D !important;
            transform: scale(1.1) !important;
        }

        .btn-action {
            background: linear-gradient(135deg, #FF69B4, #DA70D6) !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px !important;
            border-radius: 30px !important;
            cursor: pointer !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3) !important;
            transition: 0.3s !important;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .flower-corner {
            position: absolute;
            top: -40px;
            right: -40px;
            font-size: 250px;
            color: rgba(255, 105, 180, 0.05);
            z-index: -1;
            font-family: 'Material Symbols Rounded';
            font-variation-settings: 'FILL' 1;
        }

        .header-pdf {
            text-align: center;
            border-bottom: 3px solid #FF69B4;
            padding-bottom: 20px;
            margin-bottom: 40px;
        }

        .header-pdf h1 {
            color: #D02090;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        table { width: 100%; border-collapse: collapse; }
        th { background-color: #FF69B4; color: white; padding: 15px; text-align: left; text-transform: uppercase; font-size: 14px; }
        td { padding: 12px 15px; border-bottom: 1px solid #FFE4E9; font-size: 13px; }
        tr:nth-child(even) { background-color: #FFF9FA; }
        .price-tag { color: #D02090; font-weight: 600; }
        .exp-tag { background: #FFF0F5; color: #D02090; padding: 4px 8px; border-radius: 8px; font-weight: 600; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="flower-corner">local_florist</div>

    <div class="navigation-bar no-print">
        <a href="reports.php" class="btn-back-circle">
            <span class="material-symbols-rounded">arrow_back</span>
        </a>

        <button class="btn-action" onclick="window.print()">
            <span class="material-symbols-rounded">print</span>
            Cetak ke PDF
        </button>
    </div>

    <div class="header-pdf">
        <h1>Skincare Inventory Report</h1>
        <p>MyDailyGlam • Beauty & Self-Care Tracker</p>
    </div>

    <div class="meta-info" style="display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 13px; color: #666;">
        <div><strong>Pemilik Koleksi:</strong> <?php echo htmlspecialchars($nama_user); ?></div>
        <div><strong>Tanggal Laporan:</strong> <?php echo date('d F Y'); ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Brand</th>
                <th>Harga</th>
                <th>Tgl Kedaluwarsa</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($res && mysqli_num_rows($res) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['nama_produk']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['brand']); ?></td>
                <td class="price-tag">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><span class="exp-tag"><?php echo date('d/m/Y', strtotime($row['expired_date'])); ?></span></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align: center; padding: 20px;">Belum ada data produk.</td></tr>
        <?php endif; ?>
</tbody>
    </table>

    <div style="margin-top: 50px; text-align: center; font-size: 11px; color: #FFB6C1;">
        Generated by MyDailyGlam Application &copy; <?php echo date('Y'); ?>
    </div>

</body>
</html>
