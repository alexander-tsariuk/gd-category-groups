<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FrontendSecurity;
use App\Models\CategoryGroupModel;

class FrontendController extends Controller {

    public function __construct()
    {
        $this->middleware(FrontendSecurity::class);
    }

    public function getMenu(): \Illuminate\Http\JsonResponse
    {
        try {
            $menu = CategoryGroupModel::getMenu();

            return $this->successResponse($menu->toArray());

        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }
}
