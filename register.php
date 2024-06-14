
<?php
if(isset($_SESSION['username'])){
  header("Location: index.php?content_page=Home"); 
}
require_once('Controllers\userControllers.php');
require("ErrorFunctions.php");
$error_handler = set_error_handler("userErrorHandler");
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["email"]) && isset($_POST["password"])){

    $lastName = test_input($_POST["lastName"]);
    $firstName = test_input($_POST["firstName"]);
    $email = test_input($_POST["email"]);
    $address = test_input($_POST["address"]);
    $mobilePhone = test_input($_POST["mobilePhone"]);
    $homePhone = test_input($_POST["homePhone"]);
    $password = test_input($_POST["password"]);
    $username = $email;
    $hash = md5( rand(0,1000) );
    $status = 1;
    $data_exist = 0;

    $sql = 'SELECT username FROM users ORDER BY user_id';
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
      if ($username == $row['username']){
        $data_exist = 1;
        break;
      }
    }
      if ($data_exist){
        echo '<h4>"ім\я"користувача вже існує. Будь ласка спробуйте ще раз.</h4>';
      }
      else{
        $sql = "INSERT INTO users (last_name, first_name, email, address, home_phone, mobile_phone, username, password, status) VALUES ('$lastName','$firstName', '$email', '$address', $homePhone, $mobilePhone, '$username', '$password', '$status')";
        $result = $db->query($sql);
        if($result){
          send_mail($email, $hash);
          echo '<h4>код підтвердження надіслано на вашу електронну адресу. Будь ласка, перевірте.</h4>';
        }
        else {
          echo '<h4>Помилка бази даних: Ваша реєстрація не вдалася. Будь ласка, повторіть спробу.</h4>';
        }
      }
  }
  else {
    trigger_error("Помилка реєстрації: не вказано адресу електронної пошти та пароль", E_USER_ERROR);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function send_mail($email, $hash) {
  $to = $email;
  $subject = 'Signup | Verification - VolodarBags.com.ua'; 
  $message = '

  Дякуємо за реєстрацію на нашому сайті!
  Ваш обліковий запис створено. Підтвердьте свою адресу електронної пошти, натиснувши посилання нижче.
  '."\r\n".'


  Натисніть це посилання, щоб активувати свій обліковий запис:'."\r\n".'
  http://'.$_SERVER["HTTP_HOST"].'/HomeUser/Volodarbag/index.php?content_page=verification&email='.$email.'

  ';

  $headers = 'From:Shop@VolodarBags.com' . "\r\n";
  mail($to, $subject, $message, $headers);
}
?>

<div class="panel panel-success">
<div class="panel-heading"><h2style="padding:10px;">Зареєструватися</h2></div>
  <div class="panel-body">
    <div class="container">
      <?php
      echo UsersControllers::displayRegisterForm();
      ?>
      <button type="submit" class="btn btn-success">Зареєструватися</button>
      <a href="index.php?content_page=login" class="btn btn-danger">Увійти</a>
      </form>
    </div>
  </div>
</div>
</div>
