<?php
include('../config/connection.php');


if (isset($_POST['Ajouter'])) {
    $com = $_POST['com'];
    $prix = $_POST['prix'];


    $sql = "SELECT * FROM communes WHERE commune='$com'";
    $result = $conn->query($sql);

    // Check if the query returned exactly one row
    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "<script>alert('la commune est déjà existant dans la base de données');</script>";
        }else {
        $sql = "INSERT INTO communes (commune, prix) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $com, $prix);
        $stmt->execute();

        echo "<script>alert('Un nouveau commune a été ajouté');</script>";
        header("Refresh:0; url=./crudcom.php");
    }
}
?>


<?php include "includes/header.php" ?>
<div class="container">
    <h2>Ajouter un Commune</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="information" style="background-color:#c6dff4">
        <div class="stage1-content">
                <div class="fields">
                    <div class="input-field">
                    <label>Commune</label>
                        <input type="text" name="com" placeholder="entre le nom de la commune" required>
                    </div>
                    <div class="input-field">
                        <label>Prix</label>
                        <input type="number" name="prix"  required>
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



                   