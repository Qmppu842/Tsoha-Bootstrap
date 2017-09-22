<?php

/**
 * Description of player
 *
 * @author olindqvi
 */
class player extends BaseModel {

    public $id, $name, $email, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Player WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $player = new player(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password']
            ));
        }
        return $player;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Player');
        $query->execute();

        $rows = $query->fetchAll();
        $players = array();

        foreach ($rows as $row) {
            $players[] = new player(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password']
            ));
        }
        return $players;
    }

}
