<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trueGameObject
 *
 * @author olindqvi
 */
class trueGameObject {

    private $id, $name, $max_players, $is_over_yet, $players;

    public function __construct($attributes) {
        parent::__construct($attributes);
        init();
    }

//    $id, $name, $max_players, $is_over_yet
//    $this->id = $id;
//        $this->name = $name;
//        $this->max_players = $max_players;
//        $this->is_over_yet = $is_over_yet;

    private function init() {
        settype($this->id, "int");
        settype($this->name, "string");
        settype($this->max_players, "int");
        settype($this->is_over_yet, "boolean");
        settype($this->players, "array");
    }

    private function addPlayerToGame($player_id, $picked) {
        if (count($this->players) < 3) {
            $this->players[] = player::find($player_id);
        } else {
            trigger_error("Peli on jo täynnä");
        }
    }

    public function getGameResultsInArrayForm($game_id) {
        
    }

    private function returnGameResultAsNumber($player0pick, $player1pick, $player2pick) {

        if ($player0pick == $player1pick && $player1pick == $player2pick) {
            return 1;
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }

//    private function findPlayerForTheGame($player_id) {
//        return player::find($player_id);
//    }
}
