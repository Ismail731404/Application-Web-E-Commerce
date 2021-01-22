/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)

// import 'path-to-bundles/fpjsformvalidator/js/FpJsFormValidator';
// import 'path-to-bundles/fpjsformvalidator/js/jquery.fpjsformvalidator';

import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel/dist/assets/owl.theme.green.css";
import "owl.carousel";
import "../css/app.scss";
import "../css/style.css";
import "../css/styles/layout.css"





import "../css/Loading.css";
import noUiSlider from "nouislider";
import "nouislider/distribute/nouislider.css";

//le slide home
// import '../css/script.js';
// import '../css/style.css';

import Filter from "./modules/Filter";
new Filter(document.querySelector(".js-filter"));

//image file

// $('.custom-file-input').on('change', function(event) {
//     var inputFile = event.currentTarget;
//     $(inputFile).parent()
//         .find('.custom-file-label')
//         .html(inputFile.files[0].name);
// });

const $ = require("jquery");
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require("bootstrap");

$(document).ready(function () {
  $('[data-toggle="popover"]').popover();
});

//let $ = require('jquery')

require("select2");

$("select").select2();

let $contactButton = $("#contactButton");
$contactButton.click((e) => {
  e.preventDefault();
  $("#contactForm").slideDown();
  $contactButton.slideUp();
});
$("#categorieannule").click((e) => {
  $("#contactForm").slideUp();
  $("#contactButton").slideDown();
});
$("#dechetannule2").click((e) => {
  $("#contactForm").slideUp();
  $("#contactButton").slideDown();
});

let $publiciteButton = $("#publiciteButton");
$publiciteButton.click((e) => {
  e.preventDefault();
  $("#publiciteForm").slideDown();
  $publiciteButton.slideUp();
});
$("#publiciteannule").click((e) => {
  $("#publiciteForm").slideUp();
  $("#publiciteButton").slideDown();
});

let $dechetButton = $("#dechetButton");
$dechetButton.click((e) => {
  e.preventDefault();
  $("#dechetForm").slideDown();
  $dechetButton.slideUp();
});
$("#dechetannule").click((e) => {
  $("#dechetForm").slideUp();
  $("#dechetButton").slideDown();
});

let $categorieButton = $("#categorieButton");
$categorieButton.click((e) => {
  e.preventDefault();
  $("#categorieForm").slideDown();
  $categorieButton.slideUp();
});

$(document).ready(function () {
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 100,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: true,
      },
      600: {
        items: 3,
        nav: false,
      },
      1000: {
        items: 5,
        nav: true,
        loop: false,
      },
    },
  });
});

const slider = document.getElementById("price-slider");

if (slider) {
  const min = document.getElementById("min");
  const max = document.getElementById("max");
  const minValue = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10;
  const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10;
  const range = noUiSlider.create(slider, {
    start: [min.value || minValue, max.value || maxValue],
    connect: true,
    step: 10,
    range: {
      min: minValue,
      max: maxValue,
    },
  });
  range.on("slide", function (values, handle) {
    if (handle === 0) {
      min.value = Math.round(values[0]);
    }
    if (handle === 1) {
      max.value = Math.round(values[1]);
    }
  });
  range.on("end", function (values, handle) {
    if (handle === 0) {
      min.dispatchEvent(new Event("change"));
    } else {
      max.dispatchEvent(new Event("change"));
    }
  });
}

//   $('#btnfisrtname').click(e => {
//     e.preventDefault();
//     $('#formfisrtname').slideDown();
//     $('#form_prenom').validate({

//         rules: {
//             'fisrtname': {
//                 required: true,
//                 minlength: 2,
//                 nowhitespace: true,
//                 lettersonly: true
//             }
//         },
//         messages: {

//             'fisrtname': {
//                 required: "Veuillez saisir votre prenom.",
//                 minlength: "Veuillez saisir au moins deux caractere.",
//                 nowhitespace: "Veuillez ne pas entre des space.",
//                 lettersonly: "Veuillez saisir que des lettres."
//             }
//         }

//     });
//     $('#btnfisrtname').slideUp();
// });

// // Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// // import $ from 'jquery';

// $(document).ready(function () {

//     $.validator.setDefaults({
//         //Utilise la class invalid
//         //source https://getbootstrap.com/docs/4.4/components/forms/#validation
//         errorClass: 'help-block invalid-feedback',
//         highlight: function (element) {
//             $(element)
//                 .closest('.form-control')
//                 .addClass('is-invalid')
//                 .closest('.help-block')
//                 .addClass('invalid-feedback');
//         },
//         unhighlight: function (element) {
//             $(element)
//                 .closest('.form-control')
//                 .removeClass('is-invalid')
//                 .addClass('is-valid');
//         },
//         errorPlacement: function (error, element) {
//             if (element.prop('type') === 'checkbox') {
//                 error.insertAfter(element.parent());
//             } else {
//                 error.insertAfter(element);
//             }
//         }
//     });

//     $.validator.addMethod('lettrespace', function (value, element) {
//         return this.optional(element) || /^[a-z" "]+$/i.test(value);
//     }, 'Veuillez saisir que des lettres.')

//     $('#btnfisrtname2011').click(e => {
//         e.preventDefault();
//         $('#formfisrtname2011').slideDown();
//         $('#form_prenom2011').validate({

//             rules: {
//                 'fisrtname': {
//                     required: true,
//                     minlength: 2,
//                     nowhitespace: true,
//                     lettersonly: true
//                 }
//             },
//             messages: {

//                 'fisrtname': {
//                     required: "Veuillez saisir votre prenom.",
//                     minlength: "Veuillez saisir au moins deux caractere.",
//                     nowhitespace: "Veuillez ne pas entre des space.",
//                     lettersonly: "Veuillez saisir que des lettres."
//                 }
//             }

//         });
//         $('#btnfisrtname2011').slideUp();
//     });

//     $('#btnlastname').click(e => {
//         e.preventDefault();
//         $('#formlastname').slideDown();
//         $('#form_nom').validate({

//             rules: {
//                 'lastname': {
//                     required: true,
//                     minlength: 2,
//                     lettrespace: true
//                 }
//             },
//             messages: {

//                 'lastname': {
//                     required: "Veuillez saisir votre nom.",
//                     minlength: "Veuillez saisir au moins deux caractere.",
//                 }
//             }

//         });
//         $('#btnlastname').slideUp();
//     });

//     $('#btnemail').click(e => {
//         e.preventDefault();
//         $('#formemail').slideDown();
//         $('#form_email').validate({

//             rules: {
//                 'email': {
//                     required: true,
//                     email: true
//                 }
//             },
//             messages: {

//                 'email': {
//                     required: "Veuillez saisir une adress email.",
//                     email: "Veuillez saisir une adress email  <em>valide</em> . "
//                 }
//             }

//         });
//         $('#btnemail').slideUp();
//     });

// });

// $('#annuleremail').click(e => {
//     $('#formemail').slideUp();
//     $('#btnemail').slideDown();
// });

// $('#annulernom').click(e => {
//     e.preventDefault();
//     $('#formlastname').slideUp();
//     $('#btnlastname').slideDown();
// });

// $('#annulerprenom').click(e => {
//     e.preventDefault();
//     $('#formfisrtname').slideUp();
//     $('#btnfisrtname').slideDown();
// });

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
      required: "Quantite Stocke peut etre 0",
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























/****  header */



console.log("Hello Webpack Encore! Edit me in assets/js/app.js");
