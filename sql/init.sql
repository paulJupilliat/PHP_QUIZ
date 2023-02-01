CREATE TABLE ref_CATEGORIE(
    nom VARCHAR(42) PRIMARY KEY;
)
CREATE TABLE ref_TYPE(
    type VARCHAR(42) PRIMARY KEY;
)

CREATE TABLE QUESTIONS(
    id INT PRIMARY KEY auto_increment,
    question VARCHAR(255),
    reponse VARCHAR(255)
    categorie VARCHAR(42),
    propositions VARCHAR(42),
    type VARCHAR(42),
    FOREIGN KEY (categorie) REFERENCES ref_CATEGORIE(nom),
    FOREIGN KEY (type) REFERENCES ref_TYPE(type)
)

INSERT INTO ref_TYPE VALUES
    ('QCM', 'Question avec plusieurs choix possible'),
    ('QCU', 'Question avec un seul choix possible, et des propositions'),
    ('QCS', 'Question avec un seul choix possible, sans propositions'),
    ('QCT', 'Question avec un texte libre'),
    ('QCS', 'Question a choix avec un slider');
CREATE TRIGGER chekProposition 