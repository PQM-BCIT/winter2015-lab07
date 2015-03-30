<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $menu = array();

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');

        $this->buildList('patties');
        $this->buildList('cheeses');
        $this->buildList('toppings');
        $this->buildList('sauces');
    }

    private function getLookup($category) {
        switch ($category) {
            case 'patties':
                return 'patty';
            case 'cheeses':
                return 'cheese';
            case 'toppings':
                return 'topping';
            case 'sauces':
                return 'sauce';
            default:
                return null;
        }
    }

    private function getKey($lookup) {
        switch ($lookup) {
            case 'patty':
                return 'patties';
            case 'topping':
                return 'toppings';
            case 'sauce':
                return 'sauces';
            case 'cheese':
                return 'cheeses';
            default:
                return $lookup;
        }
    }

    private function buildList($category) {
        $lookup = $this->getLookup($category);
        foreach ($this->xml->$category->$lookup as $item) {
            $record = new stdClass();
            $record->code = (string) $item['code'];
            $record->name = (string) $item;
            $record->price = (float) $item['price'];
            $this->menu[$category][$record->code] = $record;
        }

    }

    public function getDetail($lookup, $code, $name) {
        $key = $this->getKey($lookup);
        $category_menu = $this->menu[$key];

        return $category_menu[(string) $code]->$name;
    }

}
