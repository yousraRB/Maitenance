<?php
include('../config/connection.php');


if (isset($_POST['Ajouter'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $roles = $_POST['roles'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    // Check if the query returned exactly one row
    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "<script>alert('email est déjà existant dans la base de données');</script>";
        }else {
        $sql = "INSERT INTO users (email, password, roles) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $email, $roles, $password);
        $stmt->execute();

        echo "<script>alert('Un nouveau user a été ajouté');</script>";
        header("Refresh:0; url=./crudusers.php");
    }
}
?>


<?php include "includes/header.php" ?>
<div class="container">
    <h2>Ajouter un Users</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="information" style="background-color:#c6dff4">
        <div class="stage1-content">
                <div class="fields">
                    <div class="input-field">
                    <label>Email</label>
                        <input type="email" name="email" placeholder="entre email de user" required>
                    </div>
                    <div class="input-field">
                        <label>Mot de passe</label>
                        <input type="text" name="password" placeholder="entre le mot de passe" required>
                    </div>
                    <div class="input-field">
                     <label>Role</label>
                    <input type="text" name="roles" placeholder="entre le role de user" required>
                  </div>
</div>
                </div>
                <div class="pagination-btns">
                    <input type="submit" value="Ajouter" name="Ajouter" class="nextPage stagebtn3b">
                  
                </div>
            </div>
    </form>
</div>
<script src="assets/js/index.js"></script>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<?php include "includes/footer.php" ?>



                   