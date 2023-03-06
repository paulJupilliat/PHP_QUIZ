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
    } else if (classes.contains("QCU")) {
      for (let j = 0; j < reponses.length; j++) {
        if (reponses[j].checked) {
          propositions += reponses[j].value;
        }
      }
    } else if (classes.contains("QCS")) {
      // on récupère la valeur du slider
      let slider = question.getElementsByClassName("slider")[0];
      let value = slider.value;
      propositions += value;
    }
    else if (classes.contains("QCT")) {
      // on récupère la valeur du champ texte
      propositions += reponses[0].value;
    }
      // Enlever le dernier caractère
    propositions = propositions.substring(0, propositions.length - 1);
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
  window.location.href = "index.php?action=scoreQuizz&quizz=" + quizz;
}
