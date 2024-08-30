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
$sql = "SELECT * FROM communes WHERE commune LIKE '%$search_name%' LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Get the total number of rows in the table
$total_results = mysqli_num_rows($result);

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

if (isset($_GET['delete'])) {
    $code = $_GET['delete'];
    // Use prepared statement with a placeholder for the id value
    $deleteSql = "DELETE FROM communes WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("s", $code); // Bind the integer value to the placeholder
    $deleteResult = $stmt->execute(); // Execute the prepared statement
    if ($deleteResult) {
        header("Refresh:0; url=./crudcom.php"); // Redirect to the same page after successful deletion
    }
}
?>

<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Gestion des communes</h2>
    <table class="">
        <thead>
        <tr>
            <th>Ajouter un Commune</th>
        </tr>
        </thead>
        <tbody>
            <td><a href="addcom.php"><ion-icon name="add-circle-outline"></ion-icon></a></td>
        </tbody>
    <table class="center-table">
        <thead>
            <tr>
                <th>Commune</th>
                <th>Prix</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) { // Check if query result is valid
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['commune']; ?></td>
                        <td><?php echo $row['prix']; ?></td>
                        <td><a href="Editcom.php?id=<?php echo $row['id']; ?>"><ion-icon name="create-outline"></ion-icon></a></td>
                        <td><a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Vous êtes sûr de supprimer cette commune?')"> <ion-icon name="trash-outline"></ion-icon></a></td>   
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
