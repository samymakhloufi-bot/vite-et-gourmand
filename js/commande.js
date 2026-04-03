const radioDiv = document.querySelectorAll('.radio-div');

//Add & remove selected fromd radio
radioDiv.forEach(Option => {
    Option.addEventListener('click', (e) =>{
        e.preventDefault();
        radioDiv.forEach(opt => opt.classList.remove('selected'));
        Option.classList.add('selected');
        document.getElementById(Option.dataset.target).checked = true;
    });
});


//button counter val order
function change(btn, dir){
    const input = btn.parentElement.querySelector('.counter-val');
    const val = parseInt(input.value) + dir;
    if (val >= 1) input.value = val;
}