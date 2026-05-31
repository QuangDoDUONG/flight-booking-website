<?php
include 'config.php';
session_start();

$message = "";

// Xử lý khi người dùng mua vé
if (isset($_GET['acheter'])) {
    $id_vol = $_GET['acheter'];

    $message = "<p style='color: green; font-size: 18px; font-weight: bold;'>
                    Merci d'avoir acheté un billet chez AD vols !<br>
                    Si vous souhaitez rechercher d'autres vols, retournez à la page de recherche.
                </p>";
}

// Xử lý khi người dùng tìm kiếm chuyến bay
if ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['acheter'])) {
    $depart = $_GET['depart'] ?? '';
    $destination = $_GET['destination'] ?? '';
    $date_depart_vol = $_GET['date_depart_vol'] ?? '';
    $classe = $_GET['classe'] ?? '';

    $isAllerRetour = isset($_GET['date_arrivee_vol']) && !empty($_GET['date_arrivee_vol']);
    $date_arrivee_vol = $isAllerRetour ? $_GET['date_arrivee_vol'] : '';

    $sql = "SELECT v.*, d.nom AS depart_nom, d.ville AS depart_ville, 
                   a.nom AS destination_nom, a.ville AS destination_ville, 
                   c.nom AS compagnie_nom
            FROM vols v
            JOIN aeroport d ON v.id_depart = d.identifiant
            JOIN aeroport a ON v.id_destination = a.identifiant
            JOIN `compagnie aerienne` c ON v.id_compagnie = c.identifiant
            WHERE d.ville = '$depart' 
            AND a.ville = '$destination' 
            AND v.date_depart_vol = '$date_depart_vol' 
            AND v.classe = '$classe'";

    if ($isAllerRetour) {
        $sql .= " AND v.date_arrivee_vol = '$date_arrivee_vol'";
    }

    $result = mysqli_query($conn, $sql);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Résultats de Recherche</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f3f3f3; }
        .container { max-width: 900px; margin: auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #6c83b5; color: white; }
        .btn { padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résultats de votre recherche</h1>

        <?= $message; ?>

        <?php if (!isset($_GET['acheter']) && isset($result) && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Compagnie</th>
                    <th>Départ</th>
                    <th>Destination</th>
                    <th>Date Départ</th>
                    <th>Date Arrivée</th>
                    <th>Classe</th>
                    <th>Prix</th>
                    <th>Heure Départ</th>
                    <th>Heure Arrivée</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['compagnie_nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['depart_ville']); ?> (<?php echo htmlspecialchars($row['depart_nom']); ?>)</td>
                        <td><?php echo htmlspecialchars($row['destination_ville']); ?> (<?php echo htmlspecialchars($row['destination_nom']); ?>)</td>
                        <td><?php echo htmlspecialchars($row['date_depart_vol']); ?></td>
                        <td><?php echo $isAllerRetour ? htmlspecialchars($row['date_arrivee_vol']) : "-"; ?></td>
                        <td><?php echo htmlspecialchars($row['classe']); ?></td>
                        <td><?php echo htmlspecialchars($row['prix']); ?> €</td>
                        <td><?php echo htmlspecialchars($row['heure_depart']); ?></td>
                        <td><?php echo htmlspecialchars($row['heure_arrivee']); ?></td>
                        <td>
                            <a href="search.php?acheter=<?php echo $row['identifiant_vol']; ?>" class="btn">Acheter</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php elseif (!isset($_GET['acheter'])): ?>
            <p class="no-result" style="color: red; font-weight: bold;">Aucun vol trouvé pour votre recherche.</p>
        <?php endif; ?>

        <p><a href="page_accueil.php">Retour à la recherche</a></p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
