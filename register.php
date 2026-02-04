<?php
require_once "function/check_session.php";
require './db/dbconn.php';
// Redirect if already logged in
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
      <title>e-Billing - Register</title>
      
      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
      <link href="./css/login-style.php" rel="stylesheet">

      <!-- Google Font -->
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

      <!-- SweetAlert2 -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
   </head>
   <body>
      <?php displaySessionErrorMessage(); ?>
      <div class="container d-flex align-items-center min-vh-100">
         <div class="row g-0 justify-content-center">
            <!-- LEFT SIDE -->
            <div class="col-lg-5 offset-lg-1 mx-0 px-0">
               <div id="title-container">
                  <img class="covid-image" src="./img/<?php echo $currentSettings['system_profile'] ?? 'mmwd.png'; ?>" alt="System Logo">
                  <h2>e-Billing</h2>
                  <h3><?php echo $currentSettings['system_name'] ?? ''; ?></h3>
                  <p>"Your gateway to efficient water bill management, where convenience meets accuracy. Experience a seamless process designed to simplify billing, payments, and account updates. Step into a world of reliability and transparency, where each interaction enhances your service experience. Access your water usage details, view and settle bills online, and stay informed with timely updates."</p>
               </div>
            </div>
            <!-- RIGHT SIDE -->
            <div class="col-lg-7 mx-0 px-0">
               <div class="progress">
                  <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%"></div>
               </div>
               <div id="qbox-container">
                  <form class="needs-validation" id="form-wrapper" method="post" novalidate>
                     <div id="steps-container">

                        <!-- STEP 1: Names -->
                        <div class="step col-12">
                           <h4>Provide us your personal information!</h4>
                           <div class="form-floating mt-3">
                              <input type="text" class="form-control" placeholder="" id="first_name" name="first_name" required>
                              <label for="first_name">First Name</label>
                           </div>
                           <div class="form-floating mt-3">
                              <input type="text" class="form-control" placeholder="" id="middle_name" name="middle_name">
                              <label for="middle_name">Middle Name</label>
                           </div>
                           <div class="form-floating mt-3">
                              <input type="text" class="form-control" placeholder="" id="last_name" name="last_name" required>
                              <label for="last_name">Last Name</label>
                           </div>
                           <div class="form-floating mt-3">
                              <select id="suffix_name" name="suffix_name" id="suffix_name" class="form-control form-select">
                                 <option value="NA" selected>NA</option>
                                 <option value="JR">JR</option>
                                 <option value="SR">SR</option>
                                 <option value="II">II</option>
                                 <option value="III">III</option>
                                 <option value="IV">IV</option>
                              </select>
                              <label for="suffix_name">Suffix</label>
                           </div>
                        </div>

                        <!-- STEP 2: Account Info -->
                        <div class="step col-12">
                           <h4>Provide us your preferred account information!</h4>
                           <div class="form-floating mt-3">
                              <input type="text" class="form-control" placeholder="" id="username" name="username" required>
                              <label for="username">Username</label>
                           </div>
                           <div class="form-floating mt-3">
                              <input type="email" class="form-control" placeholder="" id="email" name="email" required>
                              <label for="email">Email</label>
                           </div>
                           <div class="form-floating mt-3">
                              <input type="password" class="form-control" placeholder="" id="password" name="password" required>
                              <label for="password">Password</label>
                           </div>
                           <div class="form-floating mt-3">
                              <input type="password" class="form-control" placeholder="" id="confirm_password" name="confirm_password" required>
                              <label for="confirm_password">Confirm Password</label>
                           </div>
                        </div>

                        <!-- STEP 3: Confirmation -->
                        <div class="step col-12">
                           <div class="mt-1">
                              <div class="closing-text">
                                 <h4>That's it!</h4>
                                 <p class="my-1">Kindly double check your information before proceeding.</p>
                                 <p class="my-1">Tick the checkbox then click on the <span class="fst-italic">SUBMIT</span> button to continue.</p>
                              </div>
                              <div class="form-check mt-3">
                                   <input class="form-check-input" type="checkbox" id="confirmInfo" required>
                                   <label class="form-check-label" for="confirmInfo" id="confirmInfoLabel">
                                     I hereby declare that the information I provided is true.
                                   </label>
                              </div>
                           </div>
                        </div>

                        <!-- SUCCESS MESSAGE -->
                        <div id="success">
                           <h4>Registration Complete!</h4>
                           <p>Please wait for admin approval. You’ll receive a notification once your account is activated.</p>
                           <a href="login.php">Go to login ➜</a>
                        </div>

                     </div>

                     <!-- BUTTONS -->
                     <div id="q-box__buttons" class="d-flex justify-content-between mt-3">
                        <button id="prev-btn" type="button">Previous</button> 
                        <button id="next-btn" type="button">Next</button> 
                        <button id="submit-btn" type="submit">Submit</button>
                     </div>
                  </form>
                  <hr>
                  <p class="text-center">Already have an account? <a href="login.php">Login!</a></p>
               </div>
            </div>
         </div>
      </div>

      <!-- Preloader -->
      <div id="preloader-wrapper">
         <div id="preloader"></div>
         <div class="preloader-section section-left"></div>
         <div class="preloader-section section-right"></div>
      </div>

      <script src="./js/register-script.js"></script>
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

