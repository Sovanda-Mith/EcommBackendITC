<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test ID : Category--001
     * Description: Check if we can access the get all categories api
     * Precondition: None
     * Test Steps:   1. Hit the get all categories api
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_access_get_all_categories_api(): void
    {
        $response = $this->get('/api/categories');

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Category--002
     * Description: Check if we can access the create category api
     * Precondition: None
     * Test Steps:   1. Generate a random "name"
     *               2. Hit the create category api
     *               3. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_create_category(): void
    {
        $name = Factory::create()->company();
        $response = $this->post('/api/categories', ['name' => $name]);

        $response->assertStatus(200)->assertJsonFragment(['message' => "Category " . $name . " created"]);
    }
    /**
     * Test ID : Category--003
     * Description: Check if we can access the get category by id api
     * Precondition: Have a category id that is already in the database
     * Test Steps:   1. Hit the get category by id api
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_get_category_by_id(): void
    {
        $id = 1;
        $response = $this->get('/api/categories/' . $id);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);

    }
    /**
     * Test ID : Category--004
     * Description: Check if we can access the update category api
     * Precondition: Have a category id that is already in the database
     * Test Steps:   1. Generate a new random "name"
     *               2. Hit the update category api
     *               3. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_update_category(): void
    {
        $id = 1;
        $name = Factory::create()->company();
        $response = $this->patch('/api/categories/' . $id, ['name' => $name]);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Category--005
     * Description: Check if we can access the delete category api
     * Precondition: Have categories already in the database and have a category id that is already in the database
     * Test Steps:   1. Hit the delete category api
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_delete_category(): void
    {
        $id = 3;
        $response = $this->delete('/api/categories/' . $id);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
}
