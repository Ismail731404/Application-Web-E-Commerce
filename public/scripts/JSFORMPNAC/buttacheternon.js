$("#js-acheter").on("click", function (e) {

    e.preventDefault();
    const valeur = document.getElementsByName("qttu")[0].value;
    const qtte = document.getElementsByName("qttuet")[0].value;
    if (valeur > 0 && valeur <= qtte && valeur != "") {
        $('#form_id').attr('action', "/app/commander").unbind('submit').submit();
    } else {
        document.getElementsByName("qttu")[0].focus();
    }

});

