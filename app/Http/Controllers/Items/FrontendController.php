<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FrontendSecurity;
use App\Models\CategoryModel;

class FrontendController extends Controller {

    public function __construct()
    {
        $this->middleware(FrontendSecurity::class);
    }

    /**
     * Получаем категорию по её seo_name
     * @param string $seoName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOne(string $seoName): \Illuminate\Http\JsonResponse {
        try {
            $categoryItem = CategoryModel::frontendGetBySeoName($seoName);

            if(!$categoryItem) {
                return $this->failedResponse("Category Not Found!");
            }

            return $this->successResponse([$categoryItem]);

        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }
}
