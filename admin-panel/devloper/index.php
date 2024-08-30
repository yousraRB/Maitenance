<?php include ('../config/connection.php');?>
<?php include ('includes/header.php');?>
<?php
// Include the database connection file


// Function to get count of accounts by category
function getCountByCategory() {
  global $conn;
  $sql = "SELECT COUNT(*) as count FROM demand where sortie='vrai'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return $row['count'];
}
?>

<div class="container">
<h2>Espace des Devloppeuse</h2>

<div class="boxs">
     <div class="forms">
       <h3>Livrée</h3> 
    <hr> 
       <span id="cc"><?php echo getCountByCategory(); ?></span>
       
      </div>
</div>
   <?php include "../Technicien/includes/footer.php" ?>
        </div>

