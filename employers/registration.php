<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
<?php
require('db.php');
// Si le formulaire est soumis, insère les valeurs dans la base de données.
if (isset($_REQUEST['username'])){
        // supprime les barres obliques inverses
	$username = stripslashes($_REQUEST['username']);
        // échappe les caractères spéciaux dans une chaîne
	$username = mysqli_real_escape_string($con,$username); 
	$email = stripslashes($_REQUEST['email']);
	$email = mysqli_real_escape_string($con,$email);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
        $query = "INSERT into `users` (username, password, email)
VALUES ('$username', '".md5($password)."', '$email')";
        $result = mysqli_query($con,$query);
        if($result){
                header("location: index.php");
        }
}
?>
<form name="registration" action="" method="post">
    <div class="container">
      <img src="http://previews.123rf.com/images/stodolskaya/stodolskaya1511/stodolskaya151100027/49219342-Connexion-de-l-utilisateur-ou-l-acc-s-authentification-ic-ne-Banque-d'images.jpg" alt="image" />
    <div class="information1">
      <div class="form-input"><i class="fa fa-user fa-2x" aria-hidden="true"></i>
      <input type="text" name="username" placeholder="Username" required />
    <div class="form-input"><i class="fa fa-lock fa-2x" aria-hidden="true"></i>
    <input type="email" name="email" placeholder="Email" required /></div>
    <div class="form-input"><i class="fa fa-lock fa-2x" aria-hidden="true"></i>
    <input type="password" name="password" placeholder="Password" required />
    <input type="submit" name="submit"  class="envoie" value="Register" /><br>
    <a href='login.php'>login Here</a>
  </div>
 
</form> 
</body>
</html>