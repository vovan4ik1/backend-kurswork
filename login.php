
<?php
if(isset($_SESSION['username'])){
    header('Location: index.php?content_page=Home');
    exit();
}
require_once('Controllers\userControllers.php');
require("ErrorFunctions.php");
$error_handler = set_error_handler("userErrorHandler");
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["userName"]) && isset($_POST["password"])){

    $userName = test_input($_POST["userName"]);
    $password = test_input($_POST["password"]);

    $sql = 'SELECT user_id, first_name, username, password, status FROM users WHERE username ="'.$userName.'" AND password ="'.$password.'"';
    $result = $db->query($sql);
    $rows = $result->size();
    if($rows == 1){
      while ($row = $result->fetch()) {
        $status = $row['status'];
        switch ($status) {
          case '1':
              echo '<h4 style="padding:10px;"> Ви ще не підтвердили свою електронну адресу. Будь ласка, перевірте свою поштову скриньку.</h4>';
            break;

          case '2':
              $_SESSION['username'] = $row['first_name'];
              $_SESSION['userid'] = $row['user_id'];
              if(isset($_SERVER["HTTP_REFERER"])){
                header('Location: '.$_SERVER["HTTP_REFERER"]);
                exit();
              }
              else {
                header('Location: index.php?content_page=Home');
                exit();
              }
            break;

          case '3':
              echo '<h4 style="padding:10px;">Ваш обліковий запис вимкнено. Будь ласка, зв\'яжіться з адміном</h4>';
            break;

          case '4':
              $_SESSION['username'] = "Admin";
              $_SESSION['userid'] = $row['user_id'];
              if(isset($_SERVER["HTTP_REFERER"])){
                header('Location: '.$_SERVER["HTTP_REFERER"]);
                exit();
              }
              else {
                header('Location: index.php?content_page=Home');
                exit();
              }
            break;

          default:
              echo '<h4 style="padding:10px;">Несподівана помилка входу. Будь ласка спробуйте ще раз</h4>';
            break;
        }
      }
    }
    else {
      echo '<h4 style="padding:10px;">Помилка логіну. Будь ласка, перевірте ім\'я користувача та пароль.</h4>';
    }
  }
  else {
    trigger_error("Помилка", E_USER_ERROR);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="panel panel-success">
<div class="panel-heading"><h2 text-align="center" style="padding:10px;">Увійти </h2></div>
  <div class="panel-body">
    <div class="container">
      <?php
      echo UsersControllers::displayLoginForm();
      ?>
      <button type="submit" class="btn btn-success">Увійти</button>
      <a href="index.php?content_page=register" class="btn btn-danger">Зареєстуватися</a>
      </form>
    </div>
  </div>
</div>
</div>
