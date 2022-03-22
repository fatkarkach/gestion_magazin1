<?php 
include "../employers/config.php";

$read_data ="SELECT * FROM  products";
$result = mysqli_query($link, $read_data);
if (!$result) {
    echo "error".mysqli_errno($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>products</title>
<link rel="stylesheet" href="../employers/acceuil.css">
<link rel="stylesheet" href="products.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="prodcuts.">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>

<body>
      <nav>
      <div class="nav">
        <div class="nav-header">
          <div class="nav-title">
          <img id="logo" src="../employers/logo.svg"></img>
          </div>
        </div>
        <div class="nav-links">
        <ul id="nav">
      <li><i class="fas fa-user-circle"></i></li>
      <li><a href="../employers/home.php"><i class="fas fa-home"></i></a></li>
      <li><a href="../employers/logout.php"><i class="fas fa-sign-out-alt"></i></a></li>
      </ul>
        </div>
      </div>
      </nav>
      <aside>
      <div class="row">
        <div class="panel">
          <ul>
            <li class="item-panel">
            <a href="../employers/home.php"><i class="fas fa-home"></i>
              <span>home</span></a>
            </li>
            <li class="item-panel">
            <a href="../products/products.php"><i class="fas fa-border-all"></i>
             <span>Products</span></a>
            </li>
            <li class="item-panel">
            <a href="../employers/index.php"><i class="fas fa-users"></i>
              <span>Employers</span></a>
          <li><a href="../employers/logout.php"> <button>LOG OUT</button></a></li>  
            </ul>
            </div>
            </div>
            </aside>
            <main>
            <div class="wrapper">
                        <h2 id="titre2"> <span>Products</span> Details</h2>
                     <a  class="ajouter" href="add_products.php"><i class="fa fa-plus"></i> Add New Products</a>
                     <div>
                     <table>
                    <thead>
                    <tr>
                         <th>#</th>
                         <th>Image</th>
                        <th>category</th>
                        <th>taille</th>
                        <th>quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($result)>0): ?>
                    <?php while ($product = mysqli_fetch_array($result)) { ?>
                     <tr>
                         <td><?php echo$product['id'] ; ?></td>
                         <td class="image_product"><img src="images_product/<?php echo$product['name_image'] ; ?>"  alt="probleme"></td>
                         <td><?php echo$product['category'] ; ?></td>
                         <td><?php echo$product['taille'] ; ?></td>
                         <td><?php echo$product['quantity'] ; ?></td>
                         <td><?php echo$product['price'] ; ?></td>
                         <td>
                           <a href="read.php?id=<?php echo $product['id']; ?>" alt="probleme" aria-label="read"><i class="fa fa-eye"></i></a>
                           <a href="update.php?id=<?php echo $product['id']; ?>" alt="probleme" aria-label="update"><i class="fas fa-pen-alt"></i></a>
                           <a href="delete.php?id=<?php echo $product['id']; ?>" alt="probleme" aria-label="delete"><i class="fa fa-trash"></i></a>
                        </td>
                     </tr>
                     <?php 
                    }?>
                    <?php endif ; ?>
                     </tbody>
                </table>
                  </div>
</body>
<html>
