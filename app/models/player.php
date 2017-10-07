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
        $query = DB::connection()->prepare('UPDATE Player SET name =  :name, email = :email, password = :password WHERE id = :id ');
        $query->execute(array('name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

    public function destroy($id) {
        $stats = playerstats::find($id);
        $stats->destroy($id);
        $query = DB::connection()->prepare('DELETE FROM player WHERE id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

            
        
        Kint::dump($row);
    }
    /**
     * 
     * @param type $namee
     * @param type $passwordd
     * @return Found player or Null
     */
    public static function authenticate($namee, $passwordd) {
        $query = DB::connection()->prepare('SELECT * FROM Player WHERE LOWER(name) = LOWER(:name) AND password = :password LIMIT 1');
        $query->execute(array('name' => $namee, 'password' => $passwordd));
        $row = $query->fetch();
        
        Kint::dump($row);
        Kint::dump($namee);
        Kint::dump($passwordd);
        
        if ($row) {
            return new player(array('id' => $row['id'], 'name' => $row['name'],
                'email' => $row['email'], 'password' => $row['password']));
        } else {
            return null;
        }
    }
    
    
    /**
     * If one true god is missing use this method to add ONETRUEBOTGOD to database.
     * 
     * @return player-object
     */
    public static function missingOneTrueGod() {
        $TRUEBOTGOD = new player(array(
                'id' => 165,
                'name' => 'ONETRUEBOTGOD',
                'password' => '10d64815c8ea017046a5724d7b8953c7'));
        //TODO: hae serverien välityksellä yllä oleva kenttä jotta ONETRUEBOTGOD voi säilyä puhtaana.
        $TRUEBOTGOD->save();
        return $TRUEBOTGOD; 
    }

}
