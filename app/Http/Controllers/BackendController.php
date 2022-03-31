<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\BackendInterface;
use App\Http\Middleware\BackendSecurity;
use Illuminate\Http\Request;

class BackendController extends Controller implements BackendInterface {

    public function __construct()
    {
        $this->middleware(BackendSecurity::class);
    }

    public function getList() {
        dd('get list');
    }

    public function getOne() {
        dd('get one');
    }

    public function createItem(Request $request)
    {
        // TODO: Implement createItem() method.
    }

    public function updateItem(Request $request, int $id)
    {
        // TODO: Implement updateItem() method.
    }

    public function deleteItem(int $id)
    {
        // TODO: Implement deleteItem() method.
    }

}
