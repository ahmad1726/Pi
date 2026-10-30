<?php
session_start();
include "koneksi.php";
if(isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['pass'];
    $ambil = $koneksi->query("SELECT * FROM users WHERE username = '$user'");
    if($ambil->num_rows == 1) {
        $data = $ambil->fetch_assoc();
        if($pass == $data['pass']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $data['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<html>
<head>
    <title>Login Dashboard</title>
    <style>
        body {display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: Arial; background: #f0f2f5;}
        .login-box {background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; width: 300px;}
        input {width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;}
        button {width: 100%; padding: 10px; background: #00ccff; border: none; color: white; border-radius: 5px; cursor: pointer; font-weight: bold;}
        .error {color: red; font-size: 14px;}
    </style>
</head>
<body>
    <div class="login-box">
        <h3>Login Pakan Kucing</h3>
        <?php if(isset($error)) {echo "<p class='error'>$error</p>";} ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>