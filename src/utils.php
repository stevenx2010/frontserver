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

// Get current date/time & format it in MySQL format
function getDateTime() {
    $datetime = getdate();
    $datetime_in_mysql_format = $datetime['year'] . '-' . $datetime['mon'] . '-' . $datetime['mday'] . ' ' .
                        $datetime['hours'] . ':' . $datetime['minutes'] . ':' . $datetime['seconds'];

    return $datetime_in_mysql_format;
};

?>