<?php

if (isset($_GET['id'])){

  $supplierID = $_GET['id'];

  $sql = 'SELECT * FROM suppliers WHERE supplier_id='.$supplierID;
  $result = $db->query($sql);
  $row = $result->fetch();
  extract($row);
  echo '<div class="container-fluid">';
  echo '<h2 align="center">Supplier Details</h2></br>';
  echo '<div class="row"><div class="col-sm-3">Назва поставника:</div><div class="col-sm-6">'.$supplier_name.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Пошта:</div><div class="col-sm-6">'.$supplier_email.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Адреса:</div><div class="col-sm-6">'.$supplier_address.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Телефон:</div><div class="col-sm-6">'.$supplier_phone_mobile.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Робочій телефон:</div><div class="col-sm-6">'.$supplier_phone_work.'</div></div>';
  echo '</br>';
  echo '<div class="row"><div class="col-sm-3"><a href="index.php?content_page=suppliers"><h4><span class="	glyphicon glyphicon-fast-backward"></span>Назад до списку</h4></a></div></div></br>' ;
  echo '</div>';

}
else {
  header("Location: index.php?content_page=suppliers");
  exit();
}

?>
