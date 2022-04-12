<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Table extends Controller
{
    public $columns = array();
    public $rows = array();
    public $items = array();

    public $action = array();
    public $btns = array();
    public $events = array();
    
    public function create(){
        return  ["columns"=>$this->columns,"rows"=>$this->rows,"items"=>$this->items,"action"=>$this->action,"btns"=>$this->btns,"events"=>$this->events];
    }

    
}
