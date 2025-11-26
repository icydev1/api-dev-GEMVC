<?php
namespace App\Api;

use App\Controller\ProductController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Product extends ApiService
{
    /**
     * Constructor
     * 
     * @param Request \$request The HTTP request object
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Create new Product
     * 
     * @return JsonResponse
     * @http POST
     * @description Create new Product in database
     * @example /api/Product/create
     */
    public function create(): JsonResponse
    {
        if(!$this->request->definePostSchema([
            'name' => 'string',
            'description' => 'string'
        ])) {
            return $this->request->returnResponse();
        }
        return (new ProductController($this->request))->create();
    }

    /**
     * Read Product by ID
     * 
     * @return JsonResponse
     * @http GET
     * @description Get Product by id from database
     * @example /api/Product/read/?id=1
     */
    public function read(): JsonResponse
    {
        // Validate GET parameters
        if(!$this->request->defineGetSchema(["id" => "int"])) {
            return $this->request->returnResponse();
        }
        
        //get the id from the url and if not exist or not type of int return 400 die()
        $id = $this->request->intValueGet("id");
        if(!$id) {
            return $this->request->returnResponse();
        }
        
        //manually set the id to the post request
        $this->request->post['id'] = $id;
        return (new ProductController($this->request))->read();
    }

    /**
     * Update Product
     * 
     * @return JsonResponse
     * @http POST
     * @description Update existing Product in database
     * @example /api/Product/update
     */
    public function update(): JsonResponse
    {
        if(!$this->request->definePostSchema([
            'id' => 'int',
            '?name' => 'string',
            '?description' => 'string'
        ])) {
            return $this->request->returnResponse();
        }
        return (new ProductController($this->request))->update();
    }

    /**
     * Delete Product
     * 
     * @return JsonResponse
     * @http POST
     * @description Delete Product from database
     * @example /api/Product/delete
     */
    public function delete(): JsonResponse
    {
        if(!$this->request->definePostSchema([
            'id' => 'int',
        ])) {
            return $this->request->returnResponse();
        }
        return (new ProductController($this->request))->delete();
    }

    /**
     * List all Products
     * 
     * @return JsonResponse
     * @http GET
     * @description Get list of all Products with filtering and sorting
     * @example /api/Product/list/?sort_by=name&find_like=name=test
     */
    public function list(): JsonResponse
    {
        // Define searchable fields and their types
        $this->request->findable([
            'name' => 'string',
            'description' => 'string'
        ]);

        // Define sortable fields
        $this->request->sortable([
            'id',
            'name',
            'description'
        ]);
        
        return (new ProductController($this->request))->list();
    }

    /**
     * Generates mock responses for API documentation
     * 
     * @param string \$method The API method name
     * @return array<mixed> Example response data for the specified method
     * @hidden
     */
    public static function mockResponse(string $method): array
    {
        return match($method) {
            'create' => [
                'response_code' => 201,
                'message' => 'created',
                'count' => 1,
                'service_message' => 'Product created successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Sample Product',
                    'description' => 'Product description'
                ]
            ],
            'read' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 1,
                'service_message' => 'Product retrieved successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Sample Product',
                    'description' => 'Product description'
                ]
            ],
            'update' => [
                'response_code' => 209,
                'message' => 'updated',
                'count' => 1,
                'service_message' => 'Product updated successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Updated Product',
                    'description' => 'Updated description'
                ]
            ],
            'delete' => [
                'response_code' => 210,
                'message' => 'deleted',
                'count' => 1,
                'service_message' => 'Product deleted successfully',
                'data' => null
            ],
            'list' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 2,
                'service_message' => 'Products retrieved successfully',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Product 1',
                        'description' => 'Description 1'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Product 2',
                        'description' => 'Description 2'
                    ]
                ]
            ],
            default => [
                'success' => false,
                'message' => 'Unknown method'
            ]
        };
    }
} 