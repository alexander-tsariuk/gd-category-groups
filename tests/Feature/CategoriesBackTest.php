<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoriesBackTest extends TestCase
{
    /**
     * Создание группы категорий: Успешно
     * @return void
     */
    public function test_backend_create_success() {
        $response = $this->json('POST', '/api/v1/categories/items/backend/create', [
            'name' => 'Test Category',
            'seo_name' => 'test-category',
            'anchor_title' => 'The test anchor',
            'title' => 'Title',
            'h1' => 'H1',
            'description' => 'Description',
            'annotation' => 'Annotation',
            'group_id' => 1,
            'show_in_menu' => 1,
            'status' => 1,
            'id' => 99999
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('success', true)
                    ->where('code', 200)
                    ->whereType('data', 'array')
                    ->etc()
            );

    }

    /**
     * Создание группы категорий: Ошибка валидации - seo_name
     * @return void
     */
    public function test_backend_create_validationError_seoName() {
        $response = $this->json('POST', '/api/v1/categories/items/backend/create', [
            'seo_name' => 'test-category',
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }

    /**
     * Создание группы категорий: Ошибка валидации - name
     * @return void
     */
    public function test_backend_create_validationError_name() {
        $response = $this->json('POST', '/api/v1/categories/items/backend/create', [
            'seo_name' => 'te',
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }

    /**
     * Обновление группы категорий: Успешно
     * @return void
     */
    public function test_backend_update_success() {
        $response = $this->json('PUT', '/api/v1/categories/items/backend/update/99999', [
            'name' => 'Test Category',
            'seo_name' => 'test-category',
            'anchor_title' => 'The test anchor',
            'title' => 'Title',
            'h1' => 'H1',
            'description' => 'Description',
            'annotation' => 'Annotation',
            'group_id' => 1,
            'show_in_menu' => 1,
            'status' => 1,
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->where('code', 200)
                ->whereType('data', 'array')
                ->etc()
            );
    }

    /**
     * Обновление группы категорий: элемент не сущесвует
     * @return void
     */
    public function test_backend_update_notExists() {
        $response = $this->json('PUT', '/api/v1/categories/items/backend/update/99998', [
            'name' => 'Test Category',
            'seo_name' => 'test-category',
            'anchor_title' => 'The test anchor',
            'title' => 'Title',
            'h1' => 'H1',
            'description' => 'Description',
            'annotation' => 'Annotation',
            'group_id' => 1,
            'show_in_menu' => 1,
            'status' => 1,
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }

    /**
     * Обновление группы категорий: ошибка валидации - seo_name
     * @return void
     */
    public function test_backend_update_validationError_seoName() {
        $response = $this->json('PUT', '/api/v1/categories/items/backend/update/99999', [
            'name' => 'Test Category',
            'seo_name' => 'te',
            'anchor_title' => 'The test anchor',
            'title' => 'Title',
            'h1' => 'H1',
            'description' => 'Description',
            'annotation' => 'Annotation',
            'group_id' => 1,
            'show_in_menu' => 1,
            'status' => 1,
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }

    /**
     * Обновление группы категорий: ошибка валидации - name
     * @return void
     */
    public function test_backend_update_validationError_name() {
        $response = $this->json('PUT', '/api/v1/categories/items/backend/update/99999', [
            'name' => 'Te',
            'seo_name' => 'test-category',
            'anchor_title' => 'The test anchor',
            'title' => 'Title',
            'h1' => 'H1',
            'description' => 'Description',
            'annotation' => 'Annotation',
            'group_id' => 1,
            'show_in_menu' => 1,
            'status' => 1,
        ], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }

    /**
     * Получение 1 элемента: Успешно
     * @return void
     */
    public function test_backend_getOne_success() {
        $response = $this->json('GET', '/api/v1/categories/items/backend/getOne/99999', [], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->where('code', 200)
                ->whereType('data', 'array')
                ->etc()
            );
    }

    /**
     * Получение 1 элемента: Не найдено
     * @return void
     */
    public function test_backend_getOne_notExists() {
        $response = $this->json('GET', '/api/v1/categories/items/backend/getOne/99998', [], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }

    /**
     * Получение списка элементов
     * @return void
     */
    public function test_backend_list()
    {
        $response = $this->json('GET', '/api/v1/categories/items/backend/getList', [], [
            'site-id' => 1,
            'site-key' => 'site_key',
            'user-id' => 22
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('success', true)
                    ->where('code', 200)
                    ->has('data')
                    ->etc()
            );
    }

    /**
     * Удаление группы категорий: Успешно
     * @return void
     */
    public function test_backend_soft_delete_success() {
        $response = $this->json('DELETE', '/api/v1/categories/items/backend/delete/99999?soft=true', [], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->where('code', 200)
                ->whereType('data', 'array')
                ->etc()
            );
    }

    /**
     * Удаление группы категорий: Не найдено
     * @return void
     */
    public function test_backend_soft_delete_notExists() {
        $response = $this->json('DELETE', '/api/v1/categories/items/backend/delete/99998?soft=true', [], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->where('code', 422)
                ->where('message', 'Validation Errors!')
                ->whereType('errors', 'array')
                ->etc()
            );
    }


    /**
     * Удаление группы категорий: Успешно
     * @return void
     */
    public function test_backend_delete_success() {
        $response = $this->json('DELETE', '/api/v1/categories/items/backend/delete/99999', [], [
            'site-id' => 999,
            'site-key' => 'site_key',
            'user-id' => 777
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->where('code', 200)
                ->whereType('data', 'array')
                ->etc()
            );
    }
}
