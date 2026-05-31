<?php
// Page d'accueil - apres login avec index.php
?>
<!DOCTYPE html>
<head>
    <title >Réservation de Vols - Accueil</title>
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; background-color: #f3f3f3; }
        .container { max-width: 800px; margin: auto; flex: 1; text-align: center; }
        .search-box { margin-top: 20px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); }
        .footer { background: #333; color: white; padding: 10px; margin-top: auto; text-align: center; width: 100%; }
        .boarding-pass {
            width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: left;
            position: relative;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: none;
        }
        .boarding-pass.active {
            display: block;
            opacity: 1;
            transform: scale(1);
        }
        .boarding-header {
            background: linear-gradient(to right, #6c83b5, #4a6fa5);
            color: white;
            padding: 15px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-weight: bold;
            font-size: 18px;
        }
        .boarding-form {
            padding: 15px;
        }
        .boarding-form input, .boarding-form select {
            display: block;
            width: 100%;
            margin: 8px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .boarding-form button {
            width: 100%;
            padding: 12px;
            background: #6c83b5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .boarding-form button:hover {
            background: #4a6fa5;
        }
        .open-btn {
            padding: 12px 20px;
            background: #4a6fa5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .open-btn:hover {
            background: #3b5b8a;
        }
    </style>

    <script>
    function toggleBoardingPass() {
        var boardingPass = document.getElementById("boarding-pass");

        if (boardingPass.style.display === "none" || boardingPass.style.display === "") {
            boardingPass.style.display = "block";
            setTimeout(() => {
                boardingPass.classList.add("active");
            }, 10);
        } else {
            boardingPass.classList.remove("active");
            setTimeout(() => {
                boardingPass.style.display = "none";
            }, 300);
        }
    }

    function toggleReturnDate() {
        var typeVol = document.getElementById("type_vol").value;
        var retourField = document.getElementById("date_retour");

        if (typeVol === "aller_simple") {
            retourField.style.display = "none";
        } else {
            retourField.style.display = "block";
        }
    }
    </script>

</head>
<body>
    <header>
        <h1 style="text-align: center; color: blue;">Bienvenue sur notre plateforme de réservation de vols</h1>
    </header>
    
    <div class="container">
        <button class="open-btn" onclick="toggleBoardingPass()">Ouvrir / Fermer le Boarding Pass</button>
        <div class="boarding-pass" id="boarding-pass">
            <div class="boarding-header">
                BOARDING PASS
            </div>
            <div class="boarding-form">
            <form action="search.php" method="GET">
                <label>De:</label>
                <input type="text" name="depart" placeholder="Aéroport de départ" required>

                <label>À:</label>
                <input type="text" name="destination" placeholder="Aéroport d'arrivée" required>

                <label>Type de vol:</label>
                <select id="type_vol" name="type_vol" onchange="toggleReturnDate()">
                    <option value="aller_simple">Aller Simple</option>
                    <option value="aller_retour">Aller-Retour</option>
                </select>

                <label>Date de départ:</label>
                <input type="date" name="date_depart_vol" required>

                <div id="date_retour" style="display: none;">
                <label>Date de retour:</label>
                <input type="date" name="date_arrivee_vol">
    </div>

                <label>Classe:</label>
                <select name="classe">
        <option value="Économie">Économie</option>
        <option value="Affaires">Deluxe</option>
        <option value="Première">Business</option>
    </select>

    <button type="submit">Rechercher un vol</button>
</form>

<script>
    function toggleReturnDate() {
        let typeVol = document.getElementById("type_vol").value;
        let dateRetourDiv = document.getElementById("date_retour");
        let dateRetourInput = document.getElementById("date_arrivee_vol");

        if (typeVol === "aller_retour") {
            dateRetourDiv.style.display = "block";
            dateRetourInput.setAttribute("required", "true");
        } else {
            dateRetourDiv.style.display = "none";
            dateRetourInput.removeAttribute("required");
            dateRetourInput.value = ""; 
        }
    }

</script>

            </div>
        </div>
    </div>
    
    <footer class="footer">
        <p> Merci d'avoir visité notre site Web.</p>
    </footer>
</body>
</html>
