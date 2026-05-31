<?php
$servername = "localhost";  
$username = "root";         
$password = "root";            
$database = "Projet1_vols"; 


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
