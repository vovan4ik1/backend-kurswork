<?php
require_once('connectData\libcon.php');
global $db;

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

   
    $email = mysql_escape_string($_GET['email']); 
    $hash = mysql_escape_string($_GET['hash']); 

    $sql = 'SELECT email, hash FROM users WHERE email="'.$email.'" AND hash="'.$hash.'"';
    $result = $db->query($sql);
    $rows = $result->size();

    if($rows == 1){
        
        $sql = 'UPDATE users SET status = 2 WHERE email="'.$email.'" AND hash="'.$hash.'"';
        $result = $db->query($sql);
        if($result){
          echo '<h3>Перевірка електронної пошти успішна. Будь ласка <a href="index.php?content_page=login">Логін</a></h3>';
        }
        else {
          echo '<h3> Ой! Не вдалося перевірити. Помилка оновлення БД. Будь ласка, повторіть спробу.</h3>';
        }
    }else{
        
        echo '<h3> Не вдалося перевірити. Будь ласка, повторіть спробу.</h3>';
    }

}
else{
    
    echo '<h3>Не вдалося перевірити. Перейдіть за посиланням, наданим у вашому електронному листі.</h3>';
}
?>
