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
        return [
            [
                'id' => 1,
                'name' => 'First Test Category Group'
            ],
            [
                'id' => 2,
                'name' => 'Second Test Category Group'
            ],
        ];
    }

    public function getOne(int $id) {
        return response()->json([
            'item' => [
                'id' => $id,
                'name' => 'First Test Category Group'
            ]
        ]);
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
