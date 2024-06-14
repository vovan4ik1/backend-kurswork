<?php

class User {
  private $user_id;
  private $last_name;
  private $first_name;
  private $email;
  private $address;
  private $mobile_phone;
  private $username;
  private $password;
  private $status;

  public function __construct($user_id, $last_name, $first_name, $email, $address, $mobile_phone, $username, $password, $status) {
    $this->user_id = $user_id;
    $this->last_name = $last_name;
    $this->first_name = $first_name;
    $this->email = $email;
    $this->address = $address;
    $this->mobile_phone = $mobile_phone;
    $this->username = $username;
    $this->password = $password;
    $this->status = $status;
  }

  public function getId() {
    return $this->user_id;
  }

  public function getLastName() {
    return $this->last_name;
  }

  public function getFirstName() {
    return $this->first_name;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getAdress() {
    return $this->address;
  }

  public function getMobile_Phone() {
    return $this->mobile_phone;
  }

  public function getUserName() {
    return $this->username;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getStatus() {
    return $this->status;
  }
}