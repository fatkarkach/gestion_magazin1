<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
<?php
require('db.php');
session_start();
// Si le formulaire est soumis, insérez les valeurs dans la base de données.
if (isset($_POST['username'])){
       // supprime les barres obliques inverses
	$username = stripslashes($_REQUEST['username']);
        //échappe les caractères spéciaux dans une chaîne
	$username = mysqli_real_escape_string($con,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
	// Vérification si l'utilisateur existe dans la base de données ou non
        $query = "SELECT * FROM `users` WHERE username='$username'
        and password='".md5($password)."'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
        if($rows==1){
	    $_SESSION['username'] = $username;
            // Rediriger l'utilisateur vers index.php
	    header("Location: index.php");
         }
        else{
	echo "<h3>Username/password is incorrect.</h3>";
	}
}
?>
<form action="" method="post" name="login">
    <div class="container">
      <img src="http://previews.123rf.com/images/stodolskaya/stodolskaya1511/stodolskaya151100027/49219342-Connexion-de-l-utilisateur-ou-l-acc-s-authentification-ic-ne-Banque-d'images.jpg" alt="image" />
    <div class="information1">
      <div class="form-input"><i class="fa fa-user fa-2x" aria-hidden="true"></i>
     <input type="text" name="username" placeholder="Username" required /></div>
    <div class="form-input"><i class="fa fa-lock fa-2x" aria-hidden="true"></i>
      <input type="password" name="password" placeholder="Password" required /></div>
      <input name="submit" type="submit" class="envoie" value="Login" /> 
  </div></form> 
<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div> 
</body>
</html>