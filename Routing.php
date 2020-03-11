<?php
/**
 * A file created for routing
 * @author Ahmed Shan (@thaanu16)
 *
 * EXAMPLE
 * - /
 * - /controller/recordid
 * - /controller/method/{recordid}
 *
 */

// Website Routing
Heliumframework\Router::get('/', 'LoginController@index');

// System Components
Heliumframework\Router::get('/login', 'LoginController@index');
Heliumframework\Router::get('/login/notifications', 'LoginController@notifications');
Heliumframework\Router::get('/logout', 'LoginController@logout');
Heliumframework\Router::get('/login/process', 'LoginController@adlogin');

// Dashboard
Heliumframework\Router::get('/dashboard', 'DashboardController@index');

// Users
Heliumframework\Router::get('/users', 'UsersController@index');
Heliumframework\Router::get('/users/new', 'UsersController@create');
Heliumframework\Router::get('/users/create', 'UsersController@store');
Heliumframework\Router::get('/users/edit/{}', 'UsersController@update');
Heliumframework\Router::get('/users/update/{}', 'UsersController@patch');

// Logs
Heliumframework\Router::get('/logs', 'LogsController@index');

// Recipients
Heliumframework\Router::get('/departments', 'DepartmentsController@index');
Heliumframework\Router::get('/departments/new', 'DepartmentsController@create');
Heliumframework\Router::get('/departments/store', 'DepartmentsController@store');
Heliumframework\Router::get('/departments/edit/{}', 'DepartmentsController@update');
Heliumframework\Router::get('/departments/patch/{}', 'DepartmentsController@patch');
Heliumframework\Router::get('/departments/remove/{}', 'DepartmentsController@destroy');

// Recipients
// Heliumframework\Router::get('/recipients', 'RecipientsController@index');
// Heliumframework\Router::get('/recipients/new', 'RecipientsController@create');
// Heliumframework\Router::get('/recipients/store', 'RecipientsController@store');
// Heliumframework\Router::get('/recipients/edit/{}', 'RecipientsController@update');
// Heliumframework\Router::get('/recipients/patch/{}', 'RecipientsController@patch');
// Heliumframework\Router::get('/recipients/remove/{}', 'RecipientsController@destroy');

// Attendance, Payroll & Documents
Heliumframework\Router::get('/department', 'AttendanceController@index');
Heliumframework\Router::get('/department/payroll/{}', 'AttendanceController@payrolld');
Heliumframework\Router::get('/department/genpdf/{}', 'AttendanceController@genpdf');
Heliumframework\Router::get('/department/attendance/{}', 'AttendanceController@attendance');
Heliumframework\Router::get('/department/documents/{}', 'AttendanceController@documents');
Heliumframework\Router::get('/department/document-ack/{}', 'AttendanceController@docack');
Heliumframework\Router::get('/department/documents-view/{}', 'AttendanceController@docview');
Heliumframework\Router::get('/department/debug/{}', 'AttendanceController@debugd');


// Groups
Heliumframework\Router::get('/groups', 'GroupsController@index');
Heliumframework\Router::get('/groups/new', 'GroupsController@create');
Heliumframework\Router::get('/groups/store', 'GroupsController@store');
Heliumframework\Router::get('/groups/edit/{}', 'GroupsController@update');
Heliumframework\Router::get('/groups/patch/{}', 'GroupsController@patch');

// Roles
Heliumframework\Router::get('/roles', 'RolesController@index');
Heliumframework\Router::get('/roles/new', 'RolesController@create');
Heliumframework\Router::get('/roles/create', 'RolesController@store');
Heliumframework\Router::get('/roles/edit/{}', 'RolesController@update');
Heliumframework\Router::get('/roles/update/{}', 'RolesController@patch');
Heliumframework\Router::get('/roles/remove/{}', 'RolesController@destroy');

// Settings
Heliumframework\Router::get('/settings', 'SettingsController@index');
Heliumframework\Router::get('/settings/update', 'SettingsController@update');

// Images
Heliumframework\Router::get('/images', 'ImagesController@index');
Heliumframework\Router::get('/images/client-logo/{}/{}', 'ImagesController@client_logo');

// Applications
Heliumframework\Router::get('/applications', 'ApplicationsController@index');
Heliumframework\Router::get('/applications/help', 'ApplicationsController@help');
Heliumframework\Router::get('/applications/new', 'ApplicationsController@create');
Heliumframework\Router::get('/applications/create', 'ApplicationsController@store');
Heliumframework\Router::get('/applications/revoke/{}', 'ApplicationsController@destroy');

