/*----------------  
    ADMIN SIDEBAR
-----------------*/
const btnEmployee = document.querySelector('.btn-employee');
const subPanel = document.querySelector('.sub-panel');
const plus = document.querySelector('.plus');

btnEmployee.addEventListener('click', ()=> {
    subPanel.classList.toggle('active');
    plus.textContent= subPanel.classList.contains('active') ? '-' : '+';
});


/*---------------------------
    SUB PANEL
----------------------------*/
document.querySelectorAll('.sub-panel button').forEach(btn =>{
    btn.addEventListener('click', () => {
        const target = btn.dataset.target;

        document.querySelectorAll('.sub-tabs').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.sub-tabs button').forEach(b => b.classList.remove('active'));
        
    })
})


