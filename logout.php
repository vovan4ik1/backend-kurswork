<?php

if (isset($_SESSION['username'])){
  unset($_SESSION['username']);
  unset($_SESSION['userid']);
}
header("Location: index.php?content_page=Home");
exit();
?>
