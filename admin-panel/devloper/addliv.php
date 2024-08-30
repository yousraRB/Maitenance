<?php
include('../config/connection.php');


if (isset($_POST['Ajouter'])) {
   
    $nom = $_POST['nom'];
    $moto = $_POST['moto'];
    $mat = $_POST['mat'];
    $phone = $_POST['phone'];
    $pour = $_POST['pour']; // Add this line to declare $nomclient

    $sql = "SELECT * FROM livreurs WHERE matricule='$mat'OR phone='$phone'";
    $result = $conn->query($sql);

    // Check if the query returned exactly one row
    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "<script>alert('matricule ou numero de tel est déjà existant dans la base de données');</script>";
    } elseif (!empty($numclient) && !preg_match('/^(05|06|07)[0-9]{8}$/i', $numclient)) {
                 echo "<script>alert('le numero est incorrect');</script>";
        }else {
        $sql = "INSERT INTO livreurs (matricule, phone, nom, moto, pourcentage) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisss', $mat, $phone, $nom, $moto, $pour);
        $stmt->execute();

        echo "<script>alert('Un nouveau livreur a été ajouté');</script>";
        header("Refresh:0; url=./crudliv.php");
    }
}
?>


<?php include "includes/header.php" ?>
<div class="container">
    <h2>Ajouter un Livreur</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="information" style="background-color:#c6dff4">
        <div class="stage1-content">
                <div class="fields">
                    <div class="input-field">
                    <label>Matricule</label>
                        <input type="text" name="mat" placeholder="entre la matricule de technicien" required>
                    </div>
                    <div class="input-field">
                        <label>Nom</label>
                        <input type="text" name="nom" placeholder="entre le nom de technicien" required>
                    </div>
                </div>
                <div class="fields">
                <div class="input-field">
                     <label>Moto</label>
                     <select name="moto" class="format" style="background-color:white" required>
                                <option value="" name=""></option>
                                <option value="vrai">Oui</option>
                                <option value="irréparable">Non</option>
                        </select>
                  </div>
                    <div class="input-field">
                        <label>Numero de telephone</label>
                        <input type="tel" name="phone"  required>
                    </div>
                    <div class="input-field">
                        <label>Pourcentage</label>
                        <input type="number" name="pour"  required>
                    </div>
                </div>
               
                </div>
                <div class="pagination-btns">
                    <input type="submit" value="Ajouter" name="Ajouter" class="nextPage stagebtn3b">
                  
                </div>
            </div>
    </form>
</div>
<script src="assets/js/index.js"></script>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<?php include "includes/footer.php" ?>



                   