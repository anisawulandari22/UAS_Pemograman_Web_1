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
$nama_user = isset($_COOKIE['user_name']) ? $_COOKIE['user_name'] : "User";

$res = mysqli_query($conn, "SELECT * FROM mood_tracker WHERE user_id = '$user_id' ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Mood - MyDailyGlam</title>
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

        table { width: 100%; border-collapse: collapse; }
        th { background-color: #FF69B4; color: white; padding: 15px; text-align: left; text-transform: uppercase; font-size: 14px; }
        td { padding: 12px 15px; border-bottom: 1px solid #FFE4E9; font-size: 13px; }
        tr:nth-child(even) { background-color: #FFF9FA; }

        .mood-tag {
            padding: 5px 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }
        .happy { background: #FFD700; color: #856404; }
        .calm { background: #90EE90; color: #006400; }
        .neutral { background: #FFB6C1; color: #D02090; }
        .stressed { background: #A9A9A9; color: white; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="navigation-bar no-print">
        <a href="reports.php" class="btn-back-circle">
            <span class="material-symbols-rounded">arrow_back</span>
        </a>

        <button class="btn-action" onclick="window.print()">
            <span class="material-symbols-rounded">print</span>
            Cetak ke PDF
        </button>
    </div>

    <div class="header-pdf" style="text-align: center; border-bottom: 3px solid #FF69B4; padding-bottom: 20px; margin-bottom: 40px;">
        <h1 style="color: #D02090; margin: 0; font-size: 28px;">Mood Analysis Report</h1>
        <p style="color: #FF69B4; margin: 5px 0 0; font-style: italic;">MyDailyGlam • Glow from the inside out</p>
    </div>

    <div class="meta-info" style="display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 13px; color: #666;">
        <div><strong>Nama Pengguna:</strong> <?php echo htmlspecialchars($nama_user); ?></div>
        <div><strong>Tanggal Laporan:</strong> <?php echo date('d F Y'); ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keadaan Mood</th>
                <th>Catatan Harian</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($res)): 
                $skor = $row['skor_mood'];
  
                if($skor == '0') { $mood_text = "Happy"; $class="happy"; }
                elseif($skor == '1') { $mood_text = "Calm"; $class="calm"; }
                elseif($skor == '2') { $mood_text = "Neutral"; $class="neutral"; }
                elseif($skor == '3') { $mood_text = "Stressed"; $class="stressed"; }
                else { $mood_text = "Unknown"; $class="neutral"; }
            ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                <td><span class="mood-tag <?php echo $class; ?>"><?php echo $mood_text; ?></span></td>
                <td><?php echo htmlspecialchars($row['catatan']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center; font-size: 11px; color: #FFB6C1;">
        Generated by MyDailyGlam Application &copy; <?php echo date('Y'); ?>
    </div>

</body>
</html>
