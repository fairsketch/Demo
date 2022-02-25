<?php

namespace Demo\Controllers;

use App\Controllers\Security_Controller;

class Demo extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->template->rander('Demo\Views\demo\index');
    }

}
