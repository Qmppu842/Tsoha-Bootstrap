<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
//    HelloWorldController::sandbox();
    View::make('helloworld.html');
});


$routes->get('/register', function() {
    View::make('registerpage.html');
});

$routes->get('/login', function() {
    View::make('login.html');
});
$routes->get('/personalinfo', function() {
    View::make('personalinfo.html');
});