<?php

require_once('connectData\libcon.php');
require_once('Models\categories.php');

class CategoryController {

  public static function displayCategories() {
  	global $db;

  	$sql = 'SELECT * FROM categories ORDER BY category_id';
  	$result = $db->query($sql);

    $output[] = '<div class="container"><table class="table table-striped">';
    $output[] = '<thead><tr><th>Категорія</th><th>Опис</th></tr></thead>';
    $output[] = '<tbody>';

  	while ($row = $result->fetch()) {
      $output[] = '<tr>';
  		$output[] = '<td>'.$row['category_name'].'</td><td>'.$row['description'].'</td>';
      $output[] = '<td><a href="index.php?content_page=categoryDetails&id='.$row['category_id'].'" class="btn btn-warning">Детальніше</a></td>';
      $output[] = '</tr>';
  	}
  	$output[] = '<tbody></table></div>';
  	echo join('',$output);
  }


  public static function displayCreateCategoryForm() {

    $output[] = '<form action="index.php?content_page=categories" method="POST" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-sm-4"><label for="categoryName" class="control-label">Назва категорії:</label><input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="нова назва категорії" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-sm-4"><label for="description" class="control-label">Опис:</label><input type="text" class="form-control" id="description" name="description" placeholder="Опис Категорії" required></div></div>';
    $output[] = '</form>';

  	echo join('',$output);
  }


}
?>
