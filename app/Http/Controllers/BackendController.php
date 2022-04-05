<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\BackendInterface;
use App\Http\Middleware\BackendSecurity;
use App\Models\CategoryGroupModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BackendController extends Controller implements BackendInterface {

    public function __construct()
    {
        $this->middleware(BackendSecurity::class);
    }

    public function getList(): \Illuminate\Http\JsonResponse{
        try {
            $perPage = 10;

            if(\request()->has('perPage') && !empty(\request()->get('perPage'))) {
                $perPage = \request()->get('perPage');
            }

            $items = CategoryGroupModel::where('deleted', 0)
                ->orderBy('id', 'DESC')
                ->paginate($perPage);

            return $this->successResponse($items->toArray());

        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }

    public function getOne(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make([
                'id' => $id
            ], [
                'id' => 'required|integer|exists:category_groups,id'
            ]);

            if($validator->fails()) {
                return $this->validationErrorResponse($validator->errors());
            }

            $entity = CategoryGroupModel::where('deleted', 0)->where('id', $id)->first();

            if(!$entity) {
                throw new \Exception("Entity with current ID not found");
            }

            return $this->successResponse($entity->toArray());
        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }

    public function createItem(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:255',
                'seo_name' => 'required|string|min:3|max:255|unique:category_groups',
            ], [
                'required' => "Value of field :attribute must be filled!",
                'unique' => "Value of field :attribute must be unique!",
                'min' => "Value of field :attribute must be min :min symbols!",
                'max' => "Value of field :attribute must be max :max symbols!",
            ]);

            if($validator->fails()) {
                return $this->validationErrorResponse($validator->errors());
            }

            $entity = new CategoryGroupModel();

            $entity->fill([
                'name' => $request->get('name'),
                'seo_name' => $request->get('seo_name'),
                'status' => $request->get('status', 0),
                'created_by' => $request->header('user-id'),
                'site_id' => $request->header('site-id')
            ]);
            // для тестирования, чтобы не забивать БД
            if($request->has('id') && !empty($request->get('id')) && is_int($request->get('id'))) {
                $entity->id = $request->get('id');
            }

            if(!$entity->save()) {
                throw new \Exception("An error occurs while creating category groups!");
            }

            return $this->successResponse($entity->toArray());
        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }

    public function updateItem(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->all();
            $data['id'] = $id;

            $validator = Validator::make($data, [
                'id' => 'required|integer|exists:category_groups',
                'name' => 'required|min:3|max:255',
                'seo_name' => 'required|min:3|max:255|unique:category_groups,id,'.$id,
            ]);

            if($validator->fails()) {
                return $this->validationErrorResponse($validator->errors());
            }

            $entity = CategoryGroupModel::where('deleted', 0)->where('id', $id)->first();

            if(!$entity) {
                throw new \Exception("Entity not found!");
            }

            unset($data['id']);
            $entity->fill($data);
            $entity->updated_by = $request->header('user-id');

            if(!$entity->save()) {
                throw new \Exception("An error occurred while updating the selected item!");
            }

            return $this->successResponse($entity->toArray());

        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }

    public function deleteItem(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make([
                'id' => $id
            ], [
                'id' => 'required|integer|exists:category_groups'
            ], [
                'required' => "Value of field :attribute must be filled!",
                'exists' => "Entity with current ID not found!",
                'min' => "Value of field :attribute must be min :min symbols!",
                'max' => "Value of field :attribute must be max :max symbols!",
                'integer' => 'Value of field :attribute must be has integer type!'
            ]);

            if($validator->fails()) {
                return $this->validationErrorResponse($validator->errors());
            }

            $entity = CategoryGroupModel::find($id);

            if(!$entity) {
                throw new \Exception("Entity not found!");
            }

            $entity->deleted = 1;
            $entity->deleted_by = \request()->header('user-id');
            $entity->deleted_at = date('Y-d-m H:i:s');

            if(!$entity->save()) {
                throw new \Exception("An error occurred while deleting the selected item!");
            }

            return $this->successResponse([
                'deleted' => true,
                'message' => 'Selected item successfully deleted!'
            ]);

        } catch (\Exception $exception) {
            return $this->failedResponse($exception->getMessage());
        }
    }

}
