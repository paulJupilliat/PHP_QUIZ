let validate = document.getElementsByClassName("validate");
let close = document.getElementsByClassName("close");
let popup = document.getElementsByClassName("popup");
let buttonTogglePopup = document.getElementsByClassName("button-toggle-popup");
let typeQuest = document.getElementById("type-quest");


function togglePopup() {
    popup[0].style.display === "block" ? popup[0].style.display = "none" : popup[0].style.display = "block";
}

/**
 * According to the type of question, show the right input
 */
function showReponseProp() {
    // récupérer la valeur du menu déroulant
    let type = typeQuest.value;
    let reponseProp = document.getElementById("reponses-prop");

    // clear the div
    reponseProp.innerHTML = "";

    if (type === "texte") {
      // ajouter une zone de texte
      reponseProp.insertAdjacentHTML(
        "afterend",
        "<input type='text' name='reponseProp' id='reponseProp' placeholder='Réponse proposée' required>"
      );
    }
    else if (type === "radio" || type === "checkbox") {
        // ajouter une zone de texte
        reponseProp.insertAdjacentHTML(
          "afterend",
          "<input type='text' name='reponseProp' id='reponseProp' placeholder='Réponse(s) proposée(s)' required>"
        );
        // et un bouton pour ajouter d'autre reponse
        reponseProp.insertAdjacentHTML(
          "afterend",
          "<button type='button' id='addReponseProp'>Ajouter une réponse</button>"
        );
    }
    else if (type === "number"){
        reponseProp.insertAdjacentHTML(
          "afterend",
          "<input type='number' name='reponseProp' id='reponseProp' placeholder='Valeur max du curseur' required>"
        );
    }
    else {
        console.log(type);
    }
}

    
