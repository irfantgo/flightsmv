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

// System Components
Heliumframework\Router::get('/', 'LoginController@index');
Heliumframework\Router::get('/login', 'LoginController@index');
Heliumframework\Router::get('/login/notifications', 'LoginController@notifications');
Heliumframework\Router::get('/logout', 'LoginController@logout');
Heliumframework\Router::post('/login/process', 'LoginController@process');
Heliumframework\Router::get('/checksession', 'LoginController@checksession');


// Notifications
Heliumframework\Router::get('/notifications', 'NotificationsController@index');

// Dashboard
Heliumframework\Router::get('/dashboard', 'DashboardController@index');

// Flight
Heliumframework\Router::get('/flights', 'FlightsController@index');
Heliumframework\Router::get('/flights/allflights', 'FlightsController@flightinfo');

// Telegram Controller
Heliumframework\Router::get('/telegram/webhook', 'TelegramController@index');

// Users
Heliumframework\Router::get('/users', 'UsersController@index');
Heliumframework\Router::get('/users/new', 'UsersController@create');
Heliumframework\Router::get('/users/store', 'UsersController@store');
Heliumframework\Router::get('/users/edit', 'UsersController@update');
Heliumframework\Router::get('/users/patch', 'UsersController@patch');

// Logs
Heliumframework\Router::get('/logs', 'LogsController@index');

// Groups
Heliumframework\Router::get('/groups', 'GroupsController@index');
Heliumframework\Router::get('/groups/new', 'GroupsController@create');
Heliumframework\Router::get('/groups/store', 'GroupsController@store');
Heliumframework\Router::get('/groups/edit', 'GroupsController@update');
Heliumframework\Router::get('/groups/patch', 'GroupsController@patch');

// Roles
Heliumframework\Router::get('/roles', 'RolesController@index');
Heliumframework\Router::get('/roles/new', 'RolesController@create');
Heliumframework\Router::get('/roles/create', 'RolesController@store');
Heliumframework\Router::get('/roles/edit', 'RolesController@update');
Heliumframework\Router::get('/roles/update', 'RolesController@patch');
Heliumframework\Router::get('/roles/remove', 'RolesController@destroy');

// Settings
Heliumframework\Router::get('/settings', 'SettingsController@index');
Heliumframework\Router::get('/settings/update', 'SettingsController@update');


// Applications
Heliumframework\Router::get('/applications', 'ApplicationsController@index');
Heliumframework\Router::get('/applications/help', 'ApplicationsController@help');
Heliumframework\Router::get('/applications/new', 'ApplicationsController@create');
Heliumframework\Router::get('/applications/create', 'ApplicationsController@store');
Heliumframework\Router::get('/applications/revoke/{}', 'ApplicationsController@destroy');


// Telegram Bot Stuff
Heliumframework\Router::post('/ourbot', 'TelegramBotController@index');
