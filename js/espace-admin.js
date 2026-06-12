/*-------------------
    GRAPH TURNOVER
--------------------*/

const canvas = document.getElementById('chartCommandes');

if(canvas) {
    new Chart(canvas,{
        type: 'bar',
        data:{
            labels: labels,
            datasets:[
                {
                    label: 'Nombre de commandes',
                    data: nbCommandes,
                    backgroundColor: '#7D241A',
                    borderRadius: 6,
                },
                {
                    label: 'CA (€)',
                    data: caData,
                    backgroundColor: '#d4a96a',
                    borderRadius: 6,
                }
            ]
        },
        options:{
            responsive: true,
            plugins:{
                legend:{position: 'top'},
                title:{
                    display:true,
                    text:'Commandes & CA par menu'
                }
            },
            scales:{
                y:{beginAtZero:true}
            }
        }
    });
}
