<?php

class Order {
  private $order_id;
  private $order_last_name;
  private $order_first_name;
  private $order_address;
  private $order_mobile_phone;
  private $order_status_enum;
  private $order_date;
  private $total;

  public function __construct($order_id, $order_last_name, $order_first_name, $order_address, $order_mobile_phone, $order_status_enum, $order_date, $total) {
    $this->order_id = $order_id;
    $this->order_last_name = $order_last_name;
    $this->order_first_name = $order_first_name;
    $this->order_address = $order_address;
    $this->order_mobile_phone = $order_mobile_phone;
    $this->order_status_enum = $order_status_enum;
    $this->order_date = $order_date;
    $this->total = $total;
  }

  public function getOrder_id() {
    return $this->order_id;
  }

  public function getOrder_last_name() {
    return $this->order_last_name;
  }

  public function getOrder_first_name() {
    return $this->order_first_name;
  }

  public function getOrder_address() {
    return $this->order_address;
  }

  public function getOrder_mobile_phone() {
    return $this->order_mobile_phone;
  }

  public function getOrder_status_enum() {
    return $this->order_status_enum;
  }

  public function getOrder_date() {
    return $this->order_date;
  }

  public function getTotal() {
    return $this->total;
  }

  
}

?>