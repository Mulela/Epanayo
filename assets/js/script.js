ScrollOut({
  targets: "p, h3, .partenaire, .choix, .ppc",
});

const formulaire = document.getElementById("formulaireContact");
let isClicked = true;
let showOrHide = function () {
  if (isClicked) {
    formulaire.style.display = "block";
    isClicked = false;
  } else {
    formulaire.style.display = "none";
    isClicked = true;
  }
};
