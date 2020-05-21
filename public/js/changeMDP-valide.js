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

  $("#form_registeur").validate({
    rules: {
      "change_mdp[oldMDP]": {
        required: true,
        strongPassword: true,
      },
      "change_mdp[foo][password]": {
        required: true,
        strongPassword: true,
      },
      "change_mdp[foo][confirmepassword]": {
        required: true,
        equalTo: "#change_mdp_foo_password",
      },
    },
    messages: {
      "change_mdp[foo][password]": {
        required: "Veuillez saisir un mot de passe.",
      },
      "change_mdp[foo][confirmepassword]": {
        required: "Veuillez confirme le mot de passe.",
        equalTo: "Veuillez re-saisir le mot de passe.",
      },

      "change_mdp[oldMDP]": {
        required: "Veuillez saisir votre ancien mot de passe.",
      },
    },
  });
});
