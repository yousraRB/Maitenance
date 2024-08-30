<?php
include('../config/connection.php');

// Check if form is submitted
if (isset($_POST['save'])) {
    // Retrieve form data
    $id=$_POST['id'];
    $prix = $_POST['prix'];
    // Update record in database
    $sql = "UPDATE communes  SET prix='$prix' where id='$id' ";
    $result = mysqli_query($conn, $sql);

    // Check if update was successful
    if (mysqli_affected_rows($conn) > 0) {
        // Redirect user back to page with updated information
        header("Location:crudcom.php");
        exit;
    } else {
        // Display error message
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Check if code is set
    if (isset($_GET['id'])) {
        // Retrieve document details from database
        $id = $_GET['id'];
        $sql = "SELECT * FROM communes WHERE id='$id'";
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
                    <div class="input-field" hidden>
                        <label >id</label>
                        <input type="hidden"  name="id" value="<?php echo $row['id']; ?>" readonly>
                    </div> 
                    <div class="input-field">
                        <label>Commune</label>
                        <input type="text" name="comune" value="<?php echo $row['commune']; ?>" readonly>
                    </div> 
                    <div class="input-field">
                        <label>prix</label>
                        <input type="text" name="prix" value="<?php echo $row['prix'].' '.'DA'; ?>" >
                    </div>              
                   
                </div>  
            

                <div class="pagination-btns">
                    <input type="submit" value="save" name="save" class="nextPage stagebtn3b">
                </div>
     </div>
    
            </div>

    </form>
</div>
<script src="assets/js/index.js"></script>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<?php include "includes/footer.php" ?>