<?php
require_once('Controllers\userControllers.php');

if (isset($_SESSION['username'])){
  if($_SESSION['username'] != 'Admin'){
    header("Location: index.php?content_page=Home");
    exit();
  }
}
else {
  header("Location: index.php?content_page=Home");
  exit(); 
}

?>

<div class="container">
  <?php
  echo UsersControllers::displayUsers();
   ?>
</div>
