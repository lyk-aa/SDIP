<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class ResearchCentersController extends BaseController
{
    // Index method to list all research centers
    public function index()
    {
        $db = Database::connect();  // Get a database connection
        $query = $db->query('SELECT * FROM rd_innovation_centers');  // Fetch all research centers
        $data['research_centers'] = $query->getResult();  // Get the results as an array of objects
        
        return view('institution/research_centers/index', $data);  // Load the view and pass data
    }

    // Create method to display the form for adding a new research center
    public function create()
    {
        return view('institution/research_centers/create');  // Load the view for creating a new research center
    }

    // Edit method to display the form for editing an existing research center
    public function edit($id)
    {
        $db = Database::connect();  // Get a database connection
        $query = $db->query('SELECT * FROM research_centers WHERE id = ?', [$id]);  // Fetch the specific research center by ID
        $data['research_center'] = $query->getRow();  // Get the result as an object
        
        return view('institution/research_centers/edit', $data);  // Load the edit view and pass the data
    }
}
