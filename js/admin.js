let validate = document.getElementsByClassName("validate");
let close = document.getElementsByClassName("close");
let popupAddQuest = document.getElementById("popupAddQuest");
let buttonTogglePopup = document.getElementsByClassName("button-toggle-popup");
let typeQuest = document.getElementById("type-quest");
let themeChoice = document.getElementById("theme-choice");
let formNewQuest = document.getElementById("form-new-quest");

function togglePopupAddQuest() {
  popupAddQuest.style.display === "block"
    ? (popupAddQuest.style.display = "none")
    : (popupAddQuest.style.display = "block");
}

/**
 * According to the type of question, show the right input
 */
function showReponseProp() {
  console.log("showReponseProp");
  // récupérer la valeur du menu déroulant
  let type = typeQuest.value;
  let reponseProp = document.getElementById("reponses-prop");

  // vider la div
  reponseProp.innerHTML = "";
  console.log(type);

  if (type === "text") {
    reponseProp.innerHTML =
      "<input type='text' name='reponse' id='reponse' placeholder='Réponse proposée' required>";
  } else if (type === "radio" || type === "checkbox") {
    // ajouter une zone de texte
    reponseProp.innerHTML =
      "<input type='text' name='reponse' id='reponse' placeholder='Réponse' required>";
    // et un bouton pour ajouter d'autre reponse
    reponseProp.innerHTML +=
      "<button type='button' id='addReponseProp' onclick='addProp()'>Ajouter une réponse</button>";
  } else if (type === "number") {
    reponseProp.innerHTML =
      "<input type='number' name='reponseProp' class='reponseProp' placeholder='Valeur max du curseur' required>";
    reponseProp.innerHTML +=
      "<input type=number' name='reponse' id='reponse' placeholder='reponse' required>";
  } else {
    console.log(type);
  }
}

function addProp() {
  let reponseProp = document.getElementById("reponses-prop");
  let addReponseProp = document.getElementById("addReponseProp");
  // supprimer le bouton
  addReponseProp.remove();
  // ajouter une zone de texte
  reponseProp.innerHTML +=
    "<input type='text' class='reponseProp' placeholder='Réponse proposée' required>";
  // et un bouton pour ajouter d'autre reponse
  reponseProp.innerHTML +=
    "<button type='button' id='addReponseProp' onclick='addProp()'>Ajouter une réponse</button>";
}

/**
 * If in the admin page you choice other theme, show the input to add the name of the theme
 */
function newTheme() {
  let theme = themeChoice.value;
  let inputOtherTheme = document.getElementById("input-other-theme");
  if (theme === "other") {
    inputOtherTheme.style.display = "block";
  } else {
    inputOtherTheme.style.display = "none";
  }
}

/**
 * Traite le formulaire de création de question et format les données à envoyer
 */
function submitNewQuest() {
  // récupérer les données du formulaire
  let question = document.getElementById("question").value;
  let type = typeQuest.value;
  let theme = themeChoice.value;
  let reponse = document.getElementById("reponse").value;
  let reponsesPropToSend = "";
  let otherTheme = document.getElementById("otherTheme").value;

  // si le type est radio ou checkbox, récupérer les réponses proposées
  if (type === "radio" || type === "checkbox") {
    let reponsesProp = document.getElementsByClassName("reponseProp");
    for (let i = 0; i < reponsesProp.length; i++) {
      reponsesPropToSend += reponsesProp[i].value + "|";
    }
    // enlève le dernier|
    reponsesPropToSend = reponsesPropToSend.slice(0, -1);
  }
  else if (type === "number") {
    let reponsesProp = document.getElementsByClassName("reponseProp");
    reponsesPropToSend = reponsesProp[0].value;
    console.log(reponsesPropToSend);
  }
  // envoyer les donnéer par l'url
  window.location.href =
    "index.php?action=addQuestion&question=" +
    question +
    "&type=" +
    type +
    "&theme=" +
    theme +
    "&otherTheme=" +
    otherTheme +
    "&reponse=" +
    reponse +
    "&reponsesProp=" +
    reponsesPropToSend;
}

function deleteQuest(id) {
  // window.location.href = "index.php?action=deleteQuestion&id=" + id; avec la méthode POST
  let formDeleteQuest = document.createElement("form"); // Crée un élément de formulaire
  formDeleteQuest.method = "POST"; // Spécifie la méthode POST
  formDeleteQuest.action = "index.php?action=deleteQuestion&id=" + id; // Spécifie l'URL à laquelle envoyer la requête et l'identifiant de la question à supprimer

  // Ajoute un champ caché pour l'identifiant de la question
  let inputId = document.createElement("input");
  inputId.setAttribute("type", "hidden");
  inputId.setAttribute("name", "id");
  inputId.setAttribute("value", id);
  formDeleteQuest.appendChild(inputId);

  // Ajoute le formulaire à la page et soumet la requête
  document.body.appendChild(formDeleteQuest);
  formDeleteQuest.submit();
}
