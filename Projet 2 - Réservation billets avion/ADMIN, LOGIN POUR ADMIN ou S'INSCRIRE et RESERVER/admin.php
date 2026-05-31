<?php
session_start();
include 'config.php';

// Kiểm tra xem admin đã đăng nhập chưa
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Xử lý cập nhật thông tin chuyến bay
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_depart = $_POST['id_depart'];
    $id_destination = $_POST['id_destination'];
    $date_depart_vol = $_POST['date_depart_vol'];
    $date_arrivee_vol = $_POST['date_arrivee_vol'];
    $duree = $_POST['duree'];
    $classe = $_POST['classe'];
    $prix = $_POST['prix'];
    $id_compagnie = $_POST['id_compagnie'];
    $heure_depart = $_POST['heure_depart'];
    $heure_arrivee = $_POST['heure_arrivee'];

    // Truy vấn SQL trực tiếp
    $sql = "UPDATE vols 
            SET id_depart='$id_depart', id_destination='$id_destination', 
                date_depart_vol='$date_depart_vol', date_arrivee_vol='$date_arrivee_vol', 
                duree='$duree', classe='$classe', prix='$prix', 
                id_compagnie='$id_compagnie', heure_depart='$heure_depart', heure_arrivee='$heure_arrivee' 
            WHERE identifiant_vol='$id'";

    // Thực thi truy vấn
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Mise à jour réussie !</p>";
    } else {
        echo "<p style='color:red;'>Erreur lors de la mise à jour: " . $conn->error . "</p>";
    }
}

// Xoá chuyến bay
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Bảo vệ dữ liệu đầu vào để tránh SQL Injection
    $id = mysqli_real_escape_string($conn, $id);

    // Truy vấn SQL trực tiếp
    $sql = "DELETE FROM vols WHERE identifiant_vol = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Le vol a été supprimé avec succès !</p>";
    } else {
        echo "<p style='color:red;'>Erreur lors de la suppression du vol: " . $conn->error . "</p>";
    }
}


// Xử lý khi người dùng nhấn "Exécuter SQL"
if (isset($_POST['execute'])) {
    $sql_query = trim($_POST['sql_query']); // Lấy SQL nhập từ người dùng

    if (!empty($sql_query)) {
        $result = $conn->query($sql_query);

        if ($result) {
            if (stripos($sql_query, "SELECT") === 0) {
                // Nếu là lệnh SELECT, hiển thị dữ liệu dưới dạng bảng
                echo "<p style='color:green;'>Commande SQL exécutée avec succès !</p>";
                echo "<table border='1'><tr>";

                // Lấy và hiển thị tiêu đề cột
                while ($field = $result->fetch_field()) {
                    echo "<th>{$field->name}</th>";
                }
                echo "</tr>";

                // Hiển thị dữ liệu
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>{$value}</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // Nếu là INSERT, UPDATE, DELETE
                echo "<p style='color:green;'>Commande SQL exécutée avec succès !</p>";
            }
        } else {
            // Hiển thị lỗi nếu có
            echo "<p style='color:red;'>Erreur SQL: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Veuillez entrer une commande SQL !</p>";
    }
}

// Lấy danh sách chuyến bay
$sql = "SELECT * FROM vols";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Gestion des Vols</title>
    <a href="login_admin.php" class="logout">Déconnexion</a>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 90%; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #6c83b5; color: white; }
        .btn { padding: 5px 10px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestion des Vols</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Départ</th>
                <th>Destination</th>
                <th>Date Départ</th>
                <th>Date Arrivée</th>
                <th>Durée</th>
                <th>Classe</th>
                <th>Prix</th>
                <th>Compagnie</th>
                <th>Heure Départ</th>
                <th>Heure Arrivée</th>
                <th>Modifier</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST">
                        <td><?= $row['identifiant_vol']; ?><input type="hidden" name="id" value="<?= $row['identifiant_vol']; ?>"></td>
                        <td><input type="text" name="id_depart" value="<?= $row['id_depart']; ?>"></td>
                        <td><input type="text" name="id_destination" value="<?= $row['id_destination']; ?>"></td>
                        <td><input type="date" name="date_depart_vol" value="<?= $row['date_depart_vol']; ?>"></td>
                        <td><input type="date" name="date_arrivee_vol" value="<?= $row['date_arrivee_vol']; ?>"></td>
                        <td><input type="text" name="duree" value="<?= $row['duree']; ?>"></td>
                        <td><input type="text" name="classe" value="<?= $row['classe']; ?>"></td>
                        <td><input type="text" name="prix" value="<?= $row['prix']; ?>"></td>
                        <td><input type="text" name="id_compagnie" value="<?= $row['id_compagnie']; ?>"></td>
                        <td><input type="time" name="heure_depart" value="<?= $row['heure_depart']; ?>"></td>
                        <td><input type="time" name="heure_arrivee" value="<?= $row['heure_arrivee']; ?>"></td>
                        <td><button type="submit" name="update" class="btn">Modifier</button></td>
                        <td><button type="submit" name="delete" class="btn-supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce vol ?');">Supprimer</button>
                            <input type="hidden" name="id" value="<?= $row['identifiant_vol']; ?>"></td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="container">
        <h2>Exécuter une commande SQL</h2>
        <form method="POST">
            <textarea name="sql_query" placeholder="Entrez votre commande SQL ici..."></textarea>
            <br>
            <button type="submit" name="execute">Exécuter SQL</button>
        </form>
        </div>

</body>
</html>
