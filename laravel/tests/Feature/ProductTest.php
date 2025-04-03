<?php

namespace Tests\Feature;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test ID : Product--001
     * Description: Check if we can access the get all products api
     * Precondition: None
     * Test Steps:   1. Hit the get all products
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_get_all_products(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Product--002
     * Description: Check if we can access the create product api
     * Precondition: Have category id that is already in the database
     * Test Steps:   1. Generate random values for attributes
     *               2. Hit the create product api
     *               3. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_create_product(): void
    {
        $category_id = 1;
        $name = Factory::create()->company();
        $description = Factory::create()->text(50);
        $pricing = Factory::create()->numberBetween(50, 100);
        $images = null;

        $response = $this->post('/api/products', [
            'name' => $name,
            'category_id' => $category_id,
            'description' => $description,
            'pricing' => $pricing,
            'images' => $images
        ]);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Product--003
     * Description: Check if we can access the get product by id api
     * Precondition: Have product id that is already in the database
     * Test Steps:   1. Hit the get product by id api
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_get_product_by_id(): void
    {
        $product_id = 10;
        $response = $this->get('/api/products/' . $product_id);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Product--004
     * Description: Check if we can access the update product api
     * Precondition: Have a product id and a category id that is already in the database
     * Test Steps:   1. Generate random values for attributes
     *               2. Hit the update product api
     *               3. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_update_product(): void
    {
        $product_id = 10;
        $category_id = 1;
        $name = Factory::create()->company();
        $description = Factory::create()->text(50);
        $pricing = Factory::create()->numberBetween(50, 100);
        $images = null;

        $response = $this->patch('/api/products/' . $product_id, [
            'name' => $name,
            'category_id' => $category_id,
            'description' => $description,
            'pricing' => $pricing,
            'images' => $images
        ]);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Product--005
     * Description: Check if we can access the delete product api
     * Precondition: Have products already in the database and have a product id that is already in the database
     * Test Steps:   1. Hit the delete product api
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_delete_product(): void
    {
        $product_id = 9;
        $response = $this->delete('/api/products/' . $product_id);

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
    /**
     * Test ID : Product--006
     * Description: Check if we can access the get products by category id api
     * Precondition: Have products already in the database and have a category id that is a foreign key to some products
     * Test Steps:   1. Hit the get products by category id api
     *               2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_if_we_can_get_products_by_category_id(): void
    {
        $category_id = 3;
        $response = $this->get('/api/categories/' . $category_id . '/products');

        $response->assertStatus(200)->assertJsonFragment(['message' => 'success']);
    }
}
