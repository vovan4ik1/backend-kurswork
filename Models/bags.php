<?php

class Bags {
  private $bag_id;
  private $bag_name;
  private $bag_description;
  private $bag_price;
  private $bag_image_link;

  public function __construct($bag_id, $bag_name, $bag_description, $bag_price, $bag_image_link) {
    $this->bag_id = $bag_id;
    $this->bag_name = $bag_name;
    $this->bag_description = $bag_description;
    $this->bag_price = $bag_price;
    $this->bag_image_link = $bag_image_link;
  }

  public function getBag_id() {
    return $this->bag_id;
  }

  public function getBag_name() {
    return $this->bag_name;
  }

  public function getBag_description() {
    return $this->bag_description;
  }

  public function getBag_price() {
    return $this->bag_price;
  }

  public function getBag_image_link() {
    return $this->bag_image_link;
  }
}

?>