<?php
session_start();
include 'config.php';

$message = ""; 

if (isset($_POST['login'])) {
    $email = ($_POST['email']);
    $password = ($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin'] = $email; 
        header("Location: admin.php"); 
        exit();
    } else {
        $message = "<p style='color:red;'>Email ou mot de passe incorrect.</p>";
    }
}
?>


<!DOCTYPE html>
<html >
<head>
    <meta>
    <title>Connexion Admin</title>
    <a href="index.php" >Déconnexion</a>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { max-width: 400px; margin: auto; padding: 20px; border-radius: 10px; background: #f3f3f3; margin-top: 50px; }
        input { width: 90%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 50%; padding: 10px; background: #6c83b5; color: white; border: none; cursor: pointer; }
        button:hover { background: #4a6fa5; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion Admin</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Admin" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="login">Se connecter</button>
        </form>
        <?= $message; ?>
    </div>
</body>
</html>
