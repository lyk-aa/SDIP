<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProjectsController extends BaseController
{
    // Display the list of research projects
    public function projects()
    {
        $data['child_page'] = 'Research Projects';
        // Connect to the database
        $db = \Config\Database::connect();
        $builder = $db->table('research_projects');

        // Select relevant columns from research_projects table
        $builder->select('
            research_projects.id, 
            research_projects.name, 
            research_projects.description, 
            research_projects.status,
            research_projects.sector,
            research_projects.project_objectives,
            research_projects.duration,
            research_projects.project_leader,
            research_projects.approved_amount
        ');

        // Join with institutions table to fetch only active institutions
        $builder->join('institutions i', 'i.id = research_projects.institution_id', 'inner');
        $builder->where('i.status', 'active');

        // Get all research projects matching the criteria
        $data['research_projects'] = $builder->get()->getResultArray();

        // Return the view with research projects data
        return view('institution/projects/index', $data);
    }

    // Show the form to create a new research project
    public function create()
    {
        // Connect to the database
        $db = \Config\Database::connect();

        // Fetch all active institutions for the dropdown
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        // Return the view with institutions data for the dropdown
        return view('institution/projects/create', ['institutions' => $institutions]);
    }

    // Store a new research project in the database
    public function storeProjects()
    {
        // Connect to the database
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Prepare the research project data
        $researchData = [
            'institution_id' => $this->request->getPost('institution'),
            'name' => $this->request->getPost('name'),
            'status' => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'sector' => $this->request->getPost('sector'),
            'project_objectives' => $this->request->getPost('project_objectives'),
            'duration' => $this->request->getPost('duration'),
            'project_leader' => $this->request->getPost('project_leader'),
            'approved_amount' => $this->request->getPost('approved_amount'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        // Insert the new research project into the database
        $db->table('research_projects')->insert($researchData);

        // Redirect with success message
        return redirect()->to('/institution/projects/index')->with('project-success', 'Project added successfully!');
    }

    // Show the form to edit an existing research project
    public function edit($id)
    {
        // Connect to the database
        $db = \Config\Database::connect();

        // Fetch the project details along with its associated institution and stakeholder
        $project = $db->table('research_projects as p')
            ->select('p.id as project_id, p.name as research_name, p.status, p.description, p.sector, p.duration, p.project_leader, p.project_objectives, p.approved_amount,
                      i.id as institution_id, s.name as institution_name')
            ->join('institutions as i', 'i.id = p.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('p.id', $id)
            ->get()
            ->getRowArray();

        // Check if the project exists, if not, redirect with an error message
        if (!$project) {
            return redirect()->to('/institution/projects')->with('project-error', 'Project not found.');
        }

        // Fetch all active institutions for the dropdown
        $institutions = $db->table('institutions i')->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        // Return the view to edit the project with the project and institutions data
        return view('institution/projects/edit', ['project' => $project, 'institutions' => $institutions]);
    }

    // Update an existing research project in the database
    public function update($id)
    {
        // Connect to the database
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Fetch the existing project details to check if it exists
        $existingScientist = $db->table('research_projects')->where('id', $id)->get()->getRowArray();
        if (!$existingScientist) {
            return redirect()->to('/institution/projects')->with('project-error', 'Project not found.');
        }

        // Prepare the updated project data
        $data = [
            'institution_id' => $this->request->getPost('institution'),
            'name' => $this->request->getPost('research_name'),
            'status' => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'sector' => $this->request->getPost('sector'),
            'duration' => $this->request->getPost('duration'),
            'project_leader' => $this->request->getPost('project_leader'),
            'project_objectives' => $this->request->getPost('project_objectives'),
            'approved_amount' => $this->request->getPost('approved_amount'),
            'updated_at' => $timestamp
        ];

        // Update the project in the database
        $db->table('research_projects')->where('id', $id)->update($data);

        // Redirect with success message
        return redirect()->to('/institution/projects/index')->with('project-success', 'Project updated successfully.');
    }

    // Delete a research project from the database
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('research_projects');
        $builder->where('id', $id);
        $builder->delete();

        return redirect()->to('/institution/projects/index')->with('project-success', 'Project deleted successfully!');
    }

    // View the details of a specific research project
    public function view($id)
    {
        // Connect to the database
        $db = \Config\Database::connect();

        // Fetch the project details along with its associated stakeholder
        $project = $db->table('research_projects as p')
            ->select('p.id as project_id, p.name as research_name, p.status, p.description, p.sector, p.duration, p.project_leader, p.project_objectives, p.approved_amount,
                      s.id as stakeholder_id, s.name as stakeholder_name')
            ->join('institutions as i', 'i.id = p.institution_id', 'left')
            ->join('stakeholders as s', 's.id = i.stakeholder_id', 'left')
            ->where('p.id', $id)
            ->get()
            ->getRowArray();

        // If the project does not exist, redirect with an error message
        if (!$project) {
            return redirect()->to('/institution/projects')->with('project-error', 'Project not found.');
        }

        // Return the view with project details
        return view('institution/projects/details', ['project' => $project]);
    }

    // Search for research projects based on search term and status filter
    public function search()
    {
        // Retrieve the search term and status filter from the request
        $searchTerm = $this->request->getVar('search_query');
        $statusFilter = $this->request->getVar('status');

        // Log the search term
        log_message('debug', 'Search Query: ' . $searchTerm);

        // Connect to the database
        $db = \Config\Database::connect();
        $builder = $db->table('research_projects p');

        // Select the necessary columns
        $builder->select('
            p.id, 
            p.name as project_name, 
            p.description, 
            p.status,
            p.sector,
            p.project_leader,
            p.approved_amount
        ');

        // Join with institutions table to filter only active institutions
        $builder->join('institutions i', 'i.id = p.institution_id', 'inner');
        $builder->where('i.status', 'active');

        // Apply search filters
        if ($searchTerm) {
            // Filter by project name or description
            $builder->like('p.name', $searchTerm);
            $builder->orLike('p.description', $searchTerm);
        }

        if ($statusFilter) {
            // Filter by project status
            $builder->where('p.status', $statusFilter);
        }

        // Fetch the results
        $projects = $builder->get()->getResult();

        // Log the number of projects found
        log_message('debug', 'Projects Found: ' . count($projects));

        // Process and format the results for the frontend
        $formattedProjects = [];
        foreach ($projects as $project) {
            $status = strtolower(trim($project->status));
            $statusClass = '';
            $statusIcon = '';

            // Determine the status class and icon for each project
            switch ($status) {
                case 'completed':
                    $statusClass = 'completed';
                    $statusIcon = '<i class="fas fa-check-circle"></i>';
                    break;
                case 'pending':
                    $statusClass = 'pending';
                    $statusIcon = '<i class="fas fa-clock"></i>';
                    break;
                case 'ongoing':
                    $statusClass = 'ongoing';
                    $statusIcon = '<i class="fas fa-spinner"></i>';
                    break;
            }

            // Add the project to the formatted projects array
            $formattedProjects[] = [
                'id' => $project->id,
                'name' => esc($project->project_name),
                'description' => esc($project->description),
                'status' => strtoupper($project->status),
                'statusClass' => $statusClass,
                'statusIcon' => $statusIcon,
            ];
        }

        // Return the formatted results as JSON
        return $this->response->setJSON([
            'projects' => $formattedProjects
        ]);
    }

    // Print Projects
    public function printProjects()
    {
        return view('institution/projects/print_projects');
    }
}
