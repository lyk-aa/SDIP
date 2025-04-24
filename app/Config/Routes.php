<?php

use App\Controllers\DirectoryController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::home');

// DIRECTORY //

$routes->get('/directory/home', to: 'DirectoryController::index');

$routes->get('/directory/regional_offices', 'RegionalOfficeController::regionalOffices');
$routes->get('/directory/regional_offices/create', 'RegionalOfficeController::regionalOfficesCreate');
$routes->post('/directory/regional_offices/store', 'RegionalOfficeController::regionalOfficesStore');
$routes->get('/directory/regional_offices/edit/(:num)', 'RegionalOfficeController::regionalOfficesEdit/$1');
$routes->post('/directory/regional_offices/update/(:num)', 'RegionalOfficeController::regionalOfficesUpdate/$1');
$routes->post('/directory/regional_offices/delete/(:num)', 'RegionalOfficeController::deleteRegionalOffice/$1');

$routes->get('/directory/nga', 'NgaController::nga');
$routes->get('directory/nga/create', 'NgaController::ngaCreate');
$routes->post('/directory/nga/store', 'NgaController::ngaStore');

$routes->get('/directory/academes', 'AcademeController::academes');
$routes->get('/directory/academes/create', 'AcademeController::academeCreate');
$routes->post('/directory/academes/store', 'AcademeController::academesStore');

$routes->get('/directory/lgus', 'LguController::lgu');
$routes->post('/directory/lgus/store', 'LguController::lguStore');

$routes->get('/directory/sucs', 'DirectoryController::suc');
$routes->get('/directory/business_sector', 'NgoController::businessSector');
$routes->post('/directory/business_sector/store', 'NgoController::businessSectorStore');
$routes->get('/directory/wide_contacts', 'WideContactController::wideContacts');


// Institution Main //
$routes->get('/institution/home', 'InstitutionController::index');
$routes->get('/institution/home/print/print_all_institutions', 'InstitutionController::printAllInstitutions');
$routes->get('/institution/create', 'InstitutionController::create_institution');
$routes->post('/institution/store', 'InstitutionController::storeInstitution');
$routes->get('/institution/edit/(:num)', 'InstitutionController::edit/$1');
$routes->post('/institution/update/(:num)', 'InstitutionController::update/$1');
$routes->get('/institution/delete/(:num)', 'InstitutionController::delete/$1');
$routes->get('institution/view/(:num)', 'InstitutionController::view/$1');
$routes->get('institution/view/print/(:num)', 'InstitutionController::printDetails/$1');
$routes->get('institution/getStakeholderDetails/(:num)', 'InstitutionController::getStakeholderDetails/$1');
$routes->get('institution/search', 'InstitutionController::search');



//Institution Projects//
$routes->get('/institution/projects/index', 'ProjectsController::projects');
$routes->get('/institution/projects', 'ProjectsController::projects');
$routes->get('/institution/projects/print', 'ProjectsController::printProjects');
$routes->get('/institution/projects/printprojects', 'ProjectsController::printProjects');

$routes->get('/institution/projects/create', 'ProjectsController::create');
$routes->post('/institution/projects/store', 'ProjectsController::storeProjects');
$routes->get('/institution/projects/edit/(:num)', 'ProjectsController::edit/$1');
$routes->post('/institution/projects/update/(:num)', 'ProjectsController::update/$1');
$routes->get('/institution/projects/delete/(:num)', 'ProjectsController::delete/$1');
$routes->get('institution/projects/view/(:num)', 'ProjectsController::view/$1');
$routes->post('institution/projects/search', 'ProjectsController::search');


//Institution Balik Scientist//
$routes->get('/institution/balik_scientist/index', 'BalikScientistController::balik_scientist');
$routes->get('/institution/balik_scientist/print', 'BalikScientistController::printBalikScientist');
$routes->get('/institution/balik_scientist/create', 'BalikScientistController::create');
$routes->post('/institution/balik_scientist/store', 'BalikScientistController::store');
$routes->get('/institution/balik_scientist/edit/(:num)', 'BalikScientistController::edit/$1');
$routes->post('/institution/balik_scientist/update/(:num)', 'BalikScientistController::update/$1');
$routes->get('/institution/balik_scientist/delete/(:num)', 'BalikScientistController::delete/$1');
$routes->get('institution/balik_scientist/view/(:num)', 'BalikScientistController::view/$1');
$routes->post('institution/balik_scientist/search', 'BalikScientistController::search');


//Instutions NRCP
$routes->get('/institution/nrcp_members/index', 'NrcpController::nrcp_members');
$routes->get('/institution/nrcp_members/print', 'NrcpController::printNrcp');
$routes->get('/institution/nrcp_members/create', 'NrcpController::create');
$routes->post('/institution/nrcp_members/store', 'NrcpController::store');
$routes->get('/institution/nrcp_members/edit/(:num)', 'NrcpController::edit/$1');
$routes->post('/institution/nrcp_members/update/(:num)', 'NrcpController::update/$1');
$routes->get('/institution/nrcp_members/delete/(:num)', 'NrcpController::delete/$1');
$routes->get('institution/nrcp_members/view/(:num)', 'NrcpController::view/$1');
$routes->post('institution/nrcp_members/search', 'NrcpController::search');

//Institutions Consorsium
$routes->get('/institution/consortium/index', 'ConsortiumController::consortium');
$routes->get('/institution/consortium/print', 'ConsortiumController::printConsortium');
$routes->get('/institution/consortium/create', 'ConsortiumController::create');
$routes->post('/institution/consortium/store', 'ConsortiumController::store');
$routes->get('/institution/consortium/edit/(:num)', 'ConsortiumController::edit/$1');
$routes->post('/institution/consortium/update/(:num)', 'ConsortiumController::update/$1');
$routes->get('/institution/consortium/delete/(:num)', 'ConsortiumController::delete/$1');
$routes->get('institution/consortium/search', 'ConsortiumController::search');


//Institutions Research Centers
$routes->get('institution/research_centers/index', 'ResearchCentersController::index');
$routes->get('/institution/research_centers/create', 'ResearchCentersController::create');
$routes->post('/institution/research_centers/store', 'ResearchCentersController::store');
$routes->get('/institution/research_centers/edit/(:num)', 'ResearchCentersController::edit/$1');
$routes->post('/institution/research_centers/update/(:num)', 'ResearchCentersController::update/$1');
$routes->get('/institution/research_centers/delete/(:num)', 'ResearchCentersController::delete/$1');
$routes->get('/institution/research_centers/view/(:num)', 'ResearchCentersController::view/$1');
$routes->post('/institution/research_centers/search', 'ResearchCentersController::search');



$routes->get('/institution/ncrp_members', 'NcrpController::ncrp_members');
$routes->get('/institution/research_centers', 'ResearchCentersController::research_centers');
