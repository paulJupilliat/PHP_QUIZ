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
    for (let j = 0; j < reponses.length; j++) {
      propositions += reponses[j].value + "|";
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
