function onclickBtn(event) {
    event.preventDefault();//If the form is valid, prevent default submission
    const url = this.href;
    axios.get(url);
}
const link = document.getElementById('default');

link.addEventListener('click', onclickBtn);