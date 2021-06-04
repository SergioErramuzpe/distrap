<?php


class Clase
{

    private static $instance;

    private function __construct () {
        $this->texto = null;
    }

    public static function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function algo ($alg) {
        echo $alg;
    }


}