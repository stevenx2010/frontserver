<?php

class Counter {
    public $mem;

    public function __construct($host) {
        $this->mem = new Memcache();
        $this->mem->connect($host, 11211);

    }

    public function setCount() {
        $count = $this->mem->get('count');
        if(!$count) {
            $count = 1;
        } else {
            $count++;
        }
        $this->mem->set('count', $count);
    }

    public function getCount() {
        return $this->mem->get('count');
    }
}

?>