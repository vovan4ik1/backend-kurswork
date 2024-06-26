<?php
require_once('connectData\libcon.php');
require_once('Models\suppliers.php');

class SupplierControllers {

  public static function displaySuppliers() {
  	global $db;

  	$sql = 'SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_id';
  	$result = $db->query($sql);

    $output[] = '<div class="container"><table class="table table-striped">';
    $output[] = '<thead><tr><th>Назва</th></tr></thead>';
    $output[] = '<tbody>';

  	while ($row = $result->fetch()) {
      $output[] = '<tr>';
  		$output[] = '<td>'.$row['supplier_name'].'</td>';

      if (isset($_SESSION['username'])){
        if($_SESSION['username'] == 'Admin'){
          $output[] = '<td><a class="btn btn-info" href="index.php?content_page=supplierDetails&id='.$row['supplier_id'].'">Детальніше</a></td>';
        }
      }
      
      $output[] = '</tr>';
  	}
  	$output[] = '</tbody></table></div>';
  	echo join('',$output);
  }

  public static function displayCreateSupplierForm() {

    $output[] = '<div class="container"><form action="index.php?content_page=suppliers" method="POST" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="supplierName" class="control-label">Назва Поставника:</label><input type="text" class="form-control" id="supplierName" name="supplierName" placeholder="Нова назва постачальника" required></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="email" class="control-label">Пошта:</label><input type="email" class="form-control" id="email" name="email" placeholder="поштаl" required></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="address" class="control-label">Адреса:</label><input type="text" class="form-control" id="address" name="address" placeholder="Адресса" required></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="mobilePhone" class="control-label">Телефон:</label><input type="tel" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="Телефон"></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="workPhone" class="control-label">Телефон Офіса:</label><input type="tel" class="form-control" id="workPhone" name="workPhone" placeholder="Телефон офісу"></div></div><div class="row">';
  	echo join('',$output);
  }


}
?>
