<?php
namespace App\Api;

use App\Controller\StudentController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Student extends ApiService
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
     * Create new Student
     * 
     * @return JsonResponse
     * @http POST
     * @description Create new Student in database
     * @example /api/Student/create
     */
    public function create(): JsonResponse
    {
        if(!$this->request->definePostSchema([
            'name' => 'string',
            'description' => 'string',
            'class' => 'string'
        ])) {
            return $this->request->returnResponse();
        }
        return (new StudentController($this->request))->create();
    }

    /**
     * Read Student by ID
     * 
     * @return JsonResponse
     * @http GET
     * @description Get Student by id from database
     * @example /api/Student/read/?id=1
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
        return (new StudentController($this->request))->read();
    }

    /**
     * Update Student
     * 
     * @return JsonResponse
     * @http POST
     * @description Update existing Student in database
     * @example /api/Student/update
     */
    public function update(): JsonResponse
    {
        if(!$this->request->definePostSchema([
            'id' => 'int',
            '?name' => 'string',
            '?description' => 'string',
            '?class' => 'string'
        ])) {
            return $this->request->returnResponse();
        }
        return (new StudentController($this->request))->update();
    }

    /**
     * Delete Student
     * 
     * @return JsonResponse
     * @http POST
     * @description Delete Student from database
     * @example /api/Student/delete
     */
    public function delete(): JsonResponse
    {
        if(!$this->request->definePostSchema([
            'id' => 'int',
        ])) {
            return $this->request->returnResponse();
        }
        return (new StudentController($this->request))->delete();
    }

    /**
     * List all Students
     * 
     * @return JsonResponse
     * @http GET
     * @description Get list of all Students with filtering and sorting
     * @example /api/Student/list/?sort_by=name&find_like=name=test
     */
    public function list(): JsonResponse
    {
        // Define searchable fields and their types
        $this->request->findable([
            'name' => 'string',
            'description' => 'string',
            'class' => 'string'
        ]);

        // Define sortable fields
        $this->request->sortable([
            'id',
            'name',
            'description',
            'class'
        ]);
        
        return (new StudentController($this->request))->list();
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
                'service_message' => 'Student created successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Sample Student',
                    'description' => 'Student description',
                    'class' => "Secondary"
                ]
            ],
            'read' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 1,
                'service_message' => 'Student retrieved successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Sample Student',
                    'description' => 'Student description',
                    'class' => "Secondary"
                ]
            ],
            'update' => [
                'response_code' => 209,
                'message' => 'updated',
                'count' => 1,
                'service_message' => 'Student updated successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Updated Student',
                    'description' => 'Updated description',
                    'class' => "Secondary"
                ]
            ],
            'delete' => [
                'response_code' => 210,
                'message' => 'deleted',
                'count' => 1,
                'service_message' => 'Student deleted successfully',
                'data' => null
            ],
            'list' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 2,
                'service_message' => 'Students retrieved successfully',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Student 1',
                        'description' => 'Description 1',
                        'class' => "Secondary"
                    ],
                    [
                        'id' => 2,
                        'name' => 'Student 2',
                        'description' => 'Description 2',
                        'class' => "Secondary"
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