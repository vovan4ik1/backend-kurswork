<?php
require_once('connectData\libcon.php');
require_once('Models\users.php');


class UsersControllers {


  public static function displayRegisterForm() {

    $output[] = '<form action="index.php?content_page=register" method="POST" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="lastName" class="control-label">"Ім\'я":</label><input type="text" class="form-control" id="lastName" name="lastName" placeholder="Прізвище" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="firstName" class="control-label">Прізвище:</label><input type="text" class="form-control" id="firstName" name="firstName" placeholder="Ім\'я" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="email" class="control-label">Пошта: (Це буде ваш логін)</label><input type="email" class="form-control" id="email" name="email" placeholder="Пошта" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="address" class="control-label">Aдреса:</label><input type="text" class="form-control" id="address" name="address" placeholder="Адреса" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="mobilePhone" class="control-label">Телефон:</label><input type="tel" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="Телефон" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="password" class="control-label">Пароль:</label><input type="password" class="form-control" id="password" name="password" placeholder="Пароль" maxlength="8" required></div></div>';

  	echo join('',$output);
  }


  public static function displayLoginForm() {

    $output[] = '<form action="index.php?content_page=login" method="POST" role="form" class="form-horizontal"><div class="row">';

    $output[] = '<div class="form-group col-xs-4"><label for="userName" class="control-label">Логін (або Email):</label><input type="text" class="form-control" id="userName" name="userName" placeholder="Логін" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="password" class="control-label">Пароль:</label><input type="password" class="form-control" id="password" name="password" placeholder="Пароль" required></div></div>';

  	echo join('',$output);
  }

  public static function displayMyOrders($userID) {
      global $db;

    	$sql = 'SELECT * FROM orders WHERE user_id='.$userID;
    	$result = $db->query($sql);

      $output[] = '<div class="container"><table class="table table-striped">';
      $output[] = '<thead><tr><th>Користувача ID</th><th>Логін</th><th>Ім\'я</th><th>Прізвище</th><th>Адреса</th><th>Телефон</th><th>Дата замовлення</th><th>Всього</th><th>GST</th><th>Статус</th></tr></thead>';
      $output[] = '<tbody>';

      while ($row = $result->fetch()) {
        $sqlUser = 'SELECT user_id, username FROM users WHERE user_id='.$userID;
      	$resultUser = $db->query($sqlUser);
        $rowUser = $resultUser->fetch();
        extract($rowUser);
        $output[] = '<tr>';
        $output[] = '<td>'.$row['order_id'].'</td>';
        $output[] = '<td>'.$username.'</td>';
        $output[] = '<td>'.$row['order_first_name'].'</td>';
        $output[] = '<td>'.$row['order_last_name'].'</td>';
        $output[] = '<td>'.$row['order_address'].'</td>';
        $output[] = '<td>'.$row['order_mobile_phone'].'</td>';
        $output[] = '<td>'.$row['order_date'].'</td>';
        $output[] = '<td>'.$row['total'].'</td>';
        $output[] = '<td>'.$row['order_status'].'</td>';
        $output[] = '</tr>';

    }
    $output[] = '<tbody></table></div>';
    echo join('',$output);
  }


  public static function displayUsers() {
      global $db;

      $sql = 'SELECT * FROM users WHERE status = 2 OR status = 3';
      $result = $db->query($sql);

      $output[] = '<div class="container"><table class="table table-striped">';
      $output[] = '<thead><tr><th>Користувача ID</th><th>"Ім\'я"</th>><th>Прізвище</th><th>Пошта</th><th>Адреса</th><th>Телефон</th><th>Логін</th><th>Статус</th></tr></thead>';
      $output[] = '<tbody>';

      while ($row = $result->fetch()) {
        $stat = $row['status'];
        $status = '';
        switch ($stat) {
          case '1':
            $status = 'Pending Verification';
            break;
          case '2':
            $status = 'Enabled';
            break;
          case '3':
            $status = 'Disabled';
            break;
          case '4':
            $status = 'Admin';
            break;

          default:
            $status = 'Invalid';
            break;
        }
        $output[] = '<tr>';
        $output[] = '<td>'.$row['user_id'].'</td>';
        $output[] = '<td>'.$row['first_name'].'</td>';
        $output[] = '<td>'.$row['last_name'].'</td>';
        $output[] = '<td>'.$row['email'].'</td>';
        $output[] = '<td>'.$row['address'].'</td>';
        $output[] = '<td>'.$row['mobile_phone'].'</td>';
        $output[] = '<td>'.$row['home_phone'].'</td>';
        $output[] = '<td>'.$row['username'].'</td>';
        $output[] = '<td>'.$status.'</td>';
        if($stat == 3){
          $output[] = '<td><a href="business_layer/users/enableDisable.php?id='.$row['user_id'].'" class="btn btn-success">Увімкнути</a></td>';
        }
        elseif($stat == 2) {
          $output[] = '<td><a href="business_layer/users/enableDisable.php?id='.$row['user_id'].'" class="btn btn-danger">Вимкнути</a></td>';
        }
        $output[] = '</tr>';

    }
    $output[] = '<tbody></table></div>';
    echo join('',$output);
  }
}
?>
