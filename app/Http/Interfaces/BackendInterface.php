<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface BackendInterface {

    public function getList();

    public function getOne(int $id);

    public function createItem(Request $request);

    public function updateItem(Request $request, int $id);

    public function deleteItem(int $id);
}
