<?php

if (isset($_GET['id'])){

  $categoryID = $_GET['id'];

  $sql = 'SELECT * FROM categories WHERE category_id='.$categoryID;
  $result = $db->query($sql);
  $row = $result->fetch();
  extract($row);
  echo '<div class="container-fluid">';
  echo '<h2 align="center">Деталі Категорії</h2></br>';
  echo '<div class="row"><div class="col-sm-3">Назва Категорії:</div><div class="col-sm-6"><strong>'.$category_name.'</strong></div></div>';
  echo '<div class="row"><div class="col-sm-3">Опис Категорії:</div><div class="col-sm-6"><strong>'.$description.'</strong></div></div>';
  echo '</br><table class="table">';
  echo '<tr><th>Image</th><th>Назва</th><th>Опис</th><th>Ціна</th></tr>';
  $sqlBags = 'SELECT * FROM bags WHERE category_id='.$category_id;
  $resultBags = $db->query($sqlBags);
  while($rowBag = $resultBags->fetch()){
    extract($rowBag);
    echo '<tr>';
    echo '<td><img width="60" height="auto" src="'.$bag_image_link.'"></td>';
    echo '<td>'.$bag_name.'</td>';
    echo '<td>'.$bag_description.'</td>';
    echo '<td>'.$bag_price.'</td>';
    if (isset($_SESSION['username'])){
      if($_SESSION['username'] != 'Admin'){
        echo '<td><a href="index.php?content_page=cart&action=add&id='.$bag_id.'" class="btn btn-info">Додати до кошика</a></td>';
      }
    }
    else {
      echo '<td><a href="index.php?content_page=cart&action=add&id='.$bag_id.'" class="btn btn-info">Додати до кошика</a></td>';
    }
    echo '</tr>';
  }
  echo '</table></br>';
  echo '<div class="row"><div class="col-sm-3"></div><div class="col-sm-3"><a href="index.php?content_page=categories"><h4><span class="glyphicon glyphicon-fast-backward"></span> Повернутися до списку</h4></a></div>';
  echo '</div></div>';

}
else {
  header("Location: index.php?content_page=categories"); 
  exit();
}

?>
