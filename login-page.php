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
                    <form id="loginForm">
                        <!-- Title -->
                        <h4 class="mt-5">Login your account to get started!</h4>
                        <hr>

                        <!-- Username -->
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <label for="password">Password</label>

                            <!-- Show password button -->
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword()">
                                Show
                            </button>
                        </div>

                        <!-- Submit button -->
                        <div id="q-box__buttons" class="d-grid mt-3">
                            <button id="login-btn" type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>

                <hr>

                <!-- Optional register link -->
                <!-- <p class="text-center mt-3">No account yet? <a href="register.php">Register!</a></p> -->
               </div>
            </div>
         </div>
      </div>

      <div id="preloader-wrapper">
         <div id="preloader"></div>
         <div class="preloader-section section-left"></div>
         <div class="preloader-section section-right"></div>
      </div>
      <script>
    // Toggle password visibility
    // Toggle password visibility
function togglePassword() {
    const passwordField = document.getElementById('password');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
    } else {
        passwordField.type = 'password';
    }
}

// AJAX login
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
        const response = await fetch('./action/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = './admin/index.php';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    } catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong. Please try again.'
        });
        console.error(err);
    }
});

</script>
   </body>
</html>