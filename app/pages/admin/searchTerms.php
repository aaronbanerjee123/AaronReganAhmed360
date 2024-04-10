<?php 
$section = $_GET['section'] ?? 'dashboard';

// Query to retrieve search terms and times searched from the database
$query = "SELECT search_term, times_searched FROM searchterms";
$data = query($query); // Assuming you have a query function to fetch data from the database

// Convert the retrieved data into JSON format
$searchTermsJson = json_encode(array_column($data, 'search_term'));
$timesSearchedJson = json_encode(array_column($data, 'times_searched'));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="myChart"></canvas>

<script>
// Get the canvas element
var ctx = document.getElementById('myChart').getContext('2d');

// Create the chart
var myChart = new Chart(ctx, {
    type: 'bar', // Type of chart (e.g., bar, line, pie, etc.)
    data: {
        labels: <?php echo $searchTermsJson; ?>, // Get search terms from PHP
        datasets: [{
            label: 'Times Searched',
            data: <?php echo $timesSearchedJson; ?>, // Get times searched from PHP
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
