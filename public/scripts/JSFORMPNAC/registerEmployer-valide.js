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
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/.test(value)
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
      "employer[foo][email]": {
        required: true,
        email: true,
      },
      "employer[foo][FisrtName]": {
        required: true,
        minlength: 2,
        nowhitespace: true,
        lettersonly: true,
      },
      "employer[foo][LastName]": {
        required: true,
        minlength: 2,
        lettrespace: true,
      },
      "employer[foo][phone]": {
        required: true,
        minlength: 3,
        numero: true,
      },
      "employer[foo][password]": {
        required: true,
        strongPassword: true,
      },
      "employer[foo][confirmepassword]": {
        required: true,
        equalTo: "#employer_foo_password",
      },
      "employer[file][file]": {
        required: true,
        extension: "pdf",
        maxsize: "1000000",
      },
      "employer[Bureau]": {
        required: true,
        minlength: 2,
        lettrespace: true,
      },
      "employer[Fonction]": {
        required: true,
        minlength: 2,
        lettrespace: true,
      },
      "employer[NumeroBureau]": {
        required: true,
        minlength: 2,
        numero: true,
      },
    },
    messages: {
      "employer[foo][email]": {
        required: "Veuillez saisir une adress email.",
        email: "Veuillez saisir une adress email  <em>valide</em> .",
      },
      "employer[foo][FisrtName]": {
        required: "Veuillez saisir votre prenom.",
        minlength: "Veuillez saisir au moins deux caractere.",
        nowhitespace: "Veuillez ne pas entre des space.",
        lettersonly: "Veuillez saisir que des lettres.",
      },
      "employer[foo][LastName]": {
        required: "Veuillez saisir votre nom.",
        minlength: "Veuillez saisir au moins deux caractere.",
      },
      "employer[foo][phone]": {
        required: "Veuillez saisir votre numero de telephone.",
        minlength: "Veuillez saisir au moins 3 chiffre.",
      },
      "employer[foo][password]": {
        required: "Veuillez saisir un mot de passe.",
      },
      "employer[foo][confirmepassword]": {
        required: "Veuillez confirme le mot de passe.",
        equalTo: "Veuillez re-saisir le mot de passe.",
      },
      "employer[file][file]": {
        required: "Veuillez un insert un fichier.",
        extension: "Veuillez insert un fichier avec une extension valide(pdf).",
        maxsize: "La taille du fichier ne doit pas dépasser {0} octets chacun.",
      },
      "employer[NumeroBureau]": {
        required: "Veuillez saisir le numero fix du bureau .",
        minlength: "Veuillez saisir au moins 3 chiffre.",
      },
      "employer[Fonction]": {
        required: "Veuillez saisir la fonction occuppe sur le site .",
        minlength: "Veuillez saisir au moins deux caractere.",
      },
      "employer[Bureau]": {
        required: "Veuillez saisir le Bureau .",
        minlength: "Veuillez saisir au moins deux caractere.",
      },
    },
  });
});
