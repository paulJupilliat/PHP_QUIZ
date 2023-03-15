<p align="center">
  <a href="" rel="noopener">
 <img width=200px height=200px src="https://i.imgur.com/6wj0hh6.jpg" alt="Project logo"></a>
</p>

<h3 align="center">Project Title</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/kylelobo/The-Documentation-Compendium.svg)](https://github.com/kylelobo/The-Documentation-Compendium/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/kylelobo/The-Documentation-Compendium.svg)](https://github.com/kylelobo/The-Documentation-Compendium/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> Few lines describing your project.
    <br> 
</p>

## 📝 Table of Contents

- [📝 Table of Contents](#-table-of-contents)
- [🧐 About ](#-about-)
- [🏁 Getting Started ](#-getting-started-)
  - [Prerequisites](#prerequisites)
  - [Start](#start)
- [🎈 Usage ](#-usage-)
- [⛏️ Built Using ](#️-built-using-)
- [✍️ Authors ](#️-authors-)

## 🧐 About <a name = "about"></a>

This project is a website of questions. We create this during us studies in the BUT Informatique.

## 🏁 Getting Started <a name = "getting_started"></a>

### Prerequisites

To launch this project you need to install docker-compose
```bash
sudo apt install docker-compose
```  

### Start
Go on sql folder
```bash
cd sql
```
  
<br>
Start by create the docker
```bash
docker-compose up -d
```

To launch the project, you need to run the following commands, on the PHP_QUIZZ folder:
```bash
php -S localhost:8000
```
After go on http://localhost:8000/html/index.php

## 🎈 Usage <a name="usage"></a>

With this website, you can create and connect with user account. An user can be a simple user or a admin. If is a admin, he can manage questions, users and themes, on admin console. If is a simple user, he can play to the quiz, and see his score.

We integrate a prenium system. If you pay 3€ you can acces to prenium questions.

## ⛏️ Built Using <a name = "built_using"></a>

- [Mysql](https://) - Database
  About the database[./docs/database.md]
- [PHP](https://expressjs.com/) - Web Framework

## ✍️ Authors <a name = "authors"></a>

You can see the source code on [github](https://github.com/paulJupilliat/PHP_QUIZ)

- GUERRE Benjamin - [BenGuerre](https://github.com/BenGuerre)
- JUPILLAT Paul - [paulJupilliat](https://github.com/paulJupilliat)
