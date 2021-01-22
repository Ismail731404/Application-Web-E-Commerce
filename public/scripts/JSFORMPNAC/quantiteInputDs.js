var qts = document.getElementById("qttStock");
var qtsValue = parseInt(qts.innerText) || 0;
var unite = document.getElementById("unite");
var unitechoix= unite.innerText;
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
        "numero",
        function (value, element) {
            return this.optional(element) || /^[0-9]+$/i.test(value);
        },
        "Veuillez entre un numero."
    );
    var form = $("#form_id");
    form.validate({
        rules: {
            "qttu": {
                required: true,
                min: 1,
                max: qtsValue
            }
        },
        messages: {
            "qttu": {
                required: "Veuillez saisir une quantite.",
                min: "Veuillez saisi une quantite superieur à 0",
                max: "Veuillez saisi une quantite infierieur à {0} "+unitechoix
            }
        },
    }, false);

    form.on("submit", function (e) {
        if (!form.valid()) {
            return false; //Check first if the form is valid, otherwise return false which will redirect to validation
        }

        e.preventDefault();//If the form is valid, prevent default submission
        const formData = new FormData();
        const valuebtnadd = document.getElementsByName("qttu")[0].value;
        formData.append('qttu', valuebtnadd);
        const url = document.getElementById("form_id").action;
        const aCount = document.querySelector('span.js-fwertpni');
        alert("Vous avez ajouter "+valuebtnadd+ " dechet au panier" ) ;
        axios.post(url, formData).then(function (response) {
            aCount.textContent = response.data.qttes;
        });
    });
}

);

