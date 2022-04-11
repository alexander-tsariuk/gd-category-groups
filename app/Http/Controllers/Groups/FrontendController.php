<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FrontendSecurity;

class FrontendController extends Controller {

    public function __construct()
    {
        $this->middleware(FrontendSecurity::class);
    }


}
