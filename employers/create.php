<?php
// Include config file
require_once "config.php";
 
// Définir des variables et initialiser avec des valeurs vides
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Traitement des données du formulaire lors de la soumission du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // validation de nom 
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    }
    else{
        $name = $input_name;
    }
    
    // Validation d'address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // validation de salaire
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
  // Vérifier les erreurs de saisie avant d'insérer dans la base de données
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Préparer une déclaration d'insertion
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Lie les variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Définir les paramètres
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Tentative d'exécution de l'instruction préparée
            if(mysqli_stmt_execute($stmt)){
                // Enregistrements créés avec succès. Rediriger vers la page de destination
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    }   
    // Fermer la connexion
    mysqli_close($link);
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>READ</title>
    <link rel="stylesheet" href="acceuil.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="popup.css">
</head>
<body>
<nav>
      <div class="nav">
        <div class="nav-header">
          <div class="nav-title">
          <img id="logo" src="logo.svg"></img>
          </div>
        </div>
        <div class="nav-links">
        <ul>
          <i class="fas fa-user-circle"></i>
          <i class="fas fa-home"></i>
          <i class="fas fa-sign-out-alt"></i>
          </ul>
        </div>
      </div>
      </nav>
      <aside>
      <div class="row">
        <div class="panel">
          <ul>
            <li class="item-panel">
              <i class="fas fa-home"></i>
              <span>home</span>
            </li>
            <li class="item-panel">
              <i class="fas fa-border-all"></i>
              <span>Products</span>
            <li class="item-panel">
              <i class="fas fa-users"></i>
              <span>Employers</span>
          <li><a href="logout.php"> <button>LOG OUT</button></a></li>  
            </ul>
            </div>
            </div>
            </aside>            
            <div class="affichage" id="cree">
                    <h1><span>Create</span> Record</h1>
                    <p>fill this form and submit to add employee record to the database.</p>
                    <br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div>
                            <input type="text" name="name" placeholder="Name"<?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?> value="<?php echo $name; ?>">
                            <span><?php echo $name_err;?></span>
                        </div>
                        <br>
                        <div>
                            <textarea name="address" placeholder="Address" <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>><?php echo $address; ?></textarea>
                            <span><?php echo $address_err;?></span>
                        </div>
                        <br>
                        <div>
                            <input type="text" name="salary" placeholder="Salary" <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?> value="<?php echo $salary; ?>">
                            <span><?php echo $salary_err;?></span>
                        </div>
                        <div>
                        <br>
                        <div class="creation">
                        <p><input type="submit"value="Submit" id="creer"></p>
                       <p> <button id="cancel"> <a href="index.php">Cancel</a></button></p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>