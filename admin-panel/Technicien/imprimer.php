<?php
include('../config/connection.php');
// Number of results to display per page
$results_per_page = 10;
// Get the current page number
if (!isset($_GET['page'])) {
    $current_page = 1;
} else {
    $current_page = $_GET['page'];
}
// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $results_per_page;

// Get the search input value
$search_name = isset($_GET['numbon']) ? $_GET['numbon'] : '';

// Execute the SQL query and store the result in $result variable
$sql = "SELECT * FROM bon WHERE numbon LIKE '%$search_name%' LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Get the total number of rows in the table
$total_results = mysqli_num_rows($result);

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);
?>

<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Imprimer un bon</h2>
    <table class="center-table">
        <thead>
            <tr>
                <th>Numero de bon</th>
                <th>Client</th>
                <th>Telephone</th>
                <th>Type produit</th>
                <th>Nom produit</th>
                <th>État produit</th>
                <th>Prix</th>
                <th>Sortie</th>
                <th>Date entrée</th>
                <th>Technicien</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) { // Check if query result is valid
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['numbon']; ?></td>
                        <td><?php echo $row['nomclient']; ?></td>
                        <td><?php echo $row['numclient']; ?></td>
                        <td><?php echo $row['typeproduit']; ?></td>
                        <td><?php echo $row['nomproduit']; ?></td>
                        <td><?php echo $row['etatproduit']; ?></td>
                        <td><?php echo $row['prix']; ?></td>
                        <td><?php echo $row['sortie']; ?></td>
                        <td><?php echo $row['dateentree']; ?></td>
                        <td><?php echo $row['nomtechnicien']; ?></td>
                        <td>       
                            <a href="#" onclick="imprimerBon('<?php echo $row['numbon']; ?>')">
                                <ion-icon name="print-outline"></ion-icon>
                            </a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                echo "<tr><td colspan='12'>Aucun bon trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include "./includes/pagination.php" ?>
</div>
<?php include "./includes/footer.php" ?>

<script>
    function imprimerBon(numbon) {
        // Replace 'path_to_print_script' with the actual path to your print script
        var printUrl = 'print_script.php?numbon=' + numbon;
        window.open(printUrl, '_blank');
    }
</script>
