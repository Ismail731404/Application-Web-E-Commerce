function onclickAjouter(Event) {
    
    
    const url = this.href;
    
const formParentElement = this.parentElement;

formParentElement.addEventListener("submit", e => {


e.preventDefault();
alert('Veuillez vérifier le recaptcha');


}, false)
    const aCount = document.querySelector('span.js-fwertpni');
    var qtsValue = parseInt(aCount.innerText) || 0;
    axios.get(url).then(function (response) {
        
        alert(qtsValue);
        aCount.textContent = qtsValue + response.data.qttes;
        alert(response.data.test);

    },false);
}

// link = document.querySelector('a.js-ajouter')
var link = document.getElementById("js-ajouter")
    link.addEventListener('click', onclickAjouter);
