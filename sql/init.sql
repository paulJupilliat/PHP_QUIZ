-- Active: 1675864418959@@localhost@3306

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

-- Met en place l'utf8

ALTER DATABASE quizz CHARACTER SET utf8 COLLATE utf8_general_ci;

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
        premium BOOLEAN DEFAULT FALSE,
        interrogation VARCHAR(255),
        reponse VARCHAR(255),
        theme VARCHAR(42),
        propositions VARCHAR(255) DEFAULT " ",
        type VARCHAR(42),
        is_shown BOOLEAN DEFAULT true,
        FOREIGN KEY (theme) REFERENCES ref_THEMES(theme_name),
        FOREIGN KEY (type) REFERENCES ref_TYPES(type_name)
    );

CREATE TABLE
    USERS (
        pseudo VARCHAR(42) PRIMARY KEY,
        nom VARCHAR(42) NULL,
        premium BOOLEAN DEFAULT FALSE,
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
        quest_tentative_id INT,
        PRIMARY KEY (
            pseudo,
            quest_tentative_id,
            id_tentative
        ),
        FOREIGN KEY (pseudo) REFERENCES USERS(pseudo),
        FOREIGN KEY (quest_tentative_id) REFERENCES QUESTION_TENTATIVES(id)
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

INSERT INTO
    USERS (
        pseudo,
        nom,
        premium,
        prenom,
        mdp,
        age
    )
VALUES (
        "user1",
        "user1 name",
        True,
        "user1 prenom",
        "$2y$10$ABaoDjNyovihIwuQieNgeuzJe1/MkTJP/oV9aKyVTfepgs1kB/X0m",
        18
    ), (
        "admin1",
        "admin1 name",
        False,
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
        premium,
        reponse,
        theme,
        propositions,
        type
    )
VALUES (
        'Quelle est la capitale de la France?',
        TRUE,
        'Paris',
        'Geographie',
        'Lyon|Marseille|Bordeaux',
        'QCM'
    ), (
        'Quel est le plus haut sommet de la France?',
        TRUE,
        'Mont Blanc',
        'Geographie',
        'Pyrenees|Alpes|Massif central',
        'QCM'
    ), (
        'Quelle est la date de naissance de Napoléon Bonaparte?',
        FALSE,
        '15 août 1769',
        'Histoire',
        '',
        'QCT'
    ), (
        'Quel est le nom de la devise de l\'Union européenne?',
        FALSE,
        'L\'euro',
        'Economie',
        '',
        'QCT'
    ), (
        'Quelle est la capitale du Burkina Faso?',
        FALSE,
        'Ouagadougou',
        'Geographie',
        '',
        'QCT'
    ), (
        'Quel est le nom du premier président de la Côte d\'Ivoire?',
        FALSE,
        'Félix Houphouët-Boigny',
        'Histoire',
        '',
        'QCT'
    ), (
        'Quel est le plus grand pays d\'Afrique?',
        TRUE,
        'Algérie',
        'Geographie',
        'Nigeria|Egypte|Afrique du Sud',
        'QCM'
    ), (
        'Quel est le nom du célèbre peintre espagnol?',
        FALSE,
        'Pablo Picasso',
        'Art',
        '',
        'QCT'
    ), (
        'Quel est le nom du plus grand océan?',
        FALSE,
        'Océan Pacifique',
        'Geographie',
        'Océan Atlantique|Océan Indien|Océan Arctique',
        'QCM'
    ), (
        'Quelle est la plus grande religion du monde?',
        FALSE,
        'Islam',
        'Religion',
        'Christianisme|Hindouisme|Bouddhisme',
        'QCM'
    ), (
        'Sur une échelle de 1 à 10, combien de fois par semaine mangez-vous de la viande?',
        FALSE,
        '5',
        'Sante',
        '',
        'QCS'
    ), (
        'Sur une échelle de 1 à 10, quelle est votre satisfaction avec votre vie actuelle?',
        FALSE,
        '7',
        'Societe',
        '',
        'QCS'
    ), (
        'Sur une échelle de 1 à 10, combien aimez-vous les films d\'horreur?',
        FALSE,
        '3',
        'Cinema',
        '',
        'QCS'
    );

INSERT INTO REF_ROLES
VALUES ('ROLE_USER', 'Utilisateur'), (
        'ROLE_ADMIN',
        'Administrateur'
    );

INSERT INTO have_role
VALUES ('user1', 'ROLE_USER'), ('admin1', 'ROLE_ADMIN'), ('admin1', 'ROLE_USER');

INSERT INTO QUESTION_TENTATIVE (1, 1, 'init');

INSERT INTO do_tentative (1, 'admin', 1);

-- trigger si la question

DELIMITER //

CREATE TRIGGER CHECK_DUPLICATE_QUESTION BEFORE INSERT 
ON QUESTIONS FOR EACH ROW BEGIN 
	DECLARE prop_count INT;
	DECLARE i INT DEFAULT 1;
	DECLARE prop_value VARCHAR(255);
	DECLARE existing_question_id INT;
	-- Compter le nombre de propositions
	SET
	    prop_count = LENGTH(NEW.propositions) - LENGTH(
	        REPLACE (NEW.propositions, '|', '')
	    ) + 1;
	-- Vérifier si une question similaire existe déjà
	WHILE i <= prop_count
	DO
	    -- Extraire la valeur de la proposition
	SET
	    prop_value = SUBSTRING_INDEX(
	        SUBSTRING_INDEX(NEW.propositions, '|', i),
	        '|',
	        -1
	    );
	-- Vérifier si une question similaire existe déjà
	SELECT
	    id_question INTO existing_question_id
	FROM QUESTIONS
	WHERE
	    interrogation = NEW.interrogation
	    AND propositions LIKE CONCAT('%', prop_value, '%');
	IF existing_question_id IS NOT NULL THEN -- Si une question similaire existe et is_shown est false, mettre à true
	IF NOT (
	    SELECT is_shown
	    FROM QUESTIONS
	    WHERE
	        id_question = existing_question_id
	) THEN
	SET NEW.is_shown = true;
	ELSE SIGNAL SQLSTATE '45000'
	SET
	    MESSAGE_TEXT = 'Impossible d\'insérer. Une question similaire existe déjà.';
	END IF;
	END IF;
	SET i = i + 1;
	END WHILE;
	END// 


DELIMITER ;