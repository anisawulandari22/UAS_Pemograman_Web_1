<?php
$host = "localhost"; $user = "root"; $pass = ""; $db = "my_daily_glam";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!isset($_COOKIE['user_id'])) { die("Akses ditolak."); }
$user_id = $_COOKIE['user_id'];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Inventory_Skincare_Glam.xls");

echo "
<table border='1'>
    <thead>
        <tr style='background-color: #DA70D6; color: white;'>
            <th>Nama Produk</th>
            <th>Brand</th>
            <th>Tanggal Expired</th>
        </tr>
    </thead>
    <tbody>";

$res = mysqli_query($conn, "SELECT * FROM skincare_inventory WHERE user_id = '$user_id' ORDER BY id DESC");

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['nama_produk']) . "</td>
                <td>" . htmlspecialchars($row['brand']) . "</td>
                <td>" . date('d/m/Y', strtotime($row['expired_date'])) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3' style='text-align:center;'>Tidak ada produk untuk User ID: $user_id</td></tr>";
}
echo "</tbody></table>";
?>
