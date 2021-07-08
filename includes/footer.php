<?php
include_once "path.php";
include_once (ROOT . '/Classes/CategoryClass.php');
$kategorijaF = new Category();
?>

<section class="hero-bottom  py-4 d-flex align-items-center ">
      <div class="d-flex container justify-content-center flex-wrap">
      
        <?php
            $result = $kategorijaF->allCategories();
            while($red=mysqli_fetch_assoc($result)){
            $id = $red['Id'];
            $naziv_kategorije = $red['CategoryName'];
            ?>
            <a href="<?php echo BASE_URL . "/index.php?category=". $id ."#jump"?>" class="badge badge-dark fs-4 m-2 p-2 "><?php echo $naziv_kategorije; ?></a>
            <?php
            }
            ?>
        
      </div>
    </section>
    <footer class="bg-dark text-white py-2">
      <div class="container text-center">
        
        <div class="f-flex felx-wrap justify-content-center">
          <a href="<?php echo BASE_URL .  "/contact.php" ?>" class="badge badge-warning fs-4 p-1 m-1">Contact</a>
          <a href="<?php echo BASE_URL .  "/index.php" ?>" class="badge badge-warning fs-4 p-1 m-1">Home</a>
          <a href="<?php echo BASE_URL .  "/about.php" ?>" class="badge badge-warning fs-4 p-1 m-1">About us</a>
        </div>
        <p class="mb-0">&copy; Copyright 2021 World Of Recipes</p>
      </div>
    </footer>