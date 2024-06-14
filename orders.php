<?php
require_once('Controllers\OrderManager.php');

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {

 if(isset($_POST["orderID"])){
    $orderID = test_input($_POST["orderID"]);
    $status = test_input($_POST["status"]);

    $sql = 'UPDATE orders SET order_status = "'.$status.'" WHERE order_id='.$orderID ;
    $result = $db->query($sql);
    if($result){
      echo '<h4>Статус замовлення оновлено для ідентифікатора замовлення: '.$orderID.'</h4></br>';
    }
    else {
      echo '<h4>Ой! Помилка бази даних. Не вдалося оновити статус замовлення для ідентифікатора замовлення: '.$orderID.'</h4></br>';
    }
   }
   else {
     echo '<h4>Недійсне оновлення замовлення. Будь ласка спробуйте ще раз.</h4></br>';
   }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



  <?php
  echo OrderControllers::displayOrders();
   ?>

</div>
