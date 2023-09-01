<?php
include 'includes/connect.php';  // Connection to the database
session_start();

if (isset($_SESSION['user'])) {
    header("location:index.php") ; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['password'] != $_POST['confirm']) {
        $error = "Passwords do not match. Please try again.";
    } else {
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $email = $_POST['email'];
          $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
          $created_at = date('Y-m-d H:i:s');  // Current date and time

          // Check if the email already exists in the database
          $emailExistsQuery = "SELECT COUNT(*) FROM user WHERE email = :email";
          $stmtExists = $db->prepare($emailExistsQuery);
          $stmtExists->bindParam(':email', $email);
          $stmtExists->execute();
          $emailCount = $stmtExists->fetchColumn();

          if ($emailCount > 0) {
              $error = "Email already exists. Please choose a different email.";
          } else {
              try {
                  $db->beginTransaction();

                  $query = "INSERT INTO user (first_name, last_name, email, password, created_at) VALUES (:first_name, :last_name, :email, :password, :created_at)";
                  $stmt = $db->prepare($query);

                  $stmt->bindParam(':first_name', $first_name);
                  $stmt->bindParam(':last_name', $last_name);
                  $stmt->bindParam(':email', $email);
                  $stmt->bindParam(':password', $password);
                  $stmt->bindParam(':created_at', $created_at);

                  $stmt->execute();

                  $user_id = $db->lastInsertId(); // Get the ID of the inserted user

                  // Insert into the "profile" table
                  $profile_query = "INSERT INTO profile (user_id) VALUES (:user_id)";
                  $profile_stmt = $db->prepare($profile_query);
                  $profile_stmt->bindParam(':user_id', $user_id);
                  $profile_stmt->execute();

                  $db->commit();

                  $_SESSION["success"] = true; 
                  header("location:login.php");
              } catch (PDOException $e) {
                  $db->rollBack();
                  echo "Error: " . $e->getMessage();
              }
          
        }
      
  }
}
?>





<!DOCTYPE html>
<html dir="ltr" lang="en">

<!-- Mirrored from creativelayers.net/themes/freeio-html/page-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Aug 2023 09:14:42 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="bidding, fiverr, freelance marketplace, freelancers, freelancing, gigs, hiring, job board, job portal, job posting, jobs marketplace, peopleperhour, proposals, sell services, upwork">
<meta name="description" content="Freeio - Freelance Marketplace HTML Template">
<meta name="CreativeLayers" content="ATFN">
<!-- css file -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/ace-responsive-menu.css">
<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/fontawesome.css">
<link rel="stylesheet" href="css/flaticon.css">
<link rel="stylesheet" href="css/bootstrap-select.min.css">
<link rel="stylesheet" href="css/ud-custom-spacing.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/style.css">
<!-- Responsive stylesheet -->
<link rel="stylesheet" href="css/responsive.css">
<!-- Title -->
<title>Freeio - Freelance Marketplace HTML Template</title>
<!-- Favicon -->
<link href="images/favicon.ico" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
<link href="images/favicon.ico" sizes="128x128" rel="shortcut icon" />
<!-- Apple Touch Icon -->
<link href="images/apple-touch-icon-60x60.png" sizes="60x60" rel="apple-touch-icon">
<link href="images/apple-touch-icon-72x72.png" sizes="72x72" rel="apple-touch-icon">
<link href="images/apple-touch-icon-114x114.png" sizes="114x114" rel="apple-touch-icon">
<link href="images/apple-touch-icon-180x180.png" sizes="180x180" rel="apple-touch-icon">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="bgc-thm4">
<div class="wrapper ovh">
  <div class="preloader"></div>
  


  <?php include 'includes/navbar.php' ; ?>

  <?php include 'includes/navbar_mobile.php' ;  ?>


  <div class="body_content">
    <!-- Our SignUp Area -->
    <section class="our-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center">
                    <h2 class="title">Register</h2>
                    <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p>
                </div>
            </div>
        </div>
        <div class="row wow fadeInRight" data-wow-delay="300ms">
            <div class="col-xl-6 mx-auto">
                <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                    <div class="mb30">
                        <h4>Let's create your account!</h4>
                        <p class="text mt20">Already have an account? <a href="login.php" class="text-thm">Log In!</a></p>
                        
                        <?php

                          if (isset($error)) {
                            echo "<div class='alert alert-danger' role='alert'>$error</div>";
                          }
                        
                        ?>
                        

                    </div>
                    <form method="POST" action=""> <!-- Change the action to your PHP processing script -->
                        <div class="mb25">
                            <label class="form-label fw500 dark-color">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="First name">
                        </div>
                        <div class="mb25">
                            <label class="form-label fw500 dark-color">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Last name">
                        </div>
                        <div class="mb25">
                            <label class="form-label fw500 dark-color">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="alitfn58@gmail.com">
                        </div>
                        <div class="mb15">
                            <label class="form-label fw500 dark-color">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="*******">
                        </div>
                        <div class="mb15">
                            <label class="form-label fw500 dark-color">Confirm password</label>
                            <input type="password" class="form-control" name="confirm" placeholder="*******">
                        </div>
                        <div class="d-grid mb20">
                            <button class="ud-btn btn-thm default-box-shadow2" type="submit">Create Account <i class="fal fa-arrow-right-long"></i></button>
                        </div>
                    </form>
                    <div class="hr_content mb20"><hr><span class="hr_top_text">OR</span></div>
                    <div class="d-md-flex justify-content-between">
                        <button class="ud-btn btn-fb fz14 fw400 mb-2 mb-md-0" type="button"><i class="fab fa-facebook-f pr10"></i> Continue Facebook</button>
                        <button class="ud-btn btn-google fz14 fw400 mb-2 mb-md-0" type="button"><i class="fab fa-google"></i> Continue Google</button>
                        <button class="ud-btn btn-apple fz14 fw400" type="button"><i class="fab fa-apple"></i> Continue Apple</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    
    <?php include 'includes/footer.php' ;  ?>


    <a class="scrollToHome" href="#"><i class="fas fa-angle-up"></i></a>
  </div>
</div>
<!-- Wrapper End --> 
<script src="js/jquery-3.6.4.min.js"></script>
<script src="js/jquery-migrate-3.0.0.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/jquery.mmenu.all.js"></script>
<script src="js/ace-responsive-menu.js"></script>
<script src="js/jquery-scrolltofixed-min.js"></script>
<script src="js/wow.min.js"></script>
<!-- Custom script for all pages -->
<script src="js/script.js"></script>
</body>

<!-- Mirrored from creativelayers.net/themes/freeio-html/page-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Aug 2023 09:14:42 GMT -->
</html>