





    listqp = document.getElementById("ia")

    listqp.addEventListener("input", function (event) {
        formulaire(event)
    })

function formulaire() {


    
    var qts = document.getElementById("qttStock")




    var qtsValue = parseInt(qts.innerText) || 0;
    var qpValue = parseInt(listqp.value) || 0;


    if (qtsValue <= qpValue) {

        alert("le contenu que vous avez saisie est superieur en quantite disponible")
    }


}

