$(document).ready(function () {
  $.validator.setDefaults({
    //Utilise la class invalid
    //source https://getbootstrap.com/docs/4.4/components/forms/#validation
    errorClass: "help-block invalid-feedback",
    highlight: function (element) {
      $(element)
        .closest(".form-control")
        .addClass("is-invalid")
        .closest(".help-block")
        .addClass("invalid-feedback");
    },
    unhighlight: function (element) {
      $(element)
        .closest(".form-control")
        .removeClass("is-invalid")
        .addClass("is-valid");
    },
    errorPlacement: function (error, element) {
      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
      }
    },
  });

  $.validator.addMethod(
    "strongPassword",
    function (value, element) {
      return (
        this.optional(element) ||
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[A-Za-z0-9,\-,_,\.]{8,}$/.test(value)
      );
    },
    "Votre mot de passe doit avoir au moins 8 characteres et contenir au moins un chiffre ,une lettre en majuscule et minuscule."
  );
  $.validator.addMethod(
    "numero",
    function (value, element) {
      return this.optional(element) || /^[0-9" "]+$/i.test(value);
    },
    "Veuillez entre un numero."
  );

  $.validator.addMethod(
    "lettrespace",
    function (value, element) {
      return this.optional(element) || /^[a-z" "]+$/i.test(value);
    },
    "Veuillez saisir que des lettres."
  );

  $("#form_registeur").validate({
    rules: {
      "dechet[designation]": {
        required: true,
        minlength: 2,
        nowhitespace: true,
        lettersonly: true,
      },
      "dechet[prix]": {
        required: true,
        number: true,
      },
      "dechet[ville]": {
        required: true,
        minlength: 3,
        nowhitespace: false,
        lettersonly: true,
      },
      "dechet[quantiteStock]": {
        required: false,
        digits: true,
      },
      "dechet[imageFile]": {
        extension: "jpeg|jpg|jfif",
      },
      "dechet[description]": {
        required: true,
        minlength: 10,
      },
      "dechet[CodePostal]": {
        required: true,
        rangelength: [5, 5],
      },
    },
    messages: {
      "dechet[designation]": {
        required: "Veuillez saisir le nom du dechet.",
        minlength: "Veuillez saisir au moins deux caractere.",
        nowhitespace: "Veuillez ne pas entre des space.",
        lettersonly: "Veuillez saisir que des lettres.",
      },
      "dechet[prix]": {
        required: "Veuillez saisir votre nom.",
        number: "Veuillez saisir just de chiffre ou decimal",
      },
      "dechet[ville]": {
        required: "Veuillez saisir le nom du dechet.",
        minlength: "Veuillez saisir au moins trois caractere.",
        nowhitespace: "Veuillez ne pas entre des space.",
        lettersonly: "Veuillez saisir que des lettres.",
      },
      "dechet[quantiteStock]": {
        required: "Quantite Stocke peut etre vide.",
        digits: "Veuillez saisir just de chiffre",
      },
      "dechet[imageFile]": {
        extension:
          "Veuillez insert un fichier avec une extension valide(jpeg,jpg ou jfif) pas {0}.",
      },
      "dechet[description]": {
        required: "Veuillez un insert un fichier.",
        minlength: "La taille minimale de description est 10 caracteres.",
      },
      "dechet[CodePostal]": {
        required: "Veuillez saisir le code postal",
        rangelength: "Le code postal doit compose 5 nombre",
      },
    },
  });
});
