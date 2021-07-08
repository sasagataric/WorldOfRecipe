<?php
   $title='Contact';
   include_once 'path.php';
   session_start();
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

  require_once "PHPMailer/PHPMailer.php";
  require_once "PHPMailer/SMTP.php";
  require_once "PHPMailer/Exception.php";
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
    ?>
    <?php
      if(isset($_POST['submit'])){
        
        
				$name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        if(empty($name) OR empty($email) OR empty($subject) OR empty($message)){
					header("Location: contact.php?message=Empty+Fields");
					exit();
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					header("Location: contact.php?message=Please+Enter+A+Valid+email");
					exit();
        }else{

          $mail = new PHPMailer();

          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = '';
          $mail->Password = '';
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          $mail->isHTML(true);

          $mail->setFrom('','User');
          $mail->addAddress('','User');
          $mail->Subject =  $subject;
          $mail->Body = 'Name: ' . $name .'<br />'.'Email: ' . $email .'<br />'.'<br />'.'Poruka: '.'<br />' . nl2br($message) ;
  
         
          if($mail->send()){
            header('Location: index.php?message=Message+sent');
            exit(); 
          } else {
            header('Location: contact.php?message=Message+not+sent');
            exit(); 
        }
        }

      }

      ?>
    
  <?php
  include 'includes/header.php';
  include 'includes/hero.php';
  ?>


    <main class="content bg-light container py-5 min-hight">
      <div class="row justify-content-center">
        <div class="col-md-9 mb-md-0 mb-5 ">
          <form method="POST" id="contact-form" name="contact-form" >
              <div class="row">

                  <div class="col-md-6">
                      <div class="md-form mb-0">
                        <label for="name" class="">Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="md-form mb-0">
                        <label for="email" class="">Email</label>
                        <input type="text" id="email" name="email" class="form-control">  
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                      <div class="md-form mb-0">
                        <label for="subject" class="">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control">
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                      <div class="md-form">
                        <label for="message">Message</label>
                        <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                      </div>
                  </div>
              </div>
              <div class="text-center text-md-left d-flex justify-content-center">
           <button type="submit" name="submit" class="btn btn-primary my-4">Send</button>
            </div>
            </form>

           
          <div class="status"></div>
      </div>
     
     </div>
     
     
    </main>


    

    <?php include 'includes/footer.php'; ?> 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
