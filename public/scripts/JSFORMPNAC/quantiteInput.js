var i = document.getElementById('i');
var inti = parseInt(i.value) || 0;
var ts = document.getElementById("totals")

var listqp = new Array(inti);

for (i = 0; i < inti; i++) {
    listqp[i] = document.getElementById("" + i)

    listqp[i].addEventListener("input", function (event) {
        formulaire(event)
    })
}



function formulaire() {


    var i = event.target.getAttribute('id');

    var tu = document.getElementById("totalUni" + i);

    var qts = document.getElementById("qttStock" + i);

    var pu = document.getElementById("prixUni" + i);

    var qtsValue = parseInt(qts.innerText) || 0;
    var qpValue = parseInt(listqp[i].value) || 0;
    var puValue = parseInt(pu.innerText) || 0;


    if (qtsValue >= qpValue && qpValue > 0 && qpValue != "") {
        tu.innerText = qpValue * puValue;
        event.target.className = "form-control text-center is-valid"
        toutCalculer();

    } else {

        event.target.className = " form-control text-center is-invalid"
        
        return false;
    }



}

function toutCalculer() {
    var total = 0
    var tqq = 0;
    for (i = 0; i < inti; i++) {
        var tu = document.getElementById("totalUni" + i)
        total = total + parseInt(tu.innerText) || 0
        var quu = document.getElementById("" + i)
        tqq = tqq + parseInt(quu.value) || 0
    }
    ts.innerText = total
    const aCount = document.querySelector('span.js-fwertpni');
    t = parseInt(aCount.textContent) || 0
    t = tqq;
    aCount.textContent = t;

}
$("#js-acheter-panier").on("click", function (e) {
    nonvalide = false;
    e.preventDefault();
    for (i = 0; i < inti; i++) {
        listqp[i] = document.getElementById("" + i);
        var qts = document.getElementById("qttStock" + i);
        var qtsValue = parseInt(qts.innerText) || 0;

        if (listqp[i].value <= 0 || listqp[i].value == "" || qtsValue < listqp[i].value) {
            nonvalide = true;
            alert('Erreur de saisie')
            break;
        }
    }


    if (!nonvalide) {
        
        $('#form_id').attr('action', "/app/commander").unbind('submit').submit();
    }

});