# Database

## 🧐 About <a name = "about"></a>
This document is a guide to explain the conception of the database and how to use it.

## 🏁 Getting Started <a name = "getting_started"></a>
To use the database, you need to install the following software:
- [docker](https://www.docker.com/)
- [docker-compose](https://docs.docker.com/compose/)

### Start
To launch the database, you need to run the following commands:
```bash
bash startBd.sh
```

For curious: 

To see the ip adresse, run the following command:   
```bash
ip addr | grep -oP '(?<=inet )[\d.]+'
```
Take the second ip address.  
  
    

To access to the database, you need to run the following commands:
```bash
mysql -h <ip Adresse> -P 3306 -u root -p quizz
```
The password is `rootpwd`.  

## Explication
The database is create on docker mysql. During the creation of the container, init script is launch. This script create the database, the tables and users with there privileges. The script is in the folder `./database/init.sql`.

### propositions.QUESTIONS
Proposition of questions as separeted by `|`.   
    ex: `1|2|3|4`   

If the type of question didn't need propositions, the field is `NULL`.   
    ex: `NULL`


## MCD
![MCD](./mcd.png)

You can copy past this code in [mocodo](https://www.mocodo.net) to see the MCD:  
```
:
:

ref_THEMES: theme_names, descritpion
QUESTIONS: id_question, interrogation, reponse, #theme->ref_THEME->theme_name, propositions, #type->ref_TYPE->type_name

:
:

:
ref_TYPES: type_name, description
:
:
USERS: pseudo, nom, prenom, mdp, age
```

## To do
- [ ] Create trigger for chek if this question already exist