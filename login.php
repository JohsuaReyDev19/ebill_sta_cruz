<?php
require_once "function/check_session.php";
require './db/dbconn.php';
// Check if user_id and role sessions are already set
redirectToDashboard();

// Fetch current settings from the database
 $sql = "SELECT system_name, system_profile, system_preloader FROM system_settings WHERE settings_id = 1";
 $result = $con->query($sql);

 $currentSettings = null;
 if ($result->num_rows > 0) {
     $currentSettings = $result->fetch_assoc();
 }

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>e-Billing - Login</title>
      
      <!-- CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

      <link href="./css/login-style.php" rel="stylesheet">
      <!-- FONT -->

      <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

      <!-- SweetAlert2 CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

      <!-- SweetAlert2 JavaScript -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      <!-- Jquery -->
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

   </head>
   <body class="">
      <?php displaySessionErrorMessage(); ?>
      <!-- CONTAINER -->
      <div class="container d-flex align-items-center min-vh-100">
         <div class="row g-0 justify-content-center">
            <!-- TITLE -->
            <div class="col-lg-5 offset-lg-1 mx-0 px-0">
               <div id="title-container">
                  <img class="covid-image" src="./img/<?php echo $currentSettings['system_profile'] ?? 'mmwd.png'; ?>" alt="System Logo">
                  <h2>e-Billing</h2>
                  <h3><?php echo $currentSettings['system_name'] ?? ''; ?></h3>
                  <p>"Your gateway to efficient water bill management, where convenience meets accuracy. Experience a seamless process designed to simplify billing, payments, and account updates. Step into a world of reliability and transparency, where each interaction enhances your service experience. Access your water usage details, view and settle bills online, and stay informed with timely updates."</p>
               </div>
            </div>
            <!-- FORMS -->
            <div class="col-lg-7 mx-0 px-0">
               <div id="qbox-container" class="">
                  <form class="needs-validation" id="form-wrapper" method="post" name="form-wrapper" novalidate="" method="POST">
                     <div id="steps-container">
                        <div class="step col-12">
                           <h4>Login your account to get started!</h4>
                           <div class="">
                              <div class="form-floating mt-5">
                                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="" required>
                                <label for="username">Username</label>
                              </div>
                              <div class="form-floating mt-3">
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="" required>
                                <label for="password">Password</label>
                              </div>
                              <!-- Show Password Checkbox -->
                              <div class="form-check mt-3">
                                <input type="checkbox" class="form-check-input" id="show-password">
                                <label class="form-check-label" for="show-password">Show Password</label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="q-box__buttons">
                        <button id="login-btn" type="submit">Login</button>
                     </div>
                  </form>
                  <hr>
                  <p class="text-center">No account yet? <span><a href="register.php">Register!</a></span></p>
               </div>
            </div>
         </div>
      </div>

      <div id="preloader-wrapper">
         <div id="preloader"></div>
         <div class="preloader-section section-left"></div>
         <div class="preloader-section section-right"></div>
      </div>

      <script src="./js/login-script.js"></script>
      <script>
         // Show Password functionality
         document.getElementById('show-password').addEventListener('change', function () {
            const passwordField = document.getElementById('password');
            if (this.checked) {
               passwordField.type = 'text';
            } else {
               passwordField.type = 'password';
            }
         });
      </script>
      <script>
         document.getElementById("form-wrapper").addEventListener("keydown", function(event) {
             if (event.key === "Enter") {
                 // prevent form submit
                 event.preventDefault();

                 // optionally, move to the next field instead of submit
                 let inputs = Array.from(this.querySelectorAll("input, select, textarea"));
                 let index = inputs.indexOf(event.target);
                 if (index > -1 && index + 1 < inputs.length) {
                     inputs[index + 1].focus();
                 }
             }
         });
      </script>
   </body>
</html>