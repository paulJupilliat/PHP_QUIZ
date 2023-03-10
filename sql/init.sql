-- Active: 1678109077661@@127.0.0.1@3306@quizz
-- Create data base

CREATE DATABASE
    IF NOT EXISTS quizz DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE quizz;

-- Create users

CREATE USER 'app'@'%' IDENTIFIED BY 'pwdapp';

GRANT SELECT, INSERT, UPDATE ON quizz.* TO 'app'@'%';

CREATE USER if NOT EXISTS 'appadmin'@'%' IDENTIFIED BY 'pwdadmin';

GRANT ALL PRIVILEGES ON quizz.* TO 'appadmin'@'%';

GRANT
SELECT,
INSERT,
UPDATE,
DELETE
    ON quizz.* TO 'appadmin' @'%';

FLUSH PRIVILEGES;

-- Create tables

CREATE TABLE
    ref_THEMES(
        theme_name VARCHAR(42) PRIMARY KEY,
        description VARCHAR(255) NULL
    );

CREATE TABLE
    ref_TYPES(
        type_name VARCHAR(42) PRIMARY KEY,
        description VARCHAR(255) NULL
    );

CREATE TABLE
    QUESTIONS(
        id_question INT PRIMARY KEY auto_increment,
        interrogation VARCHAR(255),
        reponse VARCHAR(255),
        theme VARCHAR(42),
        propositions VARCHAR(255) NULL,
        type VARCHAR(42),
        FOREIGN KEY (theme) REFERENCES ref_THEMES(theme_name),
        FOREIGN KEY (type) REFERENCES ref_TYPES(type_name)
    );

CREATE TABLE
    USERS (
        pseudo VARCHAR(42) PRIMARY KEY,
        nom VARCHAR(42) NULL,
        prenom VARCHAR(42) NULL,
        mdp VARCHAR(500) NOT NULL,
        age INT DEFAULT 0
    );

CREATE TABLE
    REF_ROLES (
        role_name varchar(42) PRIMARY KEY,
        description varchar(255) NULL
    );

CREATE TABLE
    have_role (
        pseudo varchar(42),
        role_name varchar(42),
        PRIMARY KEY (pseudo, role_name),
        FOREIGN KEY (pseudo) REFERENCES USERS(pseudo),
        FOREIGN KEY (role_name) REFERENCES REF_ROLES(role_name)
    );

CREATE TABLE
    QUESTION_TENTATIVES (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question_id INT,
        proposition VARCHAR(255),
        FOREIGN KEY (question_id) REFERENCES QUESTIONS(id_question)
    );

CREATE TABLE
    do_tentative (
        id_tentative INT,
        pseudo VARCHAR(42),
        tentative_id INT,
        PRIMARY KEY (pseudo, tentative_id, id_tentative),
        FOREIGN KEY (pseudo) REFERENCES USERS(pseudo),
        FOREIGN KEY (tentative_id) REFERENCES QUESTION_TENTATIVES(id)
    );

-- Insert data

INSERT INTO ref_TYPES
VALUES (
        'QCM',
        'Question avec plusieurs choix possible'
    ), (
        'QCU',
        'Question avec un seul choix possible, et des propositions'
    ), (
        'QCT',
        'Question avec un texte libre'
    ), (
        'QCS',
        'Question a choix avec un slider'
    );

INSERT INTO USERS
VALUES (
        "user1",
        "user1 name",
        "user1 prenom",
        "$2y$10$ABaoDjNyovihIwuQieNgeuzJe1/MkTJP/oV9aKyVTfepgs1kB/X0m",
        18
    ), (
        "admin1",
        "admin1 name",
        "admin1 prenom",
        "$2y$10$ABaoDjNyovihIwuQieNgeuzJe1/MkTJP/oV9aKyVTfepgs1kB/X0m",
        18
    );

INSERT INTO ref_THEMES
VALUES ('Histoire', 'Histoire'), ('Geographie', 'Geographie'), ('Sport', 'Sport'), ('Culture', 'Culture'), ('Science', 'Science'), (
        'Informatique',
        'Informatique'
    ), ('Musique', 'Musique'), ('Cinema', 'Cinema'), ('Litterature', 'Litterature'), ('Animaux', 'Animaux'), ('Art', 'Art'), ('Voyage', 'Voyage'), ('Nature', 'Nature'), ('Sante', 'Sante'), ('Technologie', 'Technologie'), ('Politique', 'Politique'), ('Religion', 'Religion'), ('Economie', 'Economie'), ('Societe', 'Societe'), ('Divers', 'Divers');

INSERT INTO
    QUESTIONS (
        interrogation,
        reponse,
        theme,
        propositions,
        type
    )
VALUES (
        'Quelle est la capitale de la France?',
        'Paris',
        'Geographie',
        'Lyon|Marseille|Bordeaux',
        'QCM'
    ), (
        'Quel est le plus haut sommet de la France?',
        'Mont Blanc',
        'Geographie',
        'Pyrenees|Alpes|Massif central',
        'QCM'
    ), (
        'Quelle est la date de naissance de Napol??on Bonaparte?',
        '15 ao??t 1769',
        'Histoire',
        NULL,
        'QCT'
    ), (
        'Quel est le nom de la devise de l\'Union europ??enne?',
        'L\'euro',
        'Economie',
        NULL,
        'QCT'
    ), (
        'Quelle est la capitale du Burkina Faso?',
        'Ouagadougou',
        'Geographie',
        NULL,
        'QCT'
    ), (
        'Quel est le nom du premier pr??sident de la C??te d\'Ivoire?',
        'F??lix Houphou??t-Boigny',
        'Histoire',
        NULL,
        'QCT'
    ), (
        'Quel est le plus grand pays d\'Afrique?',
        'Alg??rie',
        'Geographie',
        'Nigeria|Egypte|Afrique du Sud',
        'QCM'
    ), (
        'Quel est le nom du c??l??bre peintre espagnol?',
        'Pablo Picasso',
        'Art',
        NULL,
        'QCT'
    ), (
        'Quel est le nom du plus grand oc??an?',
        'Oc??an Pacifique',
        'Geographie',
        'Oc??an Atlantique|Oc??an Indien|Oc??an Arctique',
        'QCM'
    ), (
        'Quelle est la plus grande religion du monde?',
        'Islam',
        'Religion',
        'Christianisme|Hindouisme|Bouddhisme',
        'QCM'
    ), (
        'Sur une ??chelle de 1 ?? 10, combien de fois par semaine mangez-vous de la viande?',
        '5',
        'Sante',
        NULL,
        'QCS'
    ), (
        'Sur une ??chelle de 1 ?? 10, quelle est votre satisfaction avec votre vie actuelle?',
        '7',
        'Societe',
        NULL,
        'QCS'
    ), (
        'Sur une ??chelle de 1 ?? 10, combien aimez-vous les films d\'horreur?',
        '3',
        'Cinema',
        NULL,
        'QCS'
    );

INSERT INTO REF_ROLES
VALUES ('ROLE_USER', 'Utilisateur'), (
        'ROLE_ADMIN',
        'Administrateur'
    );

INSERT INTO have_role
VALUES ('user1', 'ROLE_USER'), ('admin1', 'ROLE_ADMIN'), ('admin1', 'ROLE_USER');

-- ins??rer des donn??es dans la table USERS ?? partir d'un fichier JSON (user.json)

INSERT INTO
    QUESTIONS (
        interrogation,
        reponse,
        theme,
        propositions,
        type
    )
SELECT
    interrogation,
    reponse,
    theme,
    propositions,
    type
FROM
    OPENROWSET (BULK 'donnees.json'),
    SINGLE_CLOB as json CROSS APPLY OPENJSON(json)
WITH (
        interrogation VARCHAR(255) '$.interrogation',
        reponse VARCHAR(255) '$.reponse',
        theme VARCHAR(30) '$.theme',
        propositions VARCHAR(255) '$.propositions',
        type VARCHAR(30) '$.type'
    );