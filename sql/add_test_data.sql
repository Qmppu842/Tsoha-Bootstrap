-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Player taulun testidata
INSERT INTO Player (name, password, email) VALUES ('omppu','moimaailma', 'omppu@omppuserver.com');
INSERT INTO Player (name, password) VALUES ('omppu1','m1');
INSERT INTO Player (name, password) VALUES ('omppu2','m2');
INSERT INTO Player (name, password) VALUES ('omppu3','m3');

-- Game taulun testidata
INSERT INTO Game (name) VALUES ('Testgame0');
INSERT INTO Game (name) VALUES ('Testgame2');
-- INSERT INTO Game;-- () VALUES ();

-- PlayerGame taulun testidata
INSERT INTO Playergame (game_id, player_id, picked) VALUES (1,1,1);
INSERT INTO Playergame (game_id, player_id, picked) VALUES (1,2,3);

-- Playerstats taulun testidata
INSERT INTO Playerstats (player_id, nemesis, won) VALUES (1, 2, 10);
INSERT INTO Playerstats (player_id, nemesis) VALUES (3, 2);
INSERT INTO Playerstats (player_id) VALUES (2);


-- INSERT INTO Playergame (game_id, player_id, picked) SELECT id FROM Game WHERE name='Testgame0' UNION SELECT id FROM Player WHERE name='omppu';

-- INSERT INTO Playerstats (name) VALUES ('Testgame0');
-- INSERT INTO Playerstats (name) VALUES ('Testgame2');
-- INSERT INTO Playergame (name, picked) VALUES ('Testgame0', 1);
-- INSERT INTO Playergame (name, picked) VALUES ('Testgame2', 1);

-- INSERT INTO Playergame (player_id, game_id, picked) VALUES ();
