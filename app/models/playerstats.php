<?php

/**
 * Description of playerstats
 *
 * @author olindqvi
 */
class playerstats extends BaseModel {

    public $player_id, $won, $lost, $tie, $best_streak, $avg_streak, $curr_streak, $nemesis, $fav_card, $elo;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Playerstats WHERE player_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $stats = new playerstats(array(
                'player_id' => $row['player_id'],
                'won' => $row['won'],
                'lost' => $row['lost'],
                'tie' => $row['tie'],
                'best_streak' => $row['best_streak'],
                'avg_streak' => $row['avg_streak'],
                'curr_streak' => $row['curr_streak'],
                'nemesis' => $row['nemesis'],
                'fav_card' => $row['fav_card'],
                'elo' => $row['elo']
            ));
        }

        if (!isset($stats)) {
            $stats = new playerstats(array('player_id' => $id));
            $stats->addDefaultStatsForNewPlayer();
            return self::find($id);
        }
        return $stats;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Playerstats');
        $query->execute();

        $rows = $query->fetchAll();
        $allStats = array();

        foreach ($rows as $row) {
            $allStats[] = new playerstats(array(
                'player_id' => $row['player_id'],
                'won' => $row['won'],
                'lost' => $row['lost'],
                'tie' => $row['tie'],
                'best_streak' => $row['best_streak'],
                'avg_streak' => $row['avg_streak'],
                'curr_streak' => $row['curr_streak'],
                'nemesis' => $row['nemesis'],
                'fav_card' => $row['fav_card'],
                'elo' => $row['elo']
            ));
        }
        return $allStats;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Playerstats (player_id, won, lost, tie, best_streak, avg_streak, curr_streak, nemesis, fav_card, elo) VALUES (:player_id, :won, :lost, :tie, :best_streak, :avg_streak, :curr_streak, :nemesis, :fav_card, :elo) RETURNING player_id;');
        $query->execute(array(
            'player_id' => $this->player_id, 'won' => $this->won,
            'lost' => $this->lost, 'tie' => $this->tie, 'best_streak' => $this->best_streak,
            'avg_streak' => $this->avg_streak, 'curr_streak' => $this->curr_streak,
            'nemesis' => $this->nemesis, 'fav_card' => $this->fav_card, 'elo' => $this->elo));
        $row = $query->fetch();
        $this->player_id = $row['player_id'];
    }

    public function addDefaultStatsForNewPlayer() {
        $query = DB::connection()->prepare('INSERT INTO Playerstats (player_id) VALUES (:player_id) RETURNING player_id;');
        $query->execute(array('player_id' => $this->player_id));
        $row = $query->fetch();
        $this->player_id = $row['player_id'];
    }

    public function getNemesis() {
        return $this->nemesis;
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Playerstats SET won, lost, tie, best_streak, avg_streak, curr_streak, nemesis, fav_card, elo WHERE player_id = :id ');
        $query->execute(array('won' => $this->won, 'lost' => $this->lost, 'tie' => $this->best_streak,
            'avg_streak' => $this->avg_streak, 'curr_streak' => $this->curr_streak,
            'nemesis' => $this->nemesis, 'fav_card' => $this->fav_card, 'elo' => $this->elo, 'id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

    public function combineThisPlayerToGivenPlayer($id) {
        $addToThisPlayer = playerstats::find($id);
        if (!isset($addToThisPlayer)) {
            $TRUEBOTGOD = player::missingOneTrueGod();
            $addToThisPlayer = playerstats::find($TRUEBOTGOD->id);
        }
        Kint::dump($id);
//        public $player_id, $won, $lost, $tie, $best_streak,
//                $avg_streak, $curr_streak, $nemesis, $fav_card, $elo;
//        $this->won += $addThisPlayer->won;
//        $this->lost += $addThisPlayer->lost;
//        $this->tie += $addThisPlayer->tie;
//        $this->avg_streak = ($this->avg_streak + $addThisPlayer->avg_streak)/2;
//        $this->best_streak = max($addThisPlayer->best_streak, $this->best_streak);
//        $this->curr_streak = max($addThisPlayer->curr_streak, $this->curr_streak);
//        $this->elo += $addThisPlayer->elo-1000; 

        $addToThisPlayer->won += $this->won;
        $addToThisPlayer->lost += $this->lost;
        $addToThisPlayer->tie += $this->tie;
        $addToThisPlayer->avg_streak = ($this->avg_streak + $addToThisPlayer->avg_streak) / 2;
        $addToThisPlayer->best_streak = max($addToThisPlayer->best_streak, $this->best_streak);
        $addToThisPlayer->curr_streak = max($addToThisPlayer->curr_streak, $this->curr_streak);
        $addToThisPlayer->elo += $this->elo - 1000;
        $addToThisPlayer->save();
    }

    public function destroy($id) {
        $this->combineThisPlayerToGivenPlayer(165);


        $query = DB::connection()->prepare('DELETE FROM playerstats WHERE player_id = :id;');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

}
