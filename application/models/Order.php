<?php

class Order extends MY_Model {

  private $menu = null;
  protected $xml = null;
  protected $total = 0.00;

  public function __construct() {
    parent::__construct();
    $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');
  }

  public function setXml($filename) {
    $this->xml = simplexml_load_file(DATAPATH . $filename . '.xml');
  }

  public function getName() {number_format('5.2', 2);
    return $this->xml->customer;
  }

  public function getTotal() {
    return $this->total;
  }

  public function getBurgers() {
    $burgers = array();
    foreach ($this->xml->burger as $burger) {
      $food = new stdClass;
      $food->num = sizeof($burgers) + 1;
      $food->patty = $this->getItem($burger, 'patty');
      $food->cheeses = is_null($this->getItem($burger, 'cheeses')) ? "None" : $this->getItem($burger, 'cheeses');
      $food->sauces = is_null($this->getItem($burger, 'sauce')) ? "None" : $this->getItem($burger, 'sauce');
      $food->toppings = is_null($this->getItem($burger, 'topping')) ? "None" : $this->getItem($burger, 'topping');
      $burgers[] = $food;
    }

    return $burgers;
  }

  private function getItem($burger, $category) {
    $display = "";
    $items = array();
    if (isset($burger->$category)) {
      $item = $burger->$category;

      foreach ($item as $key => $value) {
        if (isset($value['type'])) {
          $items[] = $value['type'];
        }
        if (isset($value['top'])) {
          $items[] = $value['top'] . " (top)";
        }
        if (isset($value['bottom'])) {
          $items[] = $value['bottom'] . " (bottom)";
        }
      }

      return implode(', ', $items);
    }
  }

  private function getPatty($burger) {
    $patty = $burger->patty['type'];

    return $patty;
  }

}
