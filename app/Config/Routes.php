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
$routes->get('/directory/table', to: 'DirectoryController::table');
$routes->get('directory/home/export', 'DirectoryController::exportAllToExcel');


$routes->get('/directory/regional_offices', 'RegionalOfficeController::regionalOffices');
$routes->get('/directory/regional_offices/create', 'RegionalOfficeController::regionalOfficesCreate');
$routes->post('/directory/regional_offices/store', 'RegionalOfficeController::regionalOfficesStore');
$routes->get('/directory/regional_offices/edit/(:num)', 'RegionalOfficeController::regionalOfficesEdit/$1');
$routes->post('/directory/regional_offices/update/(:num)', 'RegionalOfficeController::regionalOfficesUpdate/$1');
$routes->get('/directory/regional_offices/delete/(:num)', 'RegionalOfficeController::regionalOfficesDelete/$1');
$routes->get('/directory/regional_offices/view/(:num)', 'RegionalOfficeController::regionalOfficesView/$1');
$routes->post('/directory/regional_offices/save_contact', 'RegionalOfficeController::save_contact');
$routes->get('directory/regional_offices/export', 'RegionalOfficeController::export');



$routes->get('/directory/nga', 'NgaController::nga');
$routes->get('/directory/nga/create', 'NgaController::ngaCreate');
$routes->post('/directory/nga/store', 'NgaController::ngaStore');
$routes->get('/directory/nga/edit/(:num)', 'NgaController::ngaEdit/$1');
$routes->post('/directory/nga/update/(:num)', 'NgaController::ngaUpdate/$1');
$routes->get('/directory/nga/delete/(:num)', 'NgaController::ngaDelete/$1');
$routes->get('/directory/nga/view/(:num)', 'NgaController::view/$1');
$routes->get('/directory/nga/export', 'NgaController::exportCSV');


$routes->get('/directory/academes', 'AcademeController::academes');
$routes->get('/directory/academes/create', 'AcademeController::create');
$routes->post('/directory/academes/store', 'AcademeController::store');
$routes->get('/directory/academes/edit/(:num)', 'AcademeController::edit/$1');
$routes->post('/directory/academes/update/(:num)', 'AcademeController::update/$1');
$routes->get('/directory/academes/delete/(:num)', 'AcademeController::delete/$1');
$routes->get('directory/academes/view/(:num)', 'AcademeController::view/$1');
$routes->get('/directory/academes/export', 'AcademeController::export');


$routes->get('/directory/lgus', 'LguController::lgu');
$routes->get('/directory/lgus/create', 'LguController::create');
$routes->post('/directory/lgus/store', 'LguController::lguStore');
$routes->get('/directory/lgus/edit/(:num)', 'LguController::edit/$1');
$routes->post('/directory/lgus/update/(:num)', 'LguController::update/$1');
$routes->get('/directory/lgus/delete/(:num)', 'LguController::delete/$1');
$routes->get('directory/lgus/export', 'LguController::export');
$routes->get('/directory/lgus/view/(:num)', 'LguController::view/$1');

$routes->get('/directory/business_sector', 'NgoController::businessSector');
$routes->post('/directory/business_sector/store', 'NgoController::store');
$routes->get('/directory/business_sector/edit/(:num)', 'NgoController::edit/$1');
$routes->post('/directory/business_sector/update/(:num)', 'NgoController::update/$1');
$routes->get('/directory/business_sector/delete/(:num)', 'NgoController::delete/$1');
$routes->get('/directory/business_sector/export', 'NgoController::export');
$routes->get('/directory/business_sector/view/(:num)', 'NgoController::view/$1');


$routes->get('/directory/wide_contacts', 'WideContactController::wideContacts');
$routes->post('/directory/wide_contacts/store', 'WideContactController::store');
$routes->get('/directory/wide_contacts/edit/(:num)', 'WideContactController::edit/$1');
$routes->post('/directory/wide_contacts/update/(:num)', 'WideContactController::update/$1');
$routes->get('/directory/wide_contacts/delete/(:num)', 'WideContactController::delete/$1');
$routes->get('/directory/wide_contacts/export', 'WideContactController::export');
$routes->get('/directory/wide_contacts/view/(:num)', 'WideContactController::view/$1');

// INSTITUTION //
$routes->get('/institution/home', 'InstitutionController::index');
$routes->post('/institution/home/store', 'InstitutionController::store');

$routes->get('/institution/balik_scientist', 'BalikScientistController::balik_scientist');
$routes->get('/institution/consortium', 'ConsortiumController::consortium');
$routes->get('/institution/ncrp_members', 'NcrpController::ncrp_members');
$routes->get('/institution/projects', 'ProjectsController::projects');
$routes->get('/institution/research_centers', 'ResearchCentersController::research_centers');
