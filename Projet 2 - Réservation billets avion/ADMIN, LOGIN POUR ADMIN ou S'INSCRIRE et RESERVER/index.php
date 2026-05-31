<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Thực hiện truy vấn trực tiếp
    $result = $conn->query("SELECT * FROM utilisateur WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if ($password === $user['password']) {
            $_SESSION['user'] = $user;
            header("Location: page_accueil.php");
            exit();
        } else {
            echo "<p style='color: red; font-weight: bold;'>Mot de passe incorrect !</p>";
        }
    } else {
        echo "<p style='color: red; font-weight: bold;'> Aucun utilisateur trouvé avec cet email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion - Réservation de Vols</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: rgba(255, 255, 255, 0); }
        .container { max-width: 500px; margin: auto; margin-top: 100px; padding: 20px; background: rgba(140, 130, 255, 0.31); border-radius: 10px; }
        input { width: 90%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 50%; padding: 18px; background: #6c83b5; color: white; border: none; border-radius: 5px; cursor: pointer; border: 5px; }
        button:hover { background: #4a6fa5; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur le site ADvols.com</h1>
        <h2>Connexion</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="inscrire.php">Inscrivez-vous ici</a></p>
        <p>Vous êtes Admin ? <a href="login_admin.php">Oui, Je suis Admin du site AD vols</a></p></p>
    </div>
</body>
</html>
