-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Player(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL,
    password varchar(50) NOT NULL,
    email varchar(200)
);

CREATE TABLE Game(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL DEFAULT ('game'),
    max_players int NOT NULL DEFAULT 3,
    is_over_yet boolean NOT NULL DEFAULT false
);

CREATE TABLE Playerstats(
    player_id int REFERENCES Player(id) NOT NULL,
    won int DEFAULT 0, 
    lost int DEFAULT 0,
    tie int DEFAULT 0,
    best_streak int DEFAULT 0,
    avg_streak REAL DEFAULT 0.0,
    curr_streak int DEFAULT 0,
    nemesis int REFERENCES player(id) NULL,
    fav_card int DEFAULT -1,
    elo int DEFAULT 500
);

CREATE TABLE Playergame(
    player_id int REFERENCES Player(id),
    game_id int REFERENCES Game(id),
    picked int NOT NULL
);