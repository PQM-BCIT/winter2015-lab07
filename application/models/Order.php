<?php

class Order extends MY_Model {

  private $menu = null;
  protected $xml = null;
  protected $total = 0.00;
  protected $burgers = array();

  public function __construct() {
    parent::__construct();
    $this->menu = new Menu();
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
    foreach ($this->xml->burger as $burger) {
      $food = new stdClass;
      $food->num = sizeof($this->burgers) + 1;
      $food->patty = $this->getItem($burger, 'patty');
      $food->cheeses = is_null($this->getItem($burger, 'cheeses')) ? "None" : $this->getItem($burger, 'cheeses');
      $food->sauces = is_null($this->getItem($burger, 'sauce')) ? "None" : $this->getItem($burger, 'sauce');
      $food->toppings = is_null($this->getItem($burger, 'topping')) ? "None" : $this->getItem($burger, 'topping');
      $this->burgers[] = $food;
    }

    return $this->burgers;
  }

  private function getItem($burger, $category) {
    $display = "";
    $items = array();
    if (isset($burger->$category)) {
      $item = $burger->$category;

      foreach ($item as $key => $value) {
        if (isset($value['type'])) {
          $items[] = $this->menu->getDetail($key, $value['type'], 'name');
          $this->total += $this->menu->getDetail($key, $value['type'], 'price');
        }
        if (isset($value['top'])) {
          $items[] = $this->menu->getDetail($key, $value['top'], 'name') . " (top)";
          $this->total += $this->menu->getDetail($key, $value['top'], 'price');
        }
        if (isset($value['bottom'])) {
          $items[] = $this->menu->getDetail($key, $value['bottom'], 'name') . " (bottom)";
          $this->total += $this->menu->getDetail($key, $value['bottom'], 'price');
        }
      }

      return implode(', ', $items);
    }
  }

}
