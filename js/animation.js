//animation index
const observer = new IntersectionObserver((entries) =>{
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.classList.add('visible');
        }else {
            entry.target.classList.remove('visible');
        }
    });
}, {threshold : 0.2});

document.querySelectorAll('.card-gout, .card-passion, main h2').forEach(el=> {
    observer.observe(el);
})

