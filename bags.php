
<?php
require_once('Controllers\BagControllers.php');
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = test_input($_POST["bagName"]);
  $description = test_input($_POST["description"]);
  $price = test_input($_POST["price"]);
  $category = $_POST["category"];
  $supplier = $_POST["supplier"];
  $target_image_dir = "images/products/";

  if (!empty($_FILES["imageFile"]["name"])){
    $target_image_file = $target_image_dir . basename($_FILES["imageFile"]["name"]);
  }
  else {
    $target_image_file = "images/products/default.jpg";
  }

  $data_exist = 0;

  $sql = 'SELECT * FROM bags ORDER BY bag_id';
  $result = $db->query($sql);
  while ($row = $result->fetch()) {
    if ($name == $row['bag_name']){
      $data_exist = 1;
    }
  }
    if ($data_exist){
      echo '<h4><Ця сумка вже існує. Будь ласка спробуйте ще раз.</h4>';
    }
    else{
      $uploadStatus = 1;
      imageUpload();
        if ($uploadStatus == 1){
          $sql = "INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('$name', '$description', '$price', '$target_image_file', '$category', '$supplier')";
          $result = $db->query($sql);
          if($result){
            echo '<h4>Додано новий предмет сумки.</h4>';
          }
          else {
            echo '<h4>База даних: не вдалося створити новий пакет</h4>';
          }
        }
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
if (isset($_SESSION['username'])){
  if($_SESSION['username'] == 'Admin'){
  echo '<div style="padding:10px">';
  echo '<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#bagModal">Створіть сумку</button>';
  echo '</div>';
  }
}
?>


 <div class="modal fade" id="bagModal" role="dialog">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Створити нову Сумку</h4>
       </div>
       <div class="modal-body">
         <div class="container">
           <?php echo BagСontrollers::displayCreateBagForm(); ?>
       </div>
       </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-success">Створити</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Відхилити</button>
         </form>
       </div>
     </div>
   </div>
 </div>
</div>

<?php
echo BagСontrollers::displayBags();
?>

<?php

function imageUpload() {

  if (!empty($_FILES["imageFile"]["name"])){
    global $uploadStatus, $target_image_dir, $target_image_file;

    $imageFileType = pathinfo($target_image_file,PATHINFO_EXTENSION);
    
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if($check !== false) {
            $uploadStatus = 1;
        } else {
            echo "<h4>Будь ласка, завантажте файл зображення.</h4>";
            $uploadStatus = 0;
        }
    }
    
    if (file_exists($target_image_file)) {
        echo "<h4>Ой! Цей файл уже існує.</h4>";
        $uploadStatus = 0;
    }

    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<h4>Дозволяються лише файли JPG, JPEG, PNG і GIF</h4>";
        $uploadStatus = 0;
    }
    
    if ($uploadStatus == 0) {
        echo "<h4>Ваш файл не було завантажено. Спробуйте знову</h4>";
    
    } else {
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_image_file)) {
            echo "<h4>Зображення ". basename( $_FILES["imageFile"]["name"]). " було завантажено.</h4>";
        } else {
            echo "<h4>На жаль, під час завантаження файлу сталася помилка. Будь ласка, повторіть спробу</h4>";
        }
    }
  }

}

?>
