<?php

namespace App\Controllers;

use App\Models\ResearchCentersModel;
use CodeIgniter\RESTful\ResourceController;

class ResearchCentersController extends ResourceController
{
    protected $modelName = 'App\Models\ResearchCentersModel';
    protected $format    = 'json';

    // Get all research centers
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond(['status' => 'success', 'data' => $data], 200);
    }

    // Get a specific research center by ID
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond(['status' => 'success', 'data' => $data], 200);
        }
        return $this->failNotFound('Research center not found');
    }

    // Create a new research center
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Research center created successfully']);
        }
        return $this->failValidationErrors('Failed to create research center');
    }

    // Update a research center
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'message' => 'Research center updated successfully'], 200);
        }
        return $this->fail('Failed to update research center');
    }

    // Delete a research center
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'message' => 'Research center deleted successfully']);
        }
        return $this->fail('Failed to delete research center');
    }
}
