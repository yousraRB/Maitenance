<?php
include "./include/header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a commune is selected
    if (isset($_POST['selectedCommune'])) {
        $selectedCommune = $_POST['selectedCommune'];
        $bon = isset($_SESSION['numbon']) ? $_SESSION['numbon'] : '';
        $bon = isset($_SESSION['numbon']) ? $_SESSION['numbon'] : '';
        $sql = "SELECT nomclient, numclient, nomproduit, prix, livreur FROM bon WHERE numbon='$bon'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            // Check if the delivery with the same "numbon" already exists
            $existingDeliverySql = "SELECT * FROM demand WHERE numbon='$bon'";
            $existingDeliveryResult = mysqli_query($conn, $existingDeliverySql);

            if (mysqli_num_rows($existingDeliveryResult) > 0) {
                echo "<script>alert('vous avez déja demander la livraison');</script>.";
            } else {
                // Insert the selected commune into the "demandes" table
                $insertSql = "INSERT INTO demand (numbon, commune, prix, nomclient, numclient, nomproduit, livreur) VALUES ('$bon','$selectedCommune', '{$row['prix']}', '{$row['nomclient']}', '{$row['numclient']}', '{$row['nomproduit']}','{$row['livreur']}')";
                if (mysqli_query($conn, $insertSql)) {
                    echo "<script>alert('Merci,votre demande a ete enregistré.');</script>";
                } else {
                    echo "Error inserting commune into the database: " . mysqli_error($conn);
                }
            }
        } else {
            echo "No data found for the selected bon.";
        }
    } else {
        echo "<script>alert('vous n'avez pas selectionner un commune.');</script>";
    }
}

?>
<section class="why_section layout_padding">
    <form method="post">
        <div class="container2">
            <div class="commune-column">
                <h2>Liste des communes</h2>
                <div class="input-field">
                    <label for="selectedCommune">Commune :</label>
                    <div class="input-field">
    
                <select name="selectedCommune" id="selectedCommune">
                    <option value="" disabled selected>Sélectionnez une commune</option>
                    <?php
                    $sql = "SELECT commune, prix FROM communes";
                    $result = mysqli_query($conn, $sql);

                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $formattedPrice = number_format($row['prix'],0, '', '');

                        echo "<option value='{$row['commune']}' data-price='{$formattedPrice}'>{$row['commune']} : {$formattedPrice}DA</option>";
                    }
                    
                    ?>
                </select>
                </div>

                </div>
            </div>
        </div>

        <div class="selected-commune">Commune sélectionnée :</div>
        <input type="hidden" name="selectedCommune" id="selected_commune_input">

        <script>
            const selectedCommuneElement = document.querySelector('.selected-commune');
            const selectedCommuneInput = document.getElementById('selected_commune_input');
            const communeSelect = document.getElementById('selectedCommune');

            communeSelect.addEventListener('change', (e) => {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const communeName = selectedOption.value;
                const communePrice = selectedOption.getAttribute('data-price');

                selectedCommuneElement.textContent = "Commune sélectionnée : " + communeName + " (Prix : " + communePrice + ")";
                selectedCommuneInput.value = communeName;
            });
        </script>

        <input type="submit" value="Confirmer la livraison">
    </form>
</section>

<?php include "./include/footer.php" ?>