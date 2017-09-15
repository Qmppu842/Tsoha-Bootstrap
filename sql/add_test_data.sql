-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Player taulun testidata
INSERT INTO Player (name, password, email) VALUES ('omppu','moimaailma', 'omppu@omppuserver.com');
INSERT INTO Player (name, password) VALUES ('omppu1','m1');
INSERT INTO Player (name, password) VALUES ('omppu2','m2');
INSERT INTO Player (name, password) VALUES ('omppu3','m3');

-- Game taulun testidata
INSERT INTO Game (name) VALUES ('Testgame0');
INSERT INTO Game (name) VALUES ('Testgame2');



-- INSERT INTO Playerstats (name) VALUES ('Testgame0');
-- INSERT INTO Playerstats (name) VALUES ('Testgame2');
-- INSERT INTO Playergame (name, picked) VALUES ('Testgame0', 1);
-- INSERT INTO Playergame (name, picked) VALUES ('Testgame2', 1);

-- INSERT INTO Playergame (player_id, game_id, picked) VALUES ();

-- CREATE TABLE Playergame(
--     id SERIAL PRIMARY KEY,
-- --     name varchar(50) NOT NULL,
--     player_id int REFERENCES Player(id),
--     game_id int REFERENCES Game(id),
--     picked int NOT NULL
-- );