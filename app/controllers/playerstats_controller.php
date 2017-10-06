<?php

/**
 * Description of playerstats_controller
 *
 * @author olindqvi
 */
class playerstats_controller {

    public static function ladder() {
//        echo 'MOIOIOI';
        View::make('ladder.html');
    }

    public static function personalLadder($id) {
//        echo 'moii';
//        die();
        $player = player::find($id);
        $stats = playerstats::find($id);
        
        Kint::dump($player);
        Kint::dump($stats);
        View::make('ladder.html', array('player' => $player, 'stats' => $stats));
    }

}
