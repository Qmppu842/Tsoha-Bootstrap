<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
//        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        echo 'Hello World!';
    }

    public static function register() {
        View::make('registerpage.html');
    }
    
    public static function login() {
        View::make('login.html');
    }
    
       public static function ladder() {
        View::make('ladder.html');
    }
    
       public static function joinGame() {
        View::make('joinGame.html');
    }
       public static function gameLog() {
        View::make('gamelog.html');
    }

}
