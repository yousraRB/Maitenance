<?php
include('../config/connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bon de commande</title>
    <link rel="shortcut icon" href="./assets/imgs/favicon.png" type="image/x-icon" />
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            border:solid 2px black
        }
        .azer{
            display: flex;
            align-items: center;
            justify-content: center;
          
        }

      .azer img{
             margin-left: 10%;
        }
        .bon-details strong {
            width: 150px;
            display: inline-block;
        }
      
        .bon-site{
            margin-left: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="azer">
        <h1>Bon de commande</h1>
        <img src=./assets/imgs/logo.png width="70px" >
    </div>
        <hr>
        <strong>Solution web </strong><br>
        <strong>Magasin:</strong><span>01</span><br>
        <strong>Telephone:</strong><span>0657 33 40 30</span><br>
        <strong>Adresse:</strong><span>P5FM+RJ6, Bab Ezzouar 16000</span><br><br><br>

        <?php
        if (isset($_GET['numbon'])) {
            $numbon = $_GET['numbon'];

            // Récupérer les informations du bon à partir de la base de données
            $sql = "SELECT * FROM bon WHERE numbon = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $numbon);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $bon = $result->fetch_assoc();

                echo "<div class='bon-details'>";
                echo "<strong>Numéro de bon:</strong> " . $bon['numbon'] . "<br>";
                echo "<strong>Client:</strong> " . $bon['nomclient'] . "<br>";
                echo "<strong>Téléphone:</strong> " . $bon['numclient'] . "<br>";
                echo "<strong>Type de produit:</strong> " . $bon['typeproduit'] . "<br>";
                echo "<strong>Nom du produit:</strong> " . $bon['nomproduit'] . "<br>";
                echo "<strong>Panne:</strong> " . $bon['panne'] . "<br>";
                echo "<strong>Prix:</strong> " . $bon['prix'] .' '.'DA'. "<br>";
                echo "<strong>Technicien:</strong> " . $bon['nomtechnicien'];
                echo "</div>";
                echo "<div class='bon-site'>";
                echo "Notre Page web: <strong>www.microhost.com</strong>";
                echo "</div>";
            } else {
                echo "Aucun bon de commande trouvé.";
            }
        } else {
            echo "Numéro de bon non spécifié.";
        }
        ?>
    </div>
</body>
</html>
