<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../koneksi/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['name']); 
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            echo "<script>alert('Email sudah ada!'); window.location='register.php';</script>";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registrasi Berhasil!'); window.location='login.php';</script>";
        }
        $stmt->close();
    } catch (Exception $e) {
        die("Error Database: " . $e->getMessage());
    }
}
?>
