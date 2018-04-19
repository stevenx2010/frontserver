<?php

require_once '../config/env.php';

class Counter {
    private $mem;

    public function __construct($host) {
        if($GLOBALS['OS'] == 'Windows') {
            $this->mem = new Memcache();
            $this->mem->connect($host, 11211);
        }
        else {
            $this->mem = new Memcached();
            $this->mem->addServer($host, 11211);
        }
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

// Get current date/time & format it in MySQL format
function getDateTime() {
    $datetime = getdate();
    $datetime_in_mysql_format = $datetime['year'] . '-' . $datetime['mon'] . '-' . $datetime['mday'] . ' ' .
                        $datetime['hours'] . ':' . $datetime['minutes'] . ':' . $datetime['seconds'];

    return $datetime_in_mysql_format;
};

?>