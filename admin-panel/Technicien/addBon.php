<?php
include('../config/connection.php');
require_once('./TCPDF/tcpdf.php');

function generateBarcode($numbon) {
    // Create an instance of TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Add a page to the PDF
    $pdf->AddPage();

    // Generate the barcode
    $pdf->write1DBarcode($numbon, 'C39', '', '', 80, 25, 0.4, array(0, 0, 0), 'N');

    // Get the PDF content as a string
    $barcodeImage = $pdf->Output('', 'S');

    return $barcodeImage;
}
function generate_code() {
    global $conn;
    
    $sql_max_code = "SELECT MAX(numbon) as max_code FROM bon";
    $result_max_code = $conn->query($sql_max_code);

    if ($result_max_code->num_rows > 0) {
        $row_max_code = mysqli_fetch_assoc($result_max_code);
        $max_code = intval($row_max_code["max_code"]);
    } else {
        $max_code = 0;
    }

    $numbon = sprintf('%06d', $max_code + 1);
    return $numbon;
}

$code = generate_code();
// Rest of your code...

// Make sure to include the TCPDF library before calling the functions that use it
$numbon = generate_code();
$barcodeImage = generateBarcode($numbon);

if (isset($_POST['Ajouter'])) {
    $dateentree = $_POST['dateentree'];
    $numclient = $_POST['numclient'];
    $etat = $_POST['etat'];
    $produit = $_POST['produit'];
    $typeproduit = $_POST['typeproduit'];
    $prix = $_POST['prix'];
    $nomtechnicien = $_POST['nomtech'];
    $description = $_POST['panne'];
    $numbon = generate_code();
    $nomclient = $_POST['nomclient']; // Add this line to declare $nomclient
    // Génère le code-barres à partir du numéro de bon
$barcodeImage = generateBarcode($numbon);

    $sql = "SELECT * FROM bon WHERE numbon='$numbon'";
    $result = $conn->query($sql);

    // Check if the query returned exactly one row
    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "<script>alert('le code est déjà existant dans la base de données');</script>";
    } elseif (!preg_match('/^(05|06|07)[0-9]{8}$/i', $numclient)) {
                 echo "<script>alert('le numero est incorrect');</script>";
        }else {
        $sql = "INSERT INTO bon (numbon, nomclient, dateentree, panne, numclient, prix, nomtechnicien, etatproduit, nomproduit, typeproduit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssssssss', $numbon, $nomclient, $dateentree, $description, $numclient, $prix, $nomtechnicien, $etat, $produit, $typeproduit);
        $stmt->execute();

        echo "<script>alert('Un nouveau Bon a été ajouté');</script>";
        header("Refresh:0; url=./addBon.php");
    }
}
?>


<?php include "includes/header2.php" ?>
<div class="container">
    <h2>Ajouter un bon</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="information" style="background-color:#c6dff4">
        <div class="stage1-content">
                <div class="fields">
                    <div class="input-field">
                    <label>N°Bon:</label>
                        <input type="text" name="code" value="<?php echo $code?>" readonly>
    <img src="data:image/png;base64,<?php echo base64_encode($barcodeImage); ?>" alt="not founded">
                    </div>
              
                    <div class="input-field">
                        <label>Nom:</label>
                        <input type="text" name="nomclient" placeholder="entre le nom de client" required>
                    </div>
                </div>
                <div class="fields">
                    <div class="input-field">
                        <label>Numero de telephone:</label>
                        <input type="tel" name="numclient"  required>
                    </div>
                    <div class="input-field">
                     <label>Nom de technicien:</label>
                     <select name="nomtech" class="format">
                        <option value="" disabled selected>Sélectionnez un Technicien</option>
                        <?php
                        $sql = "SELECT nom FROM techniciens";
                        $result = $conn->query($sql);
                        // Parcours des résultats et création des options
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $nomTechnicien = $row['nom'];
                                echo '<option value="' . $nomTechnicien . '">' . $nomTechnicien . '</option>';
                            }
                        }
                        ?>
                        <option value="non livreur">non Technicien</option>
                    </select>
                  </div>
                </div>
                <div class="fields">
                    <div class="input-field">
                    <label>Date entree:</label>
                        <input type="date" name="dateentree"  required> 
                    </div>
                    <div class="input-field">
                    <label>Panne:</label>
                    <select name="panne" class="format" style="background-color:white" required>
                    <option value="" disabled selected>Sélectionnez une panne</option>
                    <option value="problème d'alimentation">Problème d'alimentation</option>
                    <option value="écran noir">Écran noir</option>
                    <option value="plantage du système">Plantage du système</option>
                    <option value="infection par un virus">Infection par un virus</option>
                    <option value="problème de connectivité réseau">Problème de connectivité réseau</option>
                    <option value="problème de matériel">Problème de matériel</option>
                    <option value="lenteur excessive">Lenteur excessive</option>
                    <option value="erreur de logiciel">Erreur de logiciel</option>
                    <option value="perte de données">Perte de données</option>
                    <option value="problème d'impression">Problème d'impression</option>
                    <option value="problème de batterie">Problème de batterie</option>
                    <option value="écran cassé">Écran cassé</option>
                    <option value="problème de charge">Problème de charge</option>
                    <option value="problème de signal">Problème de signal</option>
                    <option value="problème de haut-parleur">Problème de haut-parleur</option>
                    <option value="problème de microphone">Problème de microphone</option>
                    <option value="problème de caméra">Problème de caméra</option>
                    <option value="problème de bouton">Problème de bouton</option>
                    <option value="problème de stockage">Problème de stockage</option>
                    <option value="problème de connectivité">Problème de connectivité</option>
                    <option value="problème de système d'exploitation">Problème de système d'exploitation</option>
                    <option value="impression de mauvaise qualité">Impression de mauvaise qualité</option>
                    <option value="bourrage papier">Bourrage papier</option>
                    <option value="problème de connexion">Problème de connexion</option>
                    <option value="problème d'alimentation">Problème d'alimentation</option>
                    <option value="imprimante hors ligne">Imprimante hors ligne</option>
                    <option value="problème de scanner">Problème de scanner</option>
                    <option value="problème de cartouche">Problème de cartouche</option>
                    <option value="problème de tambour">Problème de tambour</option>
                    <option value="problème de configuration">Problème de configuration</option>
                    <option value="autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="pagination-btns">
                    <input type="button" value="Suivant" class="nextPage stagebtn1b" onclick="stage1to2()">
                </div>
                </div>
           
<div class="stage2-content">
            <div class="fields">
                <div class="input-field">
                <label>Prix</label>
                        <input type="text" name="prix"  required> 
                    </div>
                    <div class="input-field">
                    <label>Nom Produit:</label>
                        <input type="text" name="produit"  required> 
               
                    </div>
                    </div>
                <div class="fields">
                    <div class="input-field">
                    <label>Etat Produit:</label>
                        <select name="etat" class="format" style="background-color:white" required>
                                <option value="" name=""></option>
                                <option value="En cours de réparation">En cours de reparation</option>
                                <option value="Bien réparé">Bien reparé</option>
                                <option value="Irréparable">Irréparable</option>
                        </select>
                        
                    </div>
                    <div class="input-field">
                    <label>Type Produit:</label>
                        <select name="typeproduit" class="format" style="background-color:white" required>
                                <option value="" name=""></option>
                                <option value="pc">PC</option>
                                <option value="imprimante">Imprimante</option>
                                <option value="mobile">Mobile</option>
                        </select>
                    
                </div>
               
                </div>
                <div class="pagination-btns">
                    <input type="button" value="Précédent" class="previousPage stagebtn2a" onclick="stage2to1()">
                    <input type="submit" value="Ajouter" name="Ajouter" class="nextPage stagebtn3b">
                  
                </div>
            </div>
            
            <div class="stage3-content">
                
            
        
            </div>
        </div>
    </form>
</div>
<script src="assets/js/index.js"></script>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<?php include "includes/footer.php" ?>



                   