<?php

/**
* Our homepage. Show the most recently added quote.
*
* controllers/Welcome.php
*
* ------------------------------------------------------------------------
*/
class Welcome extends Application {

    function __construct()
    {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
        $this->load->helper('url');
        // Build a list of orders
        $path = './data';
        $files = scandir($path);
        $orders = array();
        foreach ($files as $file) {
            if (preg_match("/^order\d+\.xml$/", $file)) {
                $filename = substr($file, 0, strlen($file) - 4);
                $order = new stdClass();
                $order->link = anchor("welcome/order/$filename", $filename);
                $orders[] = $order;
            }
        }

        // Present the list to choose from
        $this->data['pagebody'] = 'homepage';
        $this->data['orders'] = $orders;
        $this->render();
    }

    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
        // Build a receipt for the chosen order

        // Present the list to choose from
        $this->data['pagebody'] = 'justone';
        $this->render();
    }


}
