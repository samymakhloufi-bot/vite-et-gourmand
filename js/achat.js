/*---------------------------
    input ville livraison
----------------------------*/
const lieuSelect = document.getElementById('ville-livraison');
const villeAutre = document.getElementById('ville-livraison-autre-div');

lieuSelect.addEventListener('change', () => {
    if(lieuSelect.value ==='autre'){
        villeAutre.style.display ='block';
    }else{
        villeAutre.style.display = 'none';
        document.getElementById('ville-livraison-autre').value ='' ;
    }
});
