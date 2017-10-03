<?php

/**
 * Description of game 
 *
 * @author olindqvi
 */
class Game extends BaseModel {

    public $id, $name, $max_players, $is_over_yet;

    public function __construct($attributes) {
        parent::__construct($attributes);
        settype($this->is_over_yet, 'boolean');
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Game WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $game = new Game(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'max_players' => $row['max_players'],
                'is_over_yet' => $row['is_over_yet']
            ));
        }
        return $game;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Game');
        $query->execute();

        $rows = $query->fetchAll();
        $games = array();

        foreach ($rows as $row) {
            $games[] = new Game(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'max_players' => ['max_players'],
                'is_over_yet' => ['is_over_yet']
            ));
        }
        Kint::dump($games);
        return $games;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Game (name, max_players, is_it_over_yet) VALUES (:name, :max_players, :is_is_over_yet) RETURNING id;');
        $query->execute(array('name' => $this->name, 'max_players' => $this->max_players, 'is_is_over_yet' => $this->is_over_yet));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Game SET name, is_over_yet WHERE id = :id ');
        $query->execute(array('name' => $this->name, 'is_over_yet' => $this->is_over_yet, 'id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }
         public function destroy($id) {
        $query = DB::connection()->prepare('DELETE Game WHERE id = :id ');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }



}
