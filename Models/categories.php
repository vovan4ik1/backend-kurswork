<?php
class Categories {
  private $category_id;
  private $category_name ;
  private $description;
 

  public function __construct($category_id, $category_name, $description) {
    $this->category_id = $category_id;
    $this->category_name = $category_name;
    $this->description = $description;
  }

  public function getCategory_id() {
    return $this->category_id;
  }

  public function getCategory_name() {
    return $this->category_name;
  }

  public function getDescription() {
    return $this->description;
  }

}
?>