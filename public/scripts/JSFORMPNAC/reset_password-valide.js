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
      "reset_pass_after[password]": {
        required: true,
        strongPassword: true,
      },
      "reset_pass_after[confirmepassword]": {
        required: true,
        equalTo: "#reset_pass_after_password",
      },
    },
    messages: {
      "reset_pass_after[password]": {
        required: "Veuillez saisir un mot de passe.",
      },
      "reset_pass_after[confirmepassword]": {
        required: "Veuillez confirme le mot de passe.",
        equalTo: "Veuillez re-saisir le mot de passe.",
      },
    },
  });
});
