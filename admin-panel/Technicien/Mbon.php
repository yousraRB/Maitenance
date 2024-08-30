<?php
include('../config/connection.php');

// Number of results to display per page
$results_per_page = 7;
// Get the current page number
if (!isset($_GET['page'])) {
    $current_page = 1;
} else {
    $current_page = $_GET['page'];
}
// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $results_per_page;

// Get the search input value
$search_name = isset($_GET['titre']) ? $_GET['titre'] : '';

//  the SQL query 
$sql = "SELECT * FROM bon WHERE nomtechnicien LIKE '%$search_name%' LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Get the total number of rows in the table
$total_results = mysqli_num_rows($result);

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);
?>

<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Modifier un bon </h2>
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
                <th>Date sortie</th>
                <th>Technicien</th>
                <th>Livreur</th>
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
                <td><?php echo $row['datesortie']; ?></td>
                <td><?php echo $row['nomtechnicien']; ?></td>
                <td><?php echo $row['livreur']; ?></td>
                <td><a href="editBon.php?numbon=<?php echo $row['numbon']; ?>"><ion-icon name="create-outline"></ion-icon></a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>No bon trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include "../Technicien/includes/pagination.php" ?>
</div>
<?php include "../Technicien/includes/footer.php" ?>
