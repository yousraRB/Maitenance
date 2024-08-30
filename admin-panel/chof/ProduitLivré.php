<?php
include('../config/connection.php');

// Number of results to display per page
$results_per_page = 5;
// Get the current page number
if (!isset($_GET['page'])) {
    $current_page = 1;
} else {
    $current_page = $_GET['page'];
}
// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $results_per_page;

// Get the search input value
//$search_name = isset($_GET['titre']) ? $_GET['titre'] : '';

//  the SQL query 
$sql = "SELECT * FROM demand WHERE sortie= 'vrai' ";
$result = $conn->query($sql);

// Get the total number of rows in the table
$total_results = mysqli_num_rows($result);

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);
?>

<?php include "includes/header2.php"; ?>
<div class="container">
    <h2>consulter les produits  livrés :  </h2>
    <table class="center-table">
        <thead>
        <tr>
          
               <th>Numero de bon</th>
                <th>Client</th>
                <th>Telephone</th>
                <th>Nom produit</th>
                <th>Commune</th>
                <th>prix</th>
                <th>sortie</th>
                <th>Livreur</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) { // Check if query result is valid
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
            <td>
              <?php echo $row['numbon']; ?></td>
                <td><?php echo $row['nomclient']; ?></td>
                <td><?php echo $row['numclient']; ?></td>         
                <td><?php echo $row['nomproduit']; ?></td>
                <td><?php echo $row['commune']; ?></td>
                <td><?php echo $row['prix']; ?></td>
               <td><?php echo $row['sortie']; ?></td>
               <td><?php echo $row['livreur']; ?></td>
                
        
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>No produit livré </td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include "../Technicien/includes/pagination.php" ?>
</div>
<?php include "../Technicien/includes/footer.php" ?>