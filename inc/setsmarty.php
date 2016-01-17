<?php
require('smarty/Smarty.class.php');

class smarty_yzblog extends Smarty {

    function __construct()
    {

        // Class Constructor.
        // These automatically get set with each new instance.

        parent::__construct();
        $this->setCompileDir('saemc://yzblog/');
        $this->setConfigDir('../');
        //$this->setCacheDir('saemc://yzblog/');

        $this->debugging = false;
        $this->caching = false;
        $this->cache_lifetime = 120;
        $this->compile_locking = false;
    }

}
?>