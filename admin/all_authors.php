<?php
   $title='All authors';
   include 'path.php';
   session_start();
   if(isset($_SESSION['Role'])){
    if($_SESSION['Role']!="admin"){
        header("Location: ".BASE_URL."/index.php?message=You+are+not+admin"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>World Of Recipes</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" href="../Images/Logo 4.png">
    <link rel="stylesheet" type="text/css" href="../style/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
  
  include '../includes/header.php';
  include '../includes/hero.php';
  ?>

    <main class="content bg-light container py-4 min-hight">
      <section class="row">
      <table class="table">
        <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>						
                    <th>Email</th>
                    <th>Role</th>
                    <th>Options</th>
                </tr>
            </thead>
        <tbody id="load_data" >
        </tbody>
        </table>
      </section>
      <div class="d-flex justify-content-center my-3">
      <div id="load_data_message"></div>
      </div>
      <div class=" col-md-12 my-5 "></div>
    </main>

    <?php include(ROOT . "/includes/footer.php"); ?>  
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
 
    <script type="text/javascript">
  $(document).ready(function(){
        var limit = 5; //The number of records to display per request
        var start = 0; //The starting pointer of the data
        var br=0;
        var action = 'inactive'; //Check if current action is going on or not. If not then inactive otherwise active
        function load_country_data(limit, start)
        {
            $.ajax({
            url:"all_authors_fetch.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            success:function(data)
            {
                $('#load_data').append(data);
                if(data == '' && br==0)
                    {
                    $('#load_data_message').html("<div class=' col-md-12 my-5 ></div><div class='h-75 col-md-12 my-5 ></div><div class='  py-4 d-flex justify-content-center '><div class=' alert alert-warning alert-dismissible fade show text-center px-3 'role='alert'>No users</div> </div><div class=' col-md-12 my-5 ></div><div class=' col-md-12 my-5 ></div>'");
                    action = 'active';
                    }
                else if(data == ''){
                    $('#load_data_message').html("");
                    action = 'active';
                }
                else
                    {
                    $('#load_data_message').html("<img style='width:50px' src='../ajax-loader.gif' >");
                    action = 'inactive';
                    br++;
                    }
            }
                });
        }

        if(action == 'inactive')
        {
        action = 'active';
        load_country_data(limit, start);
        }

        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
            {
                action = 'active';
                start = start + limit;
                setTimeout(function(){
                    load_country_data(limit, start);
                }, 1000);
            }
        });
 })
</script>

  </body>
</html>
<?php
}else{
    header("Location: ".BASE_URL."/login.php?message=Please+Login");
}
?>