<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit(); // Ensure script stops executing after redirection
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

    $sql="DELETE FROM `admin` WHERE `id` = '$delete_id'";
    $delete_admin =$conn->query($sql);
    
    header('location:admin_accounts.php');
    exit(); // Ensure script stops executing after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admins accounts</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admins accounts section starts  -->

<section class="accounts">

   <h1 class="heading">admins account</h1>

   <div class="box-container">

   <div class="box">
      <p>register new admin</p>
      <a href="register_admin.php" class="option-btn">register</a>
   </div>

   <?php
   $sql="SELECT * FROM `admin`";
      $select_account = $conn->query($sql);
      if ($select_account->rowCount() > 0) {
         while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <div class="box">
      <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
         <?php
            if ($fetch_accounts['id'] == $admin_id) {
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no accounts available</p>';
      }
   ?>

   </div>

</section>

<!-- admins accounts section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
