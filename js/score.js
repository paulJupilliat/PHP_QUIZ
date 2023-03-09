let questions = document.getElementsByClassName("question");

function getScore() {
  let score = 0;
  let quizz = [];
  // On regarde chaque question
  for (let i = 0; i < questions.length; i++) {
    let question = questions[i];
    let interrogation =
      question.getElementsByClassName("interrogation")[0].innerHTML;
    // On va stocker les interrogations et les réponses dans un tableau de string
    reponses = question.getElementsByClassName("reponse");
    let propositions = "";
    let classes = question.classList; // récupérer les classes de l'élément question
    if (classes.contains("QCM")) {
      for (let j = 0; j < reponses.length; j++) {
        if (reponses[j].checked) {
          propositions += reponses[j].value + "|";
        }
      }
      // Enlever le dernier caractère
      propositions = propositions.substring(0, propositions.length - 1);
    } else if (classes.contains("QCU")) {
      for (let j = 0; j < reponses.length; j++) {
        if (reponses[j].checked) {
          propositions += reponses[j].value;
        }
      }
    } else if (classes.contains("QCS")) {
      // on récupère la valeur du slider
      let value = document.getElementById("myRange").value;
      console.log(value);
      propositions += value;
    } else if (classes.contains("QCT")) {
      // on récupère la valeur du champ texte
      propositions += reponses[0].value;
    }
    quizz.push(
      "question" +
        i +
        "=interrogation:" +
        interrogation +
        "!propositions:" +
        propositions +
        "*"
    );
  }
  // On enlève le dernier * du tableau
  quizz = quizz.join("");
  quizz = quizz.substring(0, quizz.length - 1);
  window.location.href = "index.php?action=scoreQuizz&quizz=" + quizz;
  
  
}
