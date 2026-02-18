<?php
require '../db/dbconn.php';

// Get user ID from GET
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($user_id <= 0) die("Invalid User ID");

// Fetch user
$stmt = $con->prepare("SELECT * FROM users WHERE user_id=? AND deleted=0 LIMIT 1");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) die("User not found");
?>
<!DOCTYPE html>
<html>
<?php include './include/head.php'; ?>
<body id="page-top">

<div id="wrapper">
    <?php include './include/sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include './include/topbar.php'; ?>
            <div class="container-fluid">

                <!-- Multistep Progress -->
                <div class="row mb-4 text-center">
                    <div class="col-12">
                        <div class="multisteps-form__progress">
                            <button disabled class="multisteps-form__progress-btn js-active">Personal Info</button>
                            <button disabled class="multisteps-form__progress-btn">Contact Info</button>
                            <button disabled class="multisteps-form__progress-btn">Account Role</button>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form id="editUserForm" enctype="multipart/form-data">
                            <?php include 'form-add/edit-staff.php'; ?>
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <?php include './include/footer.php'; ?>
    </div>
</div>

<?php include './include/logout_modal.php'; ?>
<?php include './include/script.php'; ?>

<script>
$('#editUserForm').on('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    Swal.fire({title:'Updating...', allowOutsideClick:false, didOpen:()=>Swal.showLoading()});
    fetch('action/update-staff.php', {method:'POST', body:formData})
    .then(res=>res.json())
    .then(data=>{
        Swal.close();
        if(data.success){
            Swal.fire('Success!',data.message,'success').then(()=>location.href='users-active.php?title=Manage Active Users');
        } else {
            Swal.fire('Error!',data.message,'error');
        }
    })
    .catch(err=>{
        Swal.close();
        Swal.fire('Error!','Server error.','error');
        console.error(err);
    });
});
</script>
</body>
</html>
