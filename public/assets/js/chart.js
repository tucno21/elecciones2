// fetch async

async function getChartData() {
    const response = await fetch('https://elecciones2.test/dashboard/charts');
    const data = await response.json();
    return data;
}

//obtener datos
getChartData().then(data => {

    console.log(data.data.votos);

    // //obtener keys
    // const keys = Object.keys(data.data);
    // //obtener valores
    // const values = Object.values(data.data);

    const dataXX = {
        labels: data.data.candidatos,
        datasets: [
            {
                label: 'Votos',
                data: data.data.votos,
                // categoryPercentage: .5,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.3)',
                    'rgba(54, 162, 235, 0.3)',
                    'rgba(255, 206, 86, 0.3)',
                    'rgba(75, 192, 192, 0.3)',
                    'rgba(153, 102, 255, 0.3)',
                    'rgba(255, 159, 64, 0.3)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }
        ]
    };

    //grafico de barras
    var ctx = document.getElementById('chartBar').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: dataXX,
        options: {
            responsive: true,
            y: {
                title: {
                    display: true,
                    text: 'Cant Votos'
                },
                // min: 0,
                // max: 100,
                ticks: {
                    // forces step size to be 50 units
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Voto Electrónico'
                }
            },
        }
    });

    //grafico de torta
    var chartpie = document.getElementById('chartpie');
    var myChart = new Chart(chartpie, {
        type: 'pie',
        data: dataXX,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Voto Electrónico',
                }
            }
        },
    });

});
