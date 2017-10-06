<?php

  class BaseController{

    public static function get_user_logged_in(){
      // Toteuta kirjautuneen käyttäjän haku tähän
    if (isset($_SESSION['user'])) {
          $user_id = $_SESSION['user'];
          Kint::dump($user_id);
//          die();
          $player = player::find($user_id);
          
          return $player;
      }
        return null;
        
        
}

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

        
        if(!isset($_SESSION['user'])){
            Redirect::to('/login', array('message' => 'Kirjaudu ensin! Tai sitten älä mikä minä olen kertomaan mitä sinun pitää tehdä.'));
            
        }
        
        return null;
        
    }

  }
