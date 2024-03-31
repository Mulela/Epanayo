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
function evoyerFormulaire(event) {
  event.preventDefault(); // Empêche la soumission normale du formulaire

  // Afficher le chargement
  $("#loading").show();

  // Récupérer les données du formulaire
  var formData = $("#formulaireContact").serializeArray();
  $.ajax({
    type: "POST",
    url: "http://localhost/Epanayo/traitement/formulaire.php",
    data: formData, // Utiliser formData ici
    dataType: "json",
    success: function (response) {
      console.log(response.success);
      if (response.success) {
        // Afficher une alerte en utilisant swal pour indiquer que l'e-mail a été envoyé avec succès
        swal({
          title: "E-mail envoyé !",
          text: "Votre e-mail a été envoyé avec succès.",
          icon: "success",
          button: "OK",
        }).then((value) => {
          if (value) {
            window.location.href = "http://localhost/Epanayo/";
          }
        });
      } else {
        // Afficher un message Swal d'erreur avec le message d'erreur renvoyé depuis le script PHP
        swal({
          title: "Erreur",
          text:
            response.error ||
            "Une erreur s'est produite lors de l'envoi de l'e-mail, veuillez réessayer.",
          icon: "error",
          button: "OK",
        });
      }
    },
    error: function (xhr, status, error) {
      // Afficher une alerte générique en cas d'erreur AJAX
      swal({
        title: "Erreur",
        text: "Une erreur s'est produite lors de l'envoi de l'e-mail, veuillez réessayer.",
        icon: "error",
        button: "OK",
      });
    },
    complete: function () {
      // Masquer le spinner de chargement une fois que la requête AJAX est complète
      $("#loading").hide();
    }
  });
}