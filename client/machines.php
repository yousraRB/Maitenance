<?php
include "./include/header.php";

$bon = isset($_SESSION['numbon']) ? $_SESSION['numbon'] : '';
$sql = "SELECT * FROM bon WHERE numbon='$bon'";
$result = mysqli_query($conn, $sql);

?>

<!-- why section -->
<section class="why_section layout_padding">
    <form method="post">
   <div class="container">
      <div class="heading_container heading_center">
         <h3>
            Consulter l'état de votre machine
         </h3>
      <div class="row">
            <?php if (mysqli_num_rows($result) > 0) { ?>
               <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                 
                     <div class="box">
                        <h2>Salut <?php echo $row["nomclient"]; ?></h2>
                        <div class="img-box">
                           <div class="detail-box">
                              <p>N°Bon:<?php echo $row["numbon"]; ?></p>
                              <p>Nom:<?php echo $row["nomclient"]; ?></p>
                              <p>Type Produit:<?php echo $row["typeproduit"]; ?></p>
                              <p>Produit:<?php echo $row["nomproduit"]; ?></p>
                              <p>Panne:<?php echo $row["panne"]; ?></p>
                              <p>Etat:<?php echo $row["etatproduit"]; ?></p>
                              <p>Prix:<?php echo $row["prix"]; ?>DA</p>
                              <br><br>
                              <a href="commune.php?numbon=<?php echo $bon ?>"><input type="button" class=" subscribe_form form button" name="liv" value="livraison" /></a>
                          
                            </div>
                        </div>
                     </div>
                 
               <?php } ?>
            <?php } else { ?>
               <p class="remarque">Il n'y a aucune information pour vous dans cette catégorie.</p>
            <?php } ?>
         </div>
      </div>
   </div>
    </form>
</section>
<?php include "./include/footer.php" ?>