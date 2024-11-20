<script>
    
    // Initialize months and counts from PHP to JavaScript
    let months = <?php echo json_encode($months); ?>;
    let assignmentCounts = <?php echo json_encode($assignmentCounts); ?>;
    
    // Create the initial chart
    const ctx = document.getElementById('monthlyAssignmentChart').getContext('2d');
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months, // Month labels
            datasets: [{
                label: 'Inventory Assignments',
                data: assignmentCounts, // Count data
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, // Start y-axis from zero
                    ticks: {
                        stepSize: 1, // Ensure the y-axis increments by whole numbers
                        callback: function(value) {
                            // Round to the nearest integer and display it
                            return Math.round(value); // Round to the nearest integer
                        }
                    }
                }
            }
        }
    });

    function updateGraph() {
        const selectedYear = document.getElementById('yearFilter').value;

        // Log the selected year for debugging
        console.log('Selected Year: ', selectedYear);

        // Make an AJAX request to fetch the monthly assignment data for the selected year
        fetch('?year=' + selectedYear)
        .then(response => response.json())  // Now expect JSON directly
        .then(data => {
            console.log('Received JSON:', data);

            // Update the chart with the new data
            myBarChart.data.labels = data.months;
            myBarChart.data.datasets[0].data = data.assignmentCounts;
            myBarChart.update();
        })
        .catch(error => console.error('Error fetching data:', error));
    }

</script>
