<?php
session_start();
include 'config.php'; 

$message = ""; 

if (isset($_POST['btn-reg'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "INSERT INTO `utilisateur` (`email`, `password`) VALUES ('$email', '$password')";

        if ($conn->query($sql)) {
            $message = "<p style='color: green; font-size: 18px; font-weight: bold;'>Informations valides !<br> Redirection vers la page de connexion...</p>";
            header("refresh:3;url=index.php"); 
        } else {
            $message = "<p style='color: red;'>Erreur: {$conn->error}</p>";
        }
    } else {
        $message = "<p style='color: red;'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription - Réservation de Vols</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: rgba(255, 255, 255, 0); }
        .container { max-width: 500px; margin: auto; margin-top: 100px; padding: 20px; background: rgba(140, 130, 255, 0.31); border-radius: 10px; }
        input { width: 90%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 50%; padding: 18px; background: #6c83b5; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #4a6fa5; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nouvel utilisateur ? Pas de souci !</h1>
        <h2>Veuillez saisir vos informations d'authentification.</h2>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="btn-reg">Envoyer</button>
        </form>

        <?= $message; ?> 
    </div>
</body>
</html>
