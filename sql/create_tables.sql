-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Player(
    id SERIAL PRIMARY KEY,
name varchar(50) NOT NULL,
password varchar(50) NOT NULL,
-- email varchar(200)
);

CREATE TABLE Game(
id SERIAL PRIMARY KEY,
name varchar(50) NOT NULL DEFAULT ('game'),
max_players INT DEFAULT 3,
created DATE
);

CREATE TABLE Userstats(
player_id PRIMARY KEY REFERENCES player(id),
won INT,
lost INT,
tie INT,
best_streak INT,
avg_streak DOUBLE,
curr_streak INT,
nemesis REFERENCES player(id),
fav_card INT
);

CREATE TABLE Playergame(
player_id REFERENCES player(id),
game_id REFERENCES game(id),
picked INT NOT NULL 
);
