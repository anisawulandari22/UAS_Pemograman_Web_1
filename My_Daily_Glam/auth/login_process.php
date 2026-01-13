<?php
require '../koneksi/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        
        setcookie("user_id", $user['id'], time() + 3600, "/", "", false, true);
        setcookie("user_name", $user['username'], time() + 3600, "/", "", false, true);

        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "<script>alert('Email atau Password salah!'); window.location='login.php';</script>";
    }
}
?>
