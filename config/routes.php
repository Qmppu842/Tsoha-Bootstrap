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
$routes->get('/ladder', function() {
    View::make('ladder.html');
});

$routes->get('/joingame', function() {
    View::make('joinGame.html');
});
$routes->get('/gamelog', function() {
    View::make('gamelog.html');
});
$routes->get('/detailedGameInfo', function() {
    View::make('detailedGameInformation.html');
});
