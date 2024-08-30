<?php
include('../config/connection.php');

// Check if form is submitted
if (isset($_POST['save'])) {
    // Retrieve form data
    $numbon=$_POST['numbo'];
    $etat = $_POST['etatprodui'];
    $prix = $_POST['pri'];
    $sortie = $_POST['sorti'];
    $datesortie = $_POST['datesorti'];
    $livreur = $_POST['livreur']; // Correction: Récupérer la valeur du livreur sélectionné
    
    // Update record in database
    $sql = "UPDATE bon SET etatproduit='$etat', prix='$prix', sortie='$sortie', datesortie='$datesortie', livreur='$livreur' WHERE numbon='$numbon'";
    $result = mysqli_query($conn, $sql);

    // Check if update was successful
    if (mysqli_affected_rows($conn) > 0) {
        // Redirect user back to page with updated information
        header("Location:Mbon.php");
        exit;
    } else {
        header("location:Mbon.php");
        exit;
    }
} else {
    // Check if code is set
    if (isset($_GET['numbon'])) {
        // Retrieve document details from database
        $numbon = $_GET['numbon'];
        $sql = "SELECT * FROM bon WHERE numbon='$numbon'";
        $result = $conn->query($sql);

        // Check if the query returned exactly one row
        if ($result->num_rows == 1) {
            // Fetch the row as an associative array
            $row = mysqli_fetch_assoc($result);
        }
    }
}
?>

<?php include "includes/header.php" ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <div class="information">
            <div class="stage1-content">
                <div class="fields">
                    <div class="input-field">
                        <label>Numéro de bon </label>
                        <input type="text" name="numbo" id="numbon" value="<?php echo $row['numbon']; ?>"readonly >
                    </div>
                    <div class="input-field">
                        <label>l'état de produit </label>
                        <select name="etatprodui" class="fonction" >
                            <option value="en cours de réparation">en cours de réparation</option>
                            <option value="bien réparé">bien réparé</option>
                            <option value="irréparable">irréparable</option>
                        </select>
                    </div>
                </div>
                <div class="fields">
                    <div class="input-field">
                        <label>prix</label>
                        <input type="text" name="pri" value="<?php echo $row['prix']; ?>">
                    </div>
                  
                    <div class="input-field">
                        <label>La sortie</label>
                        <select name="sorti" class="fonction">
                        <option value="<?php echo $row['sortie']; ?>"><?php echo $row['sortie']; ?></option>
                            <option value="vrai">vrai</option>
                            <option value="faux">faux</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label>la date sortie</label>
                        <input type="date" name="datesorti" value="<?php echo $row['datesortie']; ?>">
                    </div>
                    <div class="input-field">   
                    <label>Livreur</label>
                    <select name="livreur" class="format" >
                    <option value="<?php echo $row['livreur']; ?>"><?php echo $row['livreur']; ?></option>
                        <?php
                        $sql = "SELECT nom FROM livreurs";
                        $result = $conn->query($sql);
                        // Parcours des résultats et création des options
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $nomLivreur = $row['nom'];
                                echo '<option value="' . $nomLivreur . '">' . $nomLivreur . '</option>';
                            }
                        }
                        
                        $conn->close();
                        ?>
                        <option value="non livreur">non livreur</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="pagination-btns">
                <input type="submit" value="save" name="save" class="nextPage stagebtn3b">
            </div>
        </div>
    </form>
</div>
<script src="assets/js/index.js"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<?php include "includes/footer.php" ?>