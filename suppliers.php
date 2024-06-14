<?php
require_once('Controllers\suppliersControllers.php');
?>

<div class="container">

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = test_input($_POST["supplierName"]);
    $email = test_input($_POST["email"]);
    $address = test_input($_POST["address"]);
    $mobile = test_input($_POST["mobilePhone"]);
    $workPhone = test_input($_POST["workPhone"]);
    $data_exist = 0;

    $sql = 'SELECT supplier_name FROM suppliers ORDER BY supplier_id';
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
      if ($name == $row['supplier_name']){
        $data_exist = 1;
      }
    }
      if ($data_exist){
        echo '<h4>Постачальник вже існує. Будь ласка спробуйте ще раз.</h4>';
      }
      else{
        $sql = "INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work) VALUES ('$name', '$email', '$address', '$mobile', '$workPhone')";
        $result = $db->query($sql);
        if($result){
          echo '<h4>Додано нового постачальника.</h4>';
        }
        else {
          echo '<h4>База даних: не вдалося створити нового постачальника</h4>';
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
  echo '<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#supplierModal">Cтворити нового поставчальника</button>';
  echo '</div>';
  }
}
?>


 <div class="modal fade" id="supplierModal" role="dialog">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Cтворити нового постачальника</h4>
       </div>
       <div class="modal-body">
         <?php echo SupplierControllers::displayCreateSupplierForm(); ?>
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

echo SupplierControllers::displaySuppliers();
?>
