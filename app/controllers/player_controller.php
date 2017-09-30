<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of player_controller
 *
 * @author olindqvi
 */
class player_controller extends BaseController {

    public static function personalInfo() {
        View::make('personalinfo.html');
    }

    public static function userInfo($player_id) {
        $holeUser = array();
        $player = player::find($player_id);
        $playerStats = playerstats::find($player_id);
//        $nemesis = player::find($playerStats['nemesis']);
//        $holeUser[] = $player[0];
//        $holeUser[] = $player[1];
//        for ($index = 1; $index < count($playerStats); $index++) {
//            $holeUser[] = $playerStats[$index];
//        }


        Kint::dump($player);
        Kint::dump($playerStats);
//        Kint::dump($holeUser);

        View::make('personalinfo.html', array('player' => $player, 'playerStats' => $playerStats));
    }

    public static function update($id) {
        $params = $_POST;

        $atributes = array('id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password']);

        $player = new player($attributes);
        $errors = $player->errors();
//        TODO: proper error handling...
        if (FALSE) {
            
        } else {
            $player->
        }
    }

    public static function delete($id) {
        
    }

}
