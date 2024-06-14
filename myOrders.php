<?php
require_once('Controllers\userControllers.php');

if(!isset($_SESSION['username'])){
  header("Location: index.php?content_page=login");
  exit();
}
?>

<div class="container">
  <?php
  $userID = $_SESSION['userid'];
  echo UsersControllers::displayMyOrders($userID);
   ?>
</div>
