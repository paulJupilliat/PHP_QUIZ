-- Active: 1675330865528@@127.0.0.1@3306@PAULDB
drop table if exists REPONSE;
drop table if exists THEME;
drop table if exists QUESTION;



CREATE TABLE THEME(
    theme VARCHAR (255),
    PRIMARY KEY (theme)
);

CREATE TABLE QUESTION(
    interogation VARCHAR(255) ,
    reponse VARCHAR(255) ,
    theme VARCHAR(255) ,
    PRIMARY KEY (interogation),
    FOREIGN KEY (theme) REFERENCES THEME (theme)
);


INSERT INTO THEME (theme) VALUES ('Histoire');
INSERT INTO THEME (theme) VALUES ('Science');
INSERT INTO THEME (theme) VALUES ('Géographie');

INSERT INTO QUESTION (interogation, reponse, theme) VALUES ("Christophe Colomb a-t-il découvert l'Amérique?", 'Oui', 'Histoire');
INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Est-ce que Napoléon Bonaparte a été empereur de France?', 'Oui', 'Histoire');

INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Quelle est la capitale de la Belgique?', 'Bruxelles', 'Géographie');
INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Quelle est la capitale de la France?', 'Paris', 'Géographie');
INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Quel est le plus grand pays du monde en termes de superficie?', 'Russie', 'Géographie');




INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('La Terre est-elle plate?', 'Non', 'Science');
INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Est-ce que la lune est un satellite naturel de la Terre?', 'Oui', 'Science');
INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Est-ce que la gravité est une force universelle?', 'Oui', 'Science');
INSERT INTO QUESTION (interogation, reponse, theme) VALUES ('Est-ce que Louis Pasteur est connu pour ses travaux sur la fermentation?', 'Oui', 'Science');

