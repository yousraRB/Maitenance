<?php
include('../config/connection.php');

// Check if form is submitted
if (isset($_POST['voir'])) {
    // Retrieve form data
    $matricule = $_POST['matricule'];
    $datedeb = $_POST['datedeb'];
    $datefin = $_POST['datefin'];

    // Check if matricule exists
    $matriculeQuery = "SELECT COUNT(*) AS count FROM techniciens WHERE matricule = '$matricule'";
    $matriculeResult = mysqli_query($conn, $matriculeQuery);

    if ($matriculeResult) {
        $matriculeRow = mysqli_fetch_assoc($matriculeResult);
        $matriculeCount = $matriculeRow['count'];

        if ($matriculeCount > 0) {
            // Retrieve the sum of prices from the table based on technician and date range
            $sql = "SELECT SUM(b.benefice * t.pourcentage/100) AS total
                    FROM bon b
                    JOIN techniciens t ON b.nomtechnicien = t.nom
                    WHERE t.matricule = '$matricule'
                    AND   b.sortie = 'vrai'
                    AND b.dateentree >= '$datedeb' AND b.datesortie <= '$datefin'
                    GROUP BY t.nom";  // Group by technician name

            $result = mysqli_query($conn, $sql);

            // Check if the query was successful
            if ($result) {
                $totalPrice = 0;  // Initialize total price variable

                // Fetch and sum the individual totals
                while ($row = mysqli_fetch_assoc($result)) {
                    $totalPrice += $row['total'];
                }

              $message="Votre paie durant cette periode est:".$totalPrice;
            } else {
                // Display error message
                echo "Error retrieving data: " . mysqli_error($conn);
            }
        } else {
            // Matricule does not exist
            echo "<script>alert('Matricule does not exist')</script>";
        }
    } else {
        // Display error message
        echo "Error retrieving data: " . mysqli_error($conn);
    }
}
?>

<?php include "includes/header2.php" ?>
<div class="container">
<h2>Consulter la paie</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="information" style="background-color:#c6dff4">
            <div class="stage1-content">
          
                <div class="fields">
                    <div class="input-field">
                        <label>saisir matricule: </label>
                        <input type="text" name="matricule" id="matricule">
                    </div>
                </div>
                <div class="input-field">
                    <label>la date debut </label>
                    <input type="date" name="datedeb">
                </div>
                <div class="input-field">
                    <label>la date fin </label>
                    <input type="date" name="datefin">
                </div>
                
            </div>
            <?php if (isset($message)) { ?>
                <div class="success" id="success" ><?php echo $message; ?></div>
                <?php } ?>
 			</span><br>
            <div class="pagination-btns">
                <input type="submit" value="voir" name="voir" class="nextPage stagebtn3b">
            </div>
        </div>
    </form>
</div>
<script src="assets/js/index.js"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<?php include "includes/footer.php" ?>