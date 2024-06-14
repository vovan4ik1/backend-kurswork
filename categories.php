
<?php
require_once('Controllers\CategoriesControllers.php');
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = test_input($_POST["categoryName"]);
  $description = test_input($_POST["description"]);
  $data_exist = 0;

  $sql = 'SELECT * FROM categories ORDER BY category_id';
  $result = $db->query($sql);
  while ($row = $result->fetch()) {
    if ($name == $row['category_name']){
      $data_exist = 1;
    }
  }
    if ($data_exist){
      echo '<h4>Категорія вже існує. Будь ласка спробуйте ще раз.</h4>';
    }
    else{
      $sql = "INSERT INTO categories (category_name, description) VALUES ('$name', '$description')";
      $result = $db->query($sql);
      if($result){
        echo '<h4>Додано нову категорію.</h4>';
      }
      else {
        echo '<h4>База даних: не вдалося створити нову категорію</h4>';
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
  echo '<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#categoryModal">Створити категорію</button>';
  echo '</div>';
  }
}
?>


 <div class="modal fade" id="categoryModal" role="dialog">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Створити нову категорію</h4>
       </div>
       <div class="modal-body">
         <div class="container">
           <?php echo CategoryController::displayCreateCategoryForm(); ?>
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

<?php
echo CategoryController::displayCategories();

?>
</div>
