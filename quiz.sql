DROP TABLE IF EXISTS CHOIX;
DROP TABLE IF EXISTS THEME;
DROP TABLE IF EXISTS QUESTION;

CREATE TABLE THEME (
    
    theme VARCHAR(255),
    PRIMARY KEY (theme)
);

CREATE TABLE CHOIX (
    id_choix int,
    choix_1 VARCHAR(255),
    choix_2 VARCHAR(255),
    choix_3 VARCHAR(255),
    PRIMARY KEY (id_choix)
);

CREATE TABLE QUESTION (
    id_choix INT,
    id_question INT,
    interogation VARCHAR(255),
    reponse VARCHAR(255),
    theme VARCHAR(255),
    PRIMARY KEY (id_question),
    FOREIGN KEY (id_choix) REFERENCES CHOIX (id_choix),
    FOREIGN KEY (theme) REFERENCES THEME (theme)
    
);

INSERT INTO THEME (theme) VALUES ('Histoire');

INSERT INTO CHOIX (id_choix, choix_1, choix_2, choix_3) VALUES (1, 'Oui', 'Non', 'Peut-être');

INSERT INTO QUESTION (id_choix, id_question, interogation, reponse, theme) VALUES (1, 1, "Christophe Colomb a-t-il découvert l'Amérique?", 'Oui', 'Histoire');
INSERT INTO QUESTION (id_choix, id_question, interogation, reponse, theme) VALUES (1, 2, 'Est-ce que Napoléon Bonaparte a été empereur de France?', 'Oui', 'Histoire');