<?php
$host = "localhost"; $user = "root"; $pass = ""; $db = "my_daily_glam";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!isset($_COOKIE['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$user_id = $_COOKIE['user_id'];
$nama_user = isset($_COOKIE['user_name']) ? $_COOKIE['user_name'] : 'User';

if (isset($_POST['save_mood'])) {
    $tgl = $_POST['tanggal'];
    $skor = $_POST['skor_mood']; 
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']); 
    
    $check = mysqli_query($conn, "SELECT id FROM mood_tracker WHERE user_id = '$user_id' AND tanggal = '$tgl'");
    
    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE mood_tracker SET skor_mood = '$skor', catatan = '$catatan' WHERE user_id = '$user_id' AND tanggal = '$tgl'";
    } else {
        $query = "INSERT INTO mood_tracker (user_id, skor_mood, catatan, tanggal) VALUES ('$user_id', '$skor', '$catatan', '$tgl')";
    }
    
    mysqli_query($conn, $query);
    header("Location: mood.php");
    exit;
}

$mood_data = [];
$res = mysqli_query($conn, "SELECT * FROM mood_tracker WHERE user_id = '$user_id'");
while ($row = mysqli_fetch_assoc($res)) {
    $key = date('Y-m-d', strtotime($row['tanggal']));
    $mood_data[$key] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracker - MyDailyGlam</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .nav-link:hover, .nav-link.active { color: white !important; background: var(--pink-gradient); margin: 5px 15px; border-radius: 15px; }
        .main-content { margin-left: 260px; padding: 40px; min-height: 80vh; }
        .calendar-card { background: white; border-radius: 30px; padding: 20px; box-shadow: 0 15px 35px rgba(255, 182, 193, 0.2); max-width: 450px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; }
        .day-header { text-align: center; font-weight: 700; color: var(--pink-dark); font-size: 11px; margin-bottom: 5px; }
        .day-box { aspect-ratio: 1/1; border-radius: 12px; background: #fff; border: 1px solid #FFF0F3; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; position: relative; }
        .day-box:hover { background: #FFF5F7; transform: translateY(-2px); border-color: var(--pink-primary); }
        .day-number { font-size: 12px; font-weight: 600; color: #555; z-index: 2; position: relative; }
        .mood-bg { position: absolute; font-size: 32px; z-index: 1; opacity: 0.8; font-variation-settings: 'FILL' 1; }
        .score-happy { color: #FFD700; } 
        .score-calm { color: #8FCE00; } 
        .score-neutral { color: #FFB6C1; } 
        .score-stressed { color: #A569BD; }
        .mood-selector { border: 2px solid #f8f8f8; border-radius: 20px; padding: 10px; cursor: pointer; transition: 0.3s; text-align: center; }
        .mood-selector:hover, .mood-selector.active { border-color: var(--pink-primary); background: #FFF5F7; }
        .mood-selector span { font-size: 35px; }
        .mood-label { font-size: 11px; font-weight: bold; margin-top: 5px; }
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
            <a class="nav-link" href="../dashboard.php"><span class="material-symbols-rounded">home</span> Beranda</a>
            <a class="nav-link" href="journal.php"><span class="material-symbols-rounded">auto_stories</span> Jurnal</a>
            <a class="nav-link" href="products.php"><span class="material-symbols-rounded">inventory_2</span> Produk</a>
            <a class="nav-link" href="wishlist.php"><span class="material-symbols-rounded">favorite</span> Wishlist</a>
            <a class="nav-link active" href="mood.php"><span class="material-symbols-rounded">mood</span> Mood</a>
            <a class="nav-link" href="../reports/reports.php"><span class="material-symbols-rounded">monitoring</span> Laporan</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold" style="color: var(--pink-dark);">Pelacak Mood</h2>
            <p class="text-muted">Ketuk tanggal untuk mencatat perasaanmu, <?php echo htmlspecialchars($nama_user); ?> ✨</p>
        </div>

        <div class="calendar-card">
            <h6 class="fw-bold mb-3 px-2"><?php echo date('F Y'); ?></h6>
            <div class="calendar-grid">
                <?php
                $headers = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                foreach($headers as $h) echo "<div class='day-header'>$h</div>";

                $start_date = date('Y-m-01');
                $days_in_month = date('t');
                $first_day_idx = date('w', strtotime($start_date));

                for($i=0; $i<$first_day_idx; $i++) echo "<div></div>";

                for($d=1; $d<=$days_in_month; $d++) {
                    $date_str = date('Y-m-') . sprintf("%02d", $d);
                    $has_data = isset($mood_data[$date_str]);
                    
                    $display_icon = ''; 
                    $display_class = ''; 
                    $display_score = ''; 
                    $display_note = '';

                    if($has_data) {
                        $val = $mood_data[$date_str]['skor_mood'];
                        $display_note = str_replace(["\r", "\n"], ' ', $mood_data[$date_str]['catatan']);
                        $display_score = $val; 
                        
                        if($val == '0') { 
                            $display_icon = 'sentiment_very_satisfied'; $display_class = 'score-happy'; 
                        } else if($val == '1') { 
                            $display_icon = 'sentiment_satisfied'; $display_class = 'score-calm'; 
                        } else if($val == '2') { 
                            $display_icon = 'sentiment_neutral'; $display_class = 'score-neutral'; 
                        } else if($val == '3') { 
                            $display_icon = 'sentiment_very_dissatisfied'; $display_class = 'score-stressed'; 
                        }
                    }

                    echo "
                    <div class='day-box' onclick='openMoodModal(\"$date_str\", \"$display_score\", \"".htmlspecialchars($display_note)."\")'>
                        <span class='day-number'>$d</span>";
                        if(!empty($display_icon)) {
                            echo "<span class='material-symbols-rounded mood-bg $display_class'>$display_icon</span>";
                        }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="moodModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 30px; border: none;">
                <div class="modal-body p-4 text-center">
                    <h5 class="fw-bold mb-4" style="color: var(--pink-dark);">Bagaimana keadaanmu hari ini?</h5>
                    <form method="POST">
                        <input type="hidden" name="tanggal" id="m_tanggal">
                        <input type="hidden" name="skor_mood" id="m_skor" required>
                        <div class="row g-2 mb-4">
                            <div class="col-3">
                                <div class="mood-selector" id="sel-0" onclick="setSkor(0, this)">
                                    <span class="material-symbols-rounded score-happy" style="font-variation-settings:'FILL' 1">sentiment_very_satisfied</span>
                                    <div class="mood-label">Senang</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mood-selector" id="sel-1" onclick="setSkor(1, this)">
                                    <span class="material-symbols-rounded score-calm" style="font-variation-settings:'FILL' 1">sentiment_satisfied</span>
                                    <div class="mood-label">Tenang</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mood-selector" id="sel-2" onclick="setSkor(2, this)">
                                    <span class="material-symbols-rounded score-neutral" style="font-variation-settings:'FILL' 1">sentiment_neutral</span>
                                    <div class="mood-label">Biasa Saja</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mood-selector" id="sel-3" onclick="setSkor(3, this)">
                                    <span class="material-symbols-rounded score-stressed" style="font-variation-settings:'FILL' 1">sentiment_very_dissatisfied</span>
                                    <div class="mood-label">Stres</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mb-4">
                            <label class="small fw-bold mb-2">Ada yang ingin diceritakan?</label>
                            <textarea name="catatan" id="m_catatan" class="form-control rounded-4" rows="3" placeholder="Tulis catatan..."></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="save_mood" class="btn text-white fw-bold rounded-pill p-3" style="background: var(--pink-gradient);">Simpan Mood Saya</button>
                            <button type="button" class="btn btn-light rounded-pill p-3" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const moodModalObj = new bootstrap.Modal(document.getElementById('moodModal'));
        function openMoodModal(date, score, note) {
            document.getElementById('m_tanggal').value = date;
            document.getElementById('m_skor').value = score;
            document.getElementById('m_catatan').value = note;
            
            document.querySelectorAll('.mood-selector').forEach(el => el.classList.remove('active'));
            
            if(score !== "") {
                const activeEl = document.getElementById('sel-' + score);
                if(activeEl) activeEl.classList.add('active');
            }
            moodModalObj.show();
        }
        function setSkor(val, el) {
            document.getElementById('m_skor').value = val;
            document.querySelectorAll('.mood-selector').forEach(opt => opt.classList.remove('active'));
            el.classList.add('active');
        }
    </script>

<?php
require_once '../includes/footer.php';
?>

</body>
</html>
