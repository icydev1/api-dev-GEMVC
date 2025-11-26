<?php

namespace App\Controller;

use App\Model\StudentModel;
use Gemvc\Core\Controller;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class StudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Create new Student
     * 
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new StudentModel());
        if(!$model instanceof StudentModel) {
            return $this->request->returnResponse();
        }
        return $model->createModel();
    }

    /**
     * Get Student by ID
     * 
     * @return JsonResponse
     */
    public function read(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new StudentModel());
        if(!$model instanceof StudentModel) {
            return $this->request->returnResponse();
        }
        return $model->readModel();
    }

    /**
     * Update existing Student
     * 
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new StudentModel());
        if(!$model instanceof StudentModel) {
            return $this->request->returnResponse();
        }
        return $model->updateModel();
    }

    /**
     * Delete Student
     * 
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new StudentModel());
        if(!$model) {
            return $this->request->returnResponse();
        }
        return $model->deleteModel();
    }

    /**
     * Get list of Students with filtering and sorting
     * 
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $model = new StudentModel();
        return $this->createList($model);
    }
} 