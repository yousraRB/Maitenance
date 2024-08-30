<?php
include './config/connection.php';

// Check if the user has submitted the login form
// by checking if the submit button was clicked
if (isset($_POST['submit'])) {
    // Get the email and password values from the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['roles'];

    // Build SQL query to select the user with the specified email and role
    $sql = "SELECT * FROM users WHERE email='$email' and roles='$role'";

    // Run the query and save the result in a variable
    $result = $conn->query($sql);

    // Check if the query returned exactly one row
    if ($result->num_rows == 1) {
        // If so, fetch the row as an associative array
        // and save it in a variable
        $row = mysqli_fetch_assoc($result);

        if($role==="chof" && $password===$row["password"]){
            $_SESSION['id'] = $row['id'];
            header("Location:./chof/index.php");
            exit(); 
        } elseif($role==="admin" && $password===$row["password"]){
            $_SESSION['id'] = $row['id'];
            header("Location:./Technicien/consulter.php");
            exit();
        } else {
            $password_error = "le mot de passe est incorrect"; 
        }
}else {
    $email_error = "Email ou role est incorrect";

}
}
?>

<html>
<head>
	<title>Connexion Admin</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<link rel="stylesheet" href="./assets/css/Admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Site Icons -->
    <link rel="shortcut icon" href="assets/imgs/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

   
</head>
<body>
 <div class="wrapper">
 	<div class="heading">
 		<h1>Connexion</h1>
 	</div>
	<div class="form">
 		<form method="post">
 			<span>
 				<i class="fa fa-envelope"></i>
 				<input type="email" placeholder="entre votre email" name="email" required>
                 <?php if (isset($email_error)) { ?>
                <div class="error" id="error"><?php echo $email_error; ?></div>
            <?php } ?>
 			</span><br>
 			<span>
                <i class="fa-solid fa-lock"></i>
 				<input type="password" placeholder="entre votre mot de passe" class="password" id="password" name="password" required>
                 <ion-icon name="eye-outline" id="password-icon" class="password-icon" onclick="togglePasswordVisibility('password', 'password-icon');"></ion-icon>
                <?php if (isset($password_error)) { ?>
                <div class="error" id="error"><?php echo $password_error; ?></div>
            <?php } ?>
 			</span><br>
            
             <div class="role-selection">
                            <p class="role-title">Role:</p>
                            <select name="roles" class="roles" required>
                                <option value=""></option>
                                <option value="admin">Technicien</option>
                                <option value="chof">Livreur</option>
                               
                            </select>
            </div>
            <br>
            <!-- login page code -->
             <input id="submit" type="submit" name="submit" value="Connect">
            
	</form>
    <script src="assets/js/main.js"></script>
    <script>
  function togglePasswordVisibility(passwordInputId, passwordIconId) {
    var passwordInput = document.getElementById(passwordInputId);
    var passwordIcon = document.getElementById(passwordIconId);

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      passwordIcon.setAttribute("name", "eye-off-outline");
    } else {
      passwordInput.type = "password";
      passwordIcon.setAttribute("name", "eye-outline");
    }
  }
</script>
</body>
</html>