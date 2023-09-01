<?php
include 'includes/connect.php';  // Connection to the database
session_start();

if (isset($_SESSION['user'])) {
    header("location:index.php") ; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Query the database to check if the user exists
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("location:index.php") ; 
        } else {
            $error = "Invalid email or password." ; 
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>




<!DOCTYPE html>
<html dir="ltr" lang="en">

<!-- Mirrored from creativelayers.net/themes/freeio-html/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Aug 2023 09:14:42 GMT -->
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


</head>
<body class="bgc-thm4">
<div class="wrapper ovh">
  <div class="preloader"></div>
  
  
  <?php include 'includes/navbar.php' ;  ?>
  
  <?php include 'includes/navbar_mobile.php' ;  ?>



  <div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title">Log In</h2>
                        <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p>
                    </div>
                </div>
            </div>
            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                        <div class="mb30">
                            <h4>We're glad to see you again!</h4>
                            <p class="text">Don't have an account? <a href="page-register.html" class="text-thm">Sign Up!</a></p>

                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <?php if (isset($_SESSION['success'])) { ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo "Account created successfully, please login." ?>
                                </div>
                            <?php } ?>

                        </div>
                        <form method="POST" action="login.php"> <!-- Change the action to your PHP processing script -->
                            <div class="mb20">
                                <label class="form-label fw600 dark-color">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="alitfn58@gmail.com">
                            </div>
                            <div class="mb15">
                                <label class="form-label fw600 dark-color">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="*******">
                            </div>
                            <div class="checkbox-style1 d-block d-sm-flex align-items-center justify-content-between mb20">
                                <label class="custom_checkbox fz14 ff-heading">Remember me
                                    <input type="checkbox" name="remember">
                                    <span class="checkmark"></span>
                                </label>
                                <a class="fz14 ff-heading" href="#">Lost your password?</a>
                            </div>
                            <div class="d-grid mb20">
                                <button class="ud-btn btn-thm" type="submit">Log In <i class="fal fa-arrow-right-long"></i></button>
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


    
    <?php include 'includes/footer.php' ; ?>


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

<!-- Mirrored from creativelayers.net/themes/freeio-html/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Aug 2023 09:14:42 GMT -->
</html>