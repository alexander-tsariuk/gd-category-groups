<?php

namespace App\Http\Controllers;

use App\Http\Middleware\FrontendSecurity;

class FrontendController extends Controller {

    public function __construct()
    {
        $this->middleware(FrontendSecurity::class);
    }


}
