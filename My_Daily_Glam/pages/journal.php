<?php
if (!isset($_COOKIE['user_id'])) {
    header("Location: ../auth/login.php"); 
    exit;
}
$nama_user = $_COOKIE['user_name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal - MyDailyGlam</title>
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
            padding: 40px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .btn-new-entry {
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
        }

        .journal-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: 0.3s;
        }
        .journal-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 182, 193, 0.2);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-box span { font-size: 30px; }

        .content-body { flex-grow: 1; }
        .entry-title { font-weight: 700; color: #333; margin-bottom: 2px; font-size: 18px; }
        .entry-meta { font-size: 13px; color: #999; margin-bottom: 8px; }
        .entry-desc { color: #666; font-size: 14px; margin-bottom: 12px; }

        .tag-container { display: flex; gap: 8px; flex-wrap: wrap; }
        .badge-tag {
            background: #FFF0F5;
            color: #D02090;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .bg-morning { background: #FFF9C4; color: #FBC02D; }
        .bg-evening { background: #E1BEE7; color: #8E24AA; }
        .bg-special { background: #F8BBD0; color: #C2185B; }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const journalList = document.querySelector('.journal-list');
            const storedJournals = JSON.parse(localStorage.getItem('my_journals')) || [];

            storedJournals.forEach(item => {
                const entryHtml = `
                    <div class="journal-card">
                        <div class="icon-box" style="background: ${item.type === 'Pagi' ? '#FFF9E6' : '#F3E5F5'};">
                            <span class="material-symbols-rounded" style="color: ${item.type === 'Pagi' ? '#FFB300' : '#9C27B0'};">
                                ${item.type === 'Pagi' ? 'wb_sunny' : 'nightlight'}
                            </span>
                        </div>
                        <div class="content-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="entry-title">${item.title}</h5>
                                <span class="status-badge ${item.type === 'Pagi' ? 'bg-morning' : 'bg-evening'}">${item.type}</span>
                            </div>
                            <p class="entry-meta">${item.date}</p>
                            <p class="entry-desc">${item.desc}</p>
                            <div class="tag-container">
                                ${item.products.split(',').map(p => `<span class="badge-tag">${p.trim()}</span>`).join('')}
                            </div>
                        </div>
                    </div>
                `;
                journalList.insertAdjacentHTML('afterbegin', entryHtml);
            });
        });
    </script>
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
            <a class="nav-link active" href="journal.php"><span class="material-symbols-rounded">auto_stories</span> Jurnal</a>
            <a class="nav-link" href="products.php"><span class="material-symbols-rounded">inventory_2</span> Produk</a>
            <a class="nav-link" href="wishlist.php"><span class="material-symbols-rounded">favorite</span> Wishlist</a>
            <a class="nav-link" href="mood.php"><span class="material-symbols-rounded">mood</span> Mood</a>
            <a class="nav-link" href="../reports/reports.php"><span class="material-symbols-rounded">monitoring</span> Laporan</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header-section">
            <div>
                <h2 class="fw-bold text-pink-dark mb-0" style="color: var(--pink-dark);">Jurnal Kecantikanku</h2>
                <p class="text-muted">Pantau perjalanan perawatan kulitmu</p>
            </div>
            <a href="add_journal.php" class="btn-new-entry">
                <span class="material-symbols-rounded">add</span> Entri Baru
            </a>
        </div>

        <div class="journal-list">
            <div class="journal-card">
                <div class="icon-box" style="background: #FFF9E6;">
                    <span class="material-symbols-rounded" style="color: #FFB300;">wb_sunny</span>
                </div>
                <div class="content-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="entry-title">Rutinitas Pagi Glowing</h5>
                        <span class="status-badge bg-morning">Pagi</span>
                    </div>
                    <p class="entry-meta">15 Des, 2025 • 08:00 WIB</p>
                    <p class="entry-desc">Segar dan siap beraktivitas!</p>
                    <div class="tag-container">
                        <span class="badge-tag">Pembersih</span>
                        <span class="badge-tag">Toner</span>
                        <span class="badge-tag">Pelembab</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const journalContainer = document.querySelector('.journal-list'); 
            const storedJournals = JSON.parse(localStorage.getItem('my_journals')) || [];

            storedJournals.forEach(item => {
                const card = `
                    <div class="journal-card mb-3 p-4 bg-white shadow-sm" style="border-radius: 20px; border-left: 5px solid ${item.type === 'Pagi' ? '#FFD194' : '#DA70D6'};">
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold">${item.title}</h5>
                            <span class="badge" style="background: #FFF0F5; color: #DA70D6;">${item.type}</span>
                        </div>
                        <p class="text-muted small">${item.date} • ${item.time || ''}</p>
                        <p>${item.desc}</p>
                        <div class="mt-2">
                            ${item.products ? item.products.split(',').map(p => `<span class="badge bg-light text-dark me-1">${p.trim()}</span>`).join('') : ''}
                        </div>
                    </div>
                `;
                journalContainer.insertAdjacentHTML('afterbegin', card);
            });
        });
    </script>
<?php
require_once '../includes/footer.php';
?>

</body>
</html>
