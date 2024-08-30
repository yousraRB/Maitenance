<?php
include('../config/connection.php');

if(isset($_POST["changepwd"])){
    $password = $_POST["password"];
    $cpassword = $_POST['cpassword'];
    $newpassword = $_POST["newpassword"];

    // vérifier si le nouveau mot de passe correspond au mot de passe de confirmation
    if ($newpassword != $cpassword) {
       $message_pass="Le mot de passe de confirmation est incorrect";
    } else {
        // vérifier si l'utilisateur est connecté et que la variable de session est définie
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];

            // récupérer les informations de l'utilisateur depuis la base de données
            $query = "SELECT password FROM users WHERE id = $userId";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                // vérifier si le mot de passe actuel correspond au mot de passe dans la base de données
                if ($password===$row["password"]) {
                    // mettre à jour le mot de passe de l'utilisateur dans la base de données
                    $query = "UPDATE admin_users SET password = '$newpassword' WHERE id = $userId";
                    mysqli_query($conn, $query);
                    $msg_success= "Mot de passe changé avec succès.";
                } else {
                    $message= "Le mot de passe actuel est incorrect.";
                }
            } else {
              echo "<script>alert('Erreur lors de la récupération des informations de l'utilisateur depuis la base de données.');</script>";
            }
        } else {
          $login = "L'utilisateur n'est pas connecté.";
        }
    }
}
?>
<?php include "includes/header2.php"; ?>
<div class="container">
    <h2>Paramètres de compte</h2>
    <?php if (isset($login)) { ?>
                <div class="error" id="error"><?php echo $login; ?></div>
            <?php } ?>
    <form method="POST">
<div class="hero">
<h4>Changer le mot de passe</h4>
<div class="boxes">
  <div class="box">
    <h4>Mot de passe actuel</h4>
    <div class="form">
      <label>
      <input type="password" name="password" placeholder="Saisissez votre mot de passe" required>
      </label>
    </div>
    <br>
      <?php if (isset($message)) { ?>
                <div class="error" id="error"><?php echo $message; ?></div>
            <?php } ?>
  </div>
  <div class="box">
    <h4>Nouveau mot de passe</h4>
    <div class="form">
      <label>
        <input type="password" name="newpassword" id="new-password" placeholder="Saisissez le nouveau mot de passe" required>
        <ion-icon name="eye-outline" id="new-password-icon" class="password-icon" onclick="togglePasswordVisibility('new-password', 'new-password-icon');"></ion-icon>
      </label>

</div>
  </div>
  <div class="box">
    <h4>Confirmer le mot de passe</h4>
    <div class="form">
      <label>
        <input type="password" name="cpassword" id="confirm-password" placeholder="Confirmez le mot de passe" required>
        <ion-icon name="eye-outline" id="confirm-password-icon" class="password-icon" onclick="togglePasswordVisibility('confirm-password', 'confirm-password-icon');"></ion-icon>
      </label>
      <br>
      <?php if (isset($message_pass)) { ?>
                <div class="error" id="error"><?php echo $message_pass; ?></div>
            <?php } ?>
    </div>
  </div>
  </div>
</div>
    <div class="form-actions">
        <div class="text-center">
           <button type="reset" class="btn btn-danger">Supprimer</button>
            <button name="changepwd" class="btn btn-success">Changer</button>
            
        </div>
        <br>
      <?php if (isset($msg_success)) { ?>
                <div class="success" id="success"><?php echo $msg_success; ?></div>
            <?php } ?>
    </div>
    </form>
</div>
<!--Script for visibilite icon-->
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
<script src="../assets/js/main.js"></script>
<?php include "./includes/footer.php" ?>
</body>
</html>