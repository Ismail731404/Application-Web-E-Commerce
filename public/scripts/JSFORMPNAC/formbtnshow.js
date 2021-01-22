$(document).ready(function () {

    $.validator.setDefaults({
        //Utilise la class invalid 
        //source https://getbootstrap.com/docs/4.4/components/forms/#validation
        errorClass: 'help-block invalid-feedback',
        highlight: function (element) {
            $(element)
                .closest('.form-control')
                .addClass('is-invalid')
                .closest('.help-block')
                .addClass('invalid-feedback');
        },
        unhighlight: function (element) {
            $(element)
                .closest('.form-control')
                .removeClass('is-invalid')
                .addClass('is-valid');
        },
        errorPlacement: function (error, element) {
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $.validator.addMethod(
        "numero",
        function (value, element) {
          return this.optional(element) || /^(\+)?[0-9" "]+$/i.test(value);
        },
        "Veuillez entre un numero."
      );
    $.validator.addMethod('lettrespace', function (value, element) {
        return this.optional(element) || /^[a-z" "]+$/i.test(value);
    }, 'Veuillez saisir que des lettres.')

    $('#btnfisrtname').click(e => {
        e.preventDefault();
        $('#formfisrtname').slideDown();
        $('#form_prenom').validate({

            rules: {
                'fisrtname': {
                    required: true,
                    minlength: 2,
                    nowhitespace: true,
                    lettersonly: true
                }
            },
            messages: {

                'fisrtname': {
                    required: "Veuillez saisir votre prenom.",
                    minlength: "Veuillez saisir au moins deux caractere.",
                    nowhitespace: "Veuillez ne pas entre des space.",
                    lettersonly: "Veuillez saisir que des lettres."
                }
            }

        });
        $('#btnfisrtname').slideUp();
    });


    $('#btnlastname').click(e => {
        e.preventDefault();
        $('#formlastname').slideDown();
        $('#form_nom').validate({

            rules: {
                'lastname': {
                    required: true,
                    minlength: 2,
                    lettrespace: true
                }
            },
            messages: {

                'lastname': {
                    required: "Veuillez saisir votre nom.",
                    minlength: "Veuillez saisir au moins deux caractere.",
                }
            }

        });
        $('#btnlastname').slideUp();
    });

    $('#btnemail').click(e => {
        e.preventDefault();
        $('#formemail').slideDown();
        $('#form_email').validate({

            rules: {
                'email': {
                    required: true,
                    email: true
                }
            },
            messages: {

                'email': {
                    required: "Veuillez saisir une adress email.",
                    email: "Veuillez saisir une adress email  <em>valide</em> . "
                }
            }

        });
        $('#btnemail').slideUp();
    });



    $('#btnphone').click(e => {
        e.preventDefault();
        $('#formphone').slideDown();
        $('#form_phone').validate({

            rules: {
                'phone': {
                    required: true,
                    minlength: 3,
                    numero: true,
                }
            },
            messages: {

                'phone':{
                    required: "Veuillez saisir votre numero de telephone.",
                    minlength: "Veuillez saisir au moins 3 chiffre.",
                  }
            }

        });
        $('#btnphone').slideUp();
    });



});

$('#annuleremail').click(e => {
    $('#formemail').slideUp();
    $('#btnemail').slideDown();
});

$('#annulernom').click(e => {
    e.preventDefault();
    $('#formlastname').slideUp();
    $('#btnlastname').slideDown();
});

$('#annulerprenom').click(e => {
    e.preventDefault();
    $('#formfisrtname').slideUp();
    $('#btnfisrtname').slideDown();
});
$('#annulerphone').click(e => {
    e.preventDefault();
    $('#formphone').slideUp();
    $('#btnphone').slideDown();
});
