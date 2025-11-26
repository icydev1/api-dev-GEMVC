<?php
/**
 * this is model layer. what so called Data logic layer
 * classes in this layer shall be extended from relevant classes in Table layer
 * classes in this layer  will be called from controller layer
 */
namespace App\Model;

use App\Table\StudentTable;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;

class StudentModel extends StudentTable
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create new Student
     * 
     * @return JsonResponse
     */
    public function createModel(): JsonResponse
    {
        $success = $this->insertSingleQuery();
        if ($this->getError()) {
            return Response::internalError("Failed to create Student: " . $this->getError());
        }
        return Response::created($success, 1, "Student created successfully");
    }

    /**
     * Get Student by ID
     * 
     * @return JsonResponse
     */
    public function readModel(): JsonResponse
    {
        $item = $this->selectById($this->id);
        if (!$item) {
            return Response::notFound("Student not found");
        }
        return Response::success($item, 1, "Student retrieved successfully");
    }

    /**
     * Update existing Student
     * 
     * @return JsonResponse
     */
    public function updateModel(): JsonResponse
    {
        $item = $this->selectById($this->id);
        if (!$item) {
            return Response::notFound("Student not found");
        }
        $success = $this->updateSingleQuery();
        if ($this->getError()) {
            return Response::internalError("Failed to update Student: " . $this->getError());
        }
        return Response::updated($success, 1, "Student updated successfully");
    }

    /**
     * Delete Student
     * 
     * @return JsonResponse
     */
    public function deleteModel(): JsonResponse
    {
        $item = $this->selectById($this->id);
        if (!$item) {
            return Response::notFound("Student not found");
        }
        $success = $this->deleteByIdQuery($this->id);
        if ($this->getError()) {
            return Response::internalError("Failed to delete Student: " . $this->getError());
        }
        return Response::deleted($success, 1, "Student deleted successfully");
    }
} 