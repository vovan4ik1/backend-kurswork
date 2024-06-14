<?php
require_once('Controllers\Shopping.php');
require_once('Controllers\OrderManager.php');
require("ErrorFunctions.php");
$error_handler = set_error_handler("userErrorHandler");

if(!isset($_SESSION['username'])){
  header("Location: index.php?content_page=login");
  exit();
}
if(empty($_SESSION['cart'])){
  header("Location: index.php?content_page=bags"); 
  exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["address"]) && isset($_POST["firstName"])){
   global $db;

    $lastName = test_input($_POST["lastName"]);
    $firstName = test_input($_POST["firstName"]);
    $address = test_input($_POST["address"]);
    $mobilePhone = test_input($_POST["mobilePhone"]);
    $status = 'Pending';
    $date = date("Y-m-d");
    $user_id = $_SESSION['userid'];
    $cart = $_SESSION['cart'];

    if ($cart) {
  		$items = explode(',',$cart);
  		$contents = array();
  		$total = 0;
  		foreach ($items as $item) {
  			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
  		}
  		foreach ($contents as $id=>$qty) {
  			$sql = 'SELECT * FROM bags WHERE bag_id = '.$id;
  			$result = $db->query($sql);
  			$row = $result->fetch();
  			extract($row);
  			$subtotal = $bag_price * $qty;
        $subtotal = number_format($subtotal, 2);
  			$total += $bag_price * $qty;
  		}
      $total = number_format($total, 2);
      $gst = ($total/100) * 15;
      $gst = number_format($gst, 2);

      $sql = "INSERT INTO orders (order_last_name,order_first_name, order_address, order_mobile_phone, order_status, order_date, total, gst, user_id) VALUES ('$lastName', '$middleName', '$firstName', '$address', $homePhone, $mobilePhone, '$status', $date, $total, $gst, $user_id)";
      $result = $db->query($sql);
      if($result){
        $orderID = $result -> insertID();
        $purchased = 0;
        foreach ($contents as $id=>$qty) {
    			$sql = 'SELECT * FROM bags WHERE bag_id = '.$id;
    			$result = $db->query($sql);
    			$row = $result->fetch();
    			extract($row);
    			$subtotal = $bag_price * $qty;
          $subtotal = number_format($subtotal, 2);

          $sql = "INSERT INTO order_items (bag_id, quantity, subtotal, order_id) VALUES ('$id', '$qty', '$subtotal', '$orderID')";
          $result = $db->query($sql);
          if($result){
            $purchased = 1;
          }
    		}
        if ($purchased) {
          unset($_SESSION['cart']);
          $cart = NULL;
          echo '<h2>Дякую вам. Ваше замовлення розміщено з наведеними нижче даними</h2></br></br>';
          echo '<div class="panel panel-success"><div class="panel-heading"><h2 align="center" style="padding:10px;"> деталі замовлення </h2></div>';
          echo '<div class="panel-body"><div class="container">';
          echo OrderControllers::displayPurchaseOrder($orderID);
          echo '</div></div></div>';
        }

      }
      else {
        echo '<h4>Ой! Не вдалося оновити замовлення. Будь ласка, повторіть спробу</h4>';
      }

  	}
    else {
  		echo '<h4>Ваш кошик порожній.</h4>';
  	}
  }
  else {
    trigger_error("Помилка покупки: не вказано адресу та ім’я", E_USER_ERROR);
  }
}
else {

  $output[] = '<div class="panel panel-success"><div class="panel-heading"><h2 align="center" style="padding:10px;"> Форма купівлі </h2></div>';
  $output[] = '<div class="panel-body"><div class="container">';
  echo ShoppingСontrolers::showCart();

  $output[] = '</br></br>';
  $output[] = '<form action="index.php?content_page=purchased" method="POST" role="form" class="form-horizontal"><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="lastName" class="control-label">Ваше Прізвище:</label><input type="text" class="form-control" id="lastName" name="lastName" placeholder="Прізвище" required></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="firstName" class="control-label">Ім\'я:</label><input type="text" class="form-control" id="firstName" name="firstName" placeholder="Ім\'я" required></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="address" class="control-label">Адреса:</label><input type="text" class="form-control" id="address" name="address" placeholder="Адреса" required></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="mobilePhone" class="control-label">Телефон:</label><input type="tel" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="Телефон" required></div></div><div class="row">';
  $output[] = '<button type="submit" class="btn btn-success">Купити зараз</button>';
  $output[] = '</form></div></div></div>';

  echo join('',$output);

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
