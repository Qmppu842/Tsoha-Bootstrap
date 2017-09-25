<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});
$routes->get('/ladder', function() {
    HelloWorldController::ladder();
});
//Player Controlleri
$routes->get('/personalinfo', function() {
    player_controller::personalInfo();
});
$routes->get('/personalinfo/:id', function($player_id) {
    player_controller::userInfo($player_id);
});

//Game Controlleri osa
$routes->get('/joingame', function() {
    game_controller::joinGame();
});
$routes->get('/gamelog', function() {
    game_controller::GameLog();
});
$routes->get('/detailedGameInfo/:id', function($game_id) {
    game_controller::detailedGameInfo($game_id);
});
$routes->get('/detailedGameInfo', function() {
    game_controller::detailedGameInfo();
});
//$routes->get('/detailedGameInfo', function() {
//    HelloWorldController::detailedGameInfo();
//});
