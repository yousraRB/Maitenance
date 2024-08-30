<?php 
include "./config/connection.php";
if (isset($_POST['submit'])) {
    $bon = $_POST['bon'];
    $phone = $_POST['phone'];

    // Build SQL query to select the user with the specified email
    $sql = "SELECT * FROM bon WHERE numbon='$bon' ";

    // Run the query and save the result in a variable
    $result = $conn->query($sql);

    // Check if the query returned exactly one row
    if ($result->num_rows == 1) {
        // If so, fetch the row as an associative array
        // and save it in a variable
        $row = mysqli_fetch_assoc($result);

        // Verify the password entered by the user with the hashed password stored in the database
        if ($phone== $row['numclient']) {
            $success='Login successful';

            // If the password is correct, set a session variable to identify the user
            $_SESSION['numbon'] = $row['numbon'];

			$_SESSION['loggedIn'] = true;

			// Set a variable to indicate that the user is logged in
			$loggedIn = true;
         header("Location:machines.php");
        exit;
        } else {
            // If the password is incorrect, show an error message
            $phone_error='le numero de tel est incorrect';
        }
    } else {
        $bon_error = "numero de bon est incorrect";
    }
}
?>

<header class="header_section">
            <div class="container">
               <nav class="navbar navbar-expand-lg custom_nav-container ">
                  <a class="navbar-brand" href="index.html"><span>Micro Host</span></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav">
                        <li class="nav-item active">
                           <a class="nav-link" href="index.php">Acceuil <span class="sr-only">(current)</span></a>
                        </li>  
                        <li class="nav-item">
                           <a class="nav-link" href="blog_list.php">A propos</a>
                        </li>
                       
                     <?php if (isset($_SESSION['loggedIn'])) {  ?>
                     <li class="nav-item"><a class="nav-link" href="machines.php"><span>Machine</span></a></li>
                     <?php } ?>	
                        <li class="nav-item">
                           <a class="nav-link" href="contact.php">Contact</a>
                        </li>

                     </ul>
                     <ul class="navbar-nav">
                     <?php if (isset($_SESSION['loggedIn'])) {  ?>
                     <li class="nav-item"><a class="nav-link" href="logout.php"><span> Déconnexion</span></a></li>
                     <?php } ?>	
                    </ul>
                  </div>
               </nav>
            </div>
         </header>