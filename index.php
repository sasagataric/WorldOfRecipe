<?php
   $title='Explore a world full of recipes';
   include_once 'path.php';
   include 'Classes/CategoryClass.php';
   $category = new Category();
   session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>World Of Recipes</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="Images/Logo 4.png">
    <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css"> 
    
  </head>
  <body>
  <?php
			if(isset($_GET['message'])){
				$msg = $_GET['message'];
				echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				'.$msg.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
			}
	
  include 'includes/header.php';
  include 'includes/hero.php';
  ?>
 
    <main class="content bg-light container py-4 min-hight">
      <div class="form-group row d-flex justify-content-center my-3 mt-1">
          <div class="col-md-3">
            <select  class="form-control  justify-content-center"  onchange="location = 'index.php?category='+this.value +'#jump'">
                    <option value="" selected disabled hidden>Categories</option>
                    <option value="0" >Sve kategorije</option>
                    <?php
                        $result = $category->allCategories();
                        if($result){
                        while($red=mysqli_fetch_assoc($result)){
                          $id = $red['Id'];
                          $naziv_kategorije = $red['CategoryName'];
                          ?>
                          <option value="<?php echo $id; ?>"><?php echo $naziv_kategorije; ?></option>
                            
                          <?php
                          }}
                          ?>
              </select> 
          </div>
        </div>
        
        
      <section id="load_data" class="row"></section>
      
      <div class="d-flex justify-content-center my-3">
      <div id="load_data_message"></div>
      </div>
    </main>

    <?php include 'includes/footer.php'; ?> 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    

    <script type="text/javascript">
  $(document).ready(function(){
        var limit = 6; //The number of records to display per request
        var start = 0; //The starting pointer of the data
        var $_GET = <?php echo json_encode($_GET); ?>;
        var category = $_GET['category'];
        
        if (typeof category == "undefined" || category == null){
          category=0;
        }
        
        var br=0;
        var action = 'inactive'; //Check if current action is going on or not. If not then inactive otherwise active
        function load_country_data(limit, start,category)
        {
            $.ajax({
            url:"fetch.php",
            method:"POST",
            data:{limit:limit, start:start,idKategorije:category},
            cache:false,
            success:function(data)
            {
              $('#load_data').append(data);
                if(data == '' && br==0)
                    {
                    $('#load_data_message').html("<div class=' col-md-12 my-5 ></div><div class='h-75 col-md-12 my-5 ></div><div class='  py-4 d-flex justify-content-center '><div class=' alert alert-warning alert-dismissible fade show text-center px-3 'role='alert'>No recipes</div> </div><div class=' col-md-12 my-5 ></div><div class=' col-md-12 my-5 ></div>'");
                    action = 'active';
                    }
                else if(data == ''){
                    $('#load_data_message').html("");
                    action = 'active';
                }
                else
                    {
                    $('#load_data_message').html("<img style='width:50px' src='ajax-loader.gif' >");
                    action = 'inactive';
                    br++;
                    }
                
            }
                });
        }

        if(action == 'inactive')
        {
        action = 'active';
        load_country_data(limit, start,category);
        }

        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
            {
                action = 'active';
                start = start + limit;
                setTimeout(function(){
                    load_country_data(limit, start,category);
                }, 1000);
            }
        });
 })
</script>
  </body>
</html>
