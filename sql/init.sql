-- Create data base

CREATE DATABASE
    IF NOT EXISTS quizz DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE quizz;

-- Create users

CREATE USER 'app'@'%' IDENTIFIED BY 'pwdapp';
GRANT SELECT, INSERT, UPDATE, DELETE ON quizz.* TO 'app'@'%';

GRANT
SELECT,
INSERT,
UPDATE,
DELETE
    ON quizz.* TO 'appadmin' @'%';

FLUSH PRIVILEGES;
-- Create tables

CREATE TABLE
    ref_CATEGORIE(
        nom VARCHAR(42) PRIMARY KEY,
        description VARCHAR(255)
    );

CREATE TABLE
    ref_TYPE(
        type VARCHAR(42) PRIMARY KEY,
        description VARCHAR(255)
    );

CREATE TABLE
    QUESTIONS(
        id INT PRIMARY KEY auto_increment,
        question VARCHAR(255),
        reponse VARCHAR(255),
        categorie VARCHAR(42),
        propositions VARCHAR(255) NULL,
        type VARCHAR(42),
        FOREIGN KEY (categorie) REFERENCES ref_CATEGORIE(nom),
        FOREIGN KEY (type) REFERENCES ref_TYPE(type)
    );

-- Insert data

INSERT INTO ref_TYPE
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

INSERT INTO ref_CATEGORIE
VALUES ('Histoire', 'Histoire'), ('Geographie', 'Geographie'), ('Sport', 'Sport'), ('Culture', 'Culture'), ('Science', 'Science'), (
        'Informatique',
        'Informatique'
    ), ('Musique', 'Musique'), ('Cinema', 'Cinema'), ('Litterature', 'Litterature'), ('Animaux', 'Animaux'), ('Art', 'Art'), ('Voyage', 'Voyage'), ('Nature', 'Nature'), ('Sante', 'Sante'), ('Technologie', 'Technologie'), ('Politique', 'Politique'), ('Religion', 'Religion'), ('Economie', 'Economie'), ('Societe', 'Societe'), ('Divers', 'Divers');

INSERT INTO
    QUESTIONS (
        question,
        reponse,
        categorie,
        propositions,
        type
    )
VALUES (
        'Quelle est la capitale de la France?',
        'Paris',
        'Geographie',
        'Lyon,Marseille,Bordeaux',
        'QCM'
    ), (
        'Quel est le plus haut sommet de la France?',
        'Mont Blanc',
        'Geographie',
        'Pyrenees,Alpes,Massif central',
        'QCM'
    ), (
        'Quelle est la date de naissance de Napoléon Bonaparte?',
        '15 août 1769',
        'Histoire',
        NULL,
        'QCT'
    ), (
        'Quel est le nom de la devise de l\'Union européenne?',
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
        'Quel est le nom du premier président de la Côte d\'Ivoire?',
        'Félix Houphouët-Boigny',
        'Histoire',
        NULL,
        'QCT'
    ), (
        'Quel est le plus grand pays d\'Afrique?',
        'Algérie',
        'Geographie',
        'Nigeria,Egypte,Afrique du Sud',
        'QCM'
    ), (
        'Quel est le nom du célèbre peintre espagnol?',
        'Pablo Picasso',
        'Art',
        NULL,
        'QCT'
    ), (
        'Quel est le nom du plus grand océan?',
        'Océan Pacifique',
        'Geographie',
        'Océan Atlantique,Océan Indien,Océan Arctique',
        'QCM'
    ), (
        'Quelle est la plus grande religion du monde?',
        'Islam',
        'Religion',
        'Christianisme,Hindouisme,Bouddhisme',
        'QCM'
    ), (
        'Sur une échelle de 1 à 10, combien de fois par semaine mangez-vous de la viande?',
        '5',
        'Sante',
        NULL,
        'QCS'
    ), (
        'Sur une échelle de 1 à 10, quelle est votre satisfaction avec votre vie actuelle?',
        '7',
        'Societe',
        NULL,
        'QCS'
    ), (
        'Sur une échelle de 1 à 10, combien aimez-vous les films d\'horreur?',
        '3',
        'Cinema',
        NULL,
        'QCS'
    );