<?php
include_once "path.php";
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL .  "/index.php" ?>"><img src="<?php echo BASE_URL; ?>/Images/Logo 4.png"  alt="World Of Recipes" style="width: 120px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <?php
        if(isset($_SESSION['Role'])){
            if($_SESSION['Role']=="admin"){
            echo'
            <ul class="navbar-nav mr-auto ">
            <li class="nav-item active">
                <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/index.php". '">Recipes</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/admin/my_recipes.php". '">My recipes</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/admin/unos_recepta.php". '">Add recipe</a>
            </li>
            
            <li class="nav-item ">
                    <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/admin/all_recipes_list.php". '">All recipes</a> 
            </li>
            <li class="nav-item ">
                    <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/admin/all_authors.php". '">All authors</a> 
            </li>
            
            </ul>
            
            <a class="nav-link text-dark  fs-4 pl-0 mr-2 text-danger" href="' .BASE_URL."/logout.php" .'">Logout</a>
            <a class="nav-link text-dark  fs-4 pl-0  " href="' .BASE_URL."/admin/profile.php". '" ><i class="bi bi-pencil-square"></i>'.$_SESSION["Name"].' <img src="' .BASE_URL."/Images/pencil-square.svg". '"></a>

            <form class="searchbar my-2" action="' .BASE_URL."/search.php". '" >
                <input class="search_input mb-2 align-middle" type="search"  name="pretraga" aria-label="Search" placeholder="Search">
                <button class="btn btn-link search_icon" type="submit"><i class="fas fa-search"></i></button>
            </form>
            ';

              } else {
                  echo'
                    <ul class="navbar-nav mr-auto ">
                    <li class="nav-item active">
                        <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/index.php". '">Recipes</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/admin/my_recipes.php". '">My recipes</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/admin/unos_recepta.php". '">Add recipe</a>
                    </li>
            
                    </ul>
            
                    <a class="nav-link text-dark  fs-4 pl-0 mr-2 text-danger" href="' .BASE_URL."/logout.php". '">Logout</a>
                    <a class="nav-link text-dark  fs-4 pl-0  " href="' .BASE_URL."/admin/profile.php". '" ><i class="bi bi-pencil-square"></i>'.$_SESSION["Name"].' <img src="' .BASE_URL."/Images/pencil-square.svg". '"></a>

                    <form class="searchbar my-2" action="' .BASE_URL."/search.php". '" >
                        <input class="search_input mb-2 align-middle" type="search"  name="pretraga" aria-label="Search" placeholder="Search">
                        <button class="btn btn-link search_icon" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                        ';
              }
            }
            else{
                echo '
                <ul class="navbar-nav mr-auto ">
                <li class="nav-item active">
                    <a class="nav-link text-dark  fs-4" href="' .BASE_URL."/index.php". '">Recipes</a>
                </li>
                
                </ul>
                <a class="nav-link text-dark  fs-4 pl-0" href="'. BASE_URL."/login.php" .'">Login</a>
                <a class="nav-link text-dark  fs-4 pl-0" href="'. BASE_URL."/registration.php" .'">Register</a>
                
                <form class="searchbar my-2" action="'. BASE_URL."/search.php". '" >
                    <input class="search_input mb-2 align-middle" type="search"  name="pretraga" aria-label="Search" placeholder="Search">
                    <button class="btn btn-link search_icon" type="submit"><i class="fas fa-search"></i></button>
                </form>';
            }
        ?>
            
        </div>
      </div>
        
    </nav>