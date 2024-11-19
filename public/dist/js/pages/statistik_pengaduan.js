/* =======  VARIABEL & KOMPONEN INIT ======= */
// Donut Chart
var ctx = document.getElementById('donutChart').getContext('2d');
var donutChart = new Chart(ctx, {
    type: 'doughnut', 
    data: {
        labels: ['Pengaduan Selesai', 'Pengaduan Diproses', 'Pengaduan Ditolak'], // Labels for the sections
        datasets: [{
            data: [
                completedPengaduan, 
                inProgressPengaduan, 
                rejectedPengaduan  
            ],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545'], 
            hoverOffset: 4 
        }]
    },
    options: {
        responsive: true, 
        maintainAspectRatio: false, 
        plugins: {
            legend: {
                position: 'top', 
                labels: {
                    boxWidth: 20, 
                    padding: 15 
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw;
                    }
                }
            }
        }
    }
});

// Area Chart
var labels = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
];

var data = {
    labels: labels,
    datasets: [{
        label: 'Pengaduan per Bulan',
        data: Object.values(monthlyData), // Get the monthly data values
        fill: true,
        backgroundColor: 'rgba(102, 179, 255, 0.3)',
        borderColor: 'rgba(102, 179, 255, 1)',
        borderWidth: 2,
    }]
};

var ctx = document.getElementById('areaChart').getContext('2d');
var areaChart = new Chart(ctx, {
    type: 'line', // Area chart is a line chart with filled areas
    data: data,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
            },
            y: {
                beginAtZero: true,
            }
        }
    }
});