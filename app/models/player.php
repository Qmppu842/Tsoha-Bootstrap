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
        
        Kint::dump($row);
//        die();
        
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Player (name, email, password) VALUES (:name, :email, :password) RETURNING id;');
        $query->execute(array('name' => $this->name, 'email' => $this->email, 'password' => $this->password));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Player SET name, email, password WHERE id = :id ');
        $query->execute(array('name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

    public function destroy($id) {
        $query = DB::connection()->prepare('DELETE player WHERE id = :id ');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

    public static function authenticate($params) {
        $query = DB::connection()->prepare('SELECT * Player WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            return new player(array('id' => $query['id'], 'name' => $query['name'],
                'email' => $query['email'], 'password' => $query['password']));
        } else {
            return null;
        }
    }

}
