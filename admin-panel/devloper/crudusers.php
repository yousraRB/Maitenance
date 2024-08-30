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
$search_name = isset($_GET['titre']) ? $_GET['titre'] : '';

//  the SQL query 
$sql = "SELECT * FROM users WHERE roles LIKE '%$search_name%' LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Get the total number of rows in the table
$total_results = mysqli_num_rows($result);

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

if (isset($_GET['delete'])) {
    $code = $_GET['delete'];
    // Use prepared statement with a placeholder for the id value
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("s", $code); // Bind the integer value to the placeholder
    $deleteResult = $stmt->execute(); // Execute the prepared statement
    if ($deleteResult) {
        header("Refresh:0; url=./crudusers.php"); // Redirect to the same page after successful deletion
    }
}
?>


<?php include "includes/header.php"; ?>
<div class="container">
    <h2>Gestion Users</h2>
    <table class="">
        <thead>
        <tr>
            <th>Ajouter Users</th>
        </tr>
        </thead>
        <tbody>
            <td><a href="addusers.php"><ion-icon name="add-circle-outline"></ion-icon></a></td>
        </tbody>
    <table class="center-table">
        <thead>
        <tr>
            <th>id</th>
                <th>email</th>
                <th>password</th>
                <th>roles</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) { // Check if query result is valid
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
            <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['password']; ?></td>
                <td><?php echo $row['roles']; ?></td>
                <td><a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Vous êtes sûr de supprimer cette users?')"> <ion-icon name="trash-outline"></ion-icon></a></td>   
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>No user trouvée</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include "../Technicien/includes/pagination.php" ?>
</div>
<?php include "../Technicien/includes/footer.php" ?>