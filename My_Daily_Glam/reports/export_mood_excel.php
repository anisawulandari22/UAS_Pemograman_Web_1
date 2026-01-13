<?php
$host = "localhost"; $user = "root"; $pass = ""; $db = "my_daily_glam";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!isset($_COOKIE['user_id'])) { die("Akses ditolak."); }
$user_id = $_COOKIE['user_id'];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Mood_MyDailyGlam.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "
<table border='1'>
    <thead>
        <tr style='background-color: #FF69B4; color: white;'>
            <th>Tanggal</th>
            <th>Keadaan Mood</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>";

$res = mysqli_query($conn, "SELECT * FROM mood_tracker WHERE user_id = '$user_id' ORDER BY tanggal DESC");

while ($row = mysqli_fetch_assoc($res)) {
    $skor = $row['skor_mood'];
    $mood_text = "";

    switch ($skor) {
        case '0': $mood_text = "Happy"; break;
        case '1': $mood_text = "Calm"; break;
        case '2': $mood_text = "Neutral"; break;
        case '3': $mood_text = "Stressed"; break;
        default: $mood_text = "-"; break;
    }

    echo "<tr>
            <td>" . date('d/m/Y', strtotime($row['tanggal'])) . "</td>
            <td>{$mood_text}</td>
            <td>{$row['catatan']}</td>
          </tr>";
}
echo "</tbody></table>";
?>
