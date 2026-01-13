<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Catatan Jurnal Baru - MyDailyGlam</title>
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
            color: rgba(255, 133, 179, 0.2);
            font-size: 5rem;
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
            width: 42px; 
            height: 42px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            text-decoration: none; 
            color: var(--pink-primary); 
            flex-shrink: 0;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: var(--pink-primary);
            color: white;
        }

        .form-container { 
            background: white; 
            border-radius: 30px; 
            padding: 30px 40px; 
            max-width: 600px; 
            margin: 10px auto 30px; 
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.1); 
            position: relative;
            z-index: 1;
        }

        .btn-type { 
            border: 1px solid #FFE4E8; 
            border-radius: 15px; 
            padding: 10px 15px; 
            transition: 0.3s; 
            background: white; 
            color: #888; 
            flex: 1;
            font-size: 0.9rem;
        }

        .btn-type.active { 
            border-color: var(--pink-primary); 
            color: var(--pink-primary) !important; 
            background: #FFF0F5; 
            font-weight: 600; 
        }

        .form-control { 
            border-radius: 12px; 
            border: 1px solid #FFE4E8; 
            padding: 12px; 
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 133, 179, 0.25);
            border-color: var(--pink-primary);
        }

        .btn-save { 
            background: var(--pink-gradient); 
            color: white; 
            border: none; 
            border-radius: 25px; 
            padding: 12px 30px; 
            font-weight: 600; 
            transition: 0.3s;
            flex: 1;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(218, 112, 214, 0.4);
        }

        h2 { color: #DA70D6; margin: 0; font-size: 1.6rem; text-align: left; }
        p.text-muted { margin: 0; font-size: 0.9rem; text-align: left; }
        label { color: #8b5cf6; font-size: 0.9rem; } 
    </style>
</head>
<body>

    <span class="material-symbols-rounded flower-icon" style="top: 2%; left: 5%;">local_florist</span>
    <span class="material-symbols-rounded flower-icon" style="bottom: 10%; right: 5%;">filter_vintage</span>

    <div class="container">
        <div class="header-section">
            <a href="journal.php" class="btn-back">
                <span class="material-symbols-rounded">arrow_back</span>
            </a>
            <div>
                <h2 class="fw-bold">Catatan Jurnal Baru</h2>
                <p class="text-muted">Dokumentasikan rutinitas kecantikanmu</p>
            </div>
        </div>

        <div class="form-container">
            <form id="journalForm">
                <div class="mb-4">
                    <label class="fw-bold mb-2">Judul Catatan</label>
                    <input type="text" id="title" class="form-control" placeholder="misal: Rutinitas Pagi Glowing" required>
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2">Tipe Rutinitas</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-type active" onclick="setType(this, 'Pagi')">Pagi</button>
                        <button type="button" class="btn-type" onclick="setType(this, 'Malam')">Malam</button>
                        <button type="button" class="btn-type" onclick="setType(this, 'Spesial')">Spesial</button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2">Produk yang Digunakan</label>
                    <input type="text" id="products" class="form-control" placeholder="misal: Pembersih, Toner, Pelembab">
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2">Bagaimana kondisi kulitmu?</label>
                    <textarea id="desc" class="form-control" rows="5" placeholder="Gambarkan bagaimana perasaan kulitmu..."></textarea>
                </div>

                <div class="d-flex gap-3 mt-2">
                    <a href="journal.php" class="btn btn-light py-2" style="border-radius: 25px; color: #888; border: 1px solid #eee; flex: 1; display: flex; align-items: center; justify-content: center;">Batal</a>
                    <button type="submit" class="btn-save">✨ Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedType = 'Pagi';
        function setType(btn, type) {
            document.querySelectorAll('.btn-type').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedType = type;
        }

        document.getElementById('journalForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newEntry = {
                title: document.getElementById('title').value,
                type: selectedType,
                products: document.getElementById('products').value,
                desc: document.getElementById('desc').value,
                date: new Date().toLocaleDateString('id-ID', { month: 'short', day: 'numeric', year: 'numeric' }),
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
            };

            let journals = JSON.parse(localStorage.getItem('my_journals')) || [];
            journals.unshift(newEntry);
            localStorage.setItem('my_journals', JSON.stringify(journals));

            Swal.fire({
                title: 'Tersimpan!',
                text: 'Jurnal kecantikanmu telah diperbarui.',
                icon: 'success',
                confirmButtonColor: '#FF69B4'
            }).then(() => {
                window.location.href = 'journal.php';
            });
        });
    </script>
</body>
</html>
