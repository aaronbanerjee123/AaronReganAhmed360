<?php 
$section = $_GET['section'] ?? 'dashboard';


$filteredCategoryData = null;
if(isset($_GET['filter'])){
    $query = "SELECT c.category, COUNT(p.category_id) AS numberOfPosts 
          FROM categories c 
          LEFT JOIN posts p ON c.id= p.category_id 
          GROUP BY c.id";
    $filteredCategoryData = query($query);
    print_r($filteredCategoryData);

}
// Query to retrieve search terms and times searched from the database
$query = "SELECT COUNT(*) AS numberOfUsers FROM users";
$data = query($query); // Assuming you have a query function to fetch data from the database
$numberOfUsersJson = json_encode(array_column($data, 'numberOfUsers'));

$query = "SELECT COUNT(*) AS numberOfBlogPosts FROM posts";
$data = query($query); // Assuming you have a query function to fetch data from the database
$numberOfPostsJson = json_encode(array_column($data, 'numberOfBlogPosts'));


$query ="SELECT page, COUNT(*) AS total_visits
FROM pageViews
GROUP BY page";

$filteredPageData = query($query); 

$query = "SELECT user, MAX(date) AS recent_visit,page
FROM pageViews
GROUP BY user
ORDER BY recent_visit DESC";

$filteredTrackingData = query($query);


$query = "SELECT pageStats.user, pageStats.page, pageStats.date, recent_visit.idNum
FROM pageViews pageStats
INNER JOIN (
    SELECT user, MAX(id) AS idNum, MAX(date) as latest_visit
    FROM pageViews
    GROUP BY user
) recent_visit ON pageStats.user = recent_visit.user AND pageStats.date= recent_visit.latest_visit
ORDER BY recent_visit.user DESC";

$filteredVisitData = query($query);


$query = "SELECT post_title, COUNT(*) as times_visited from post_views GROUP BY post_title ORDER by times_visited DESC";
$postData = query($query);


print_r($postData);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<canvas id="registeredUsers"></canvas>
<canvas id="postCount"></canvas>
<canvas id="postCountFiltered"></canvas>
<table id="pageViews"></table>
<script>
        const ctx = document.getElementById('registeredUsers').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: 'Number of Posts',
                datasets: [{
                    label: 'Number of Registered Users',
                    data: <?php echo $numberOfUsersJson; ?>, // Replace this data with your own
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Number of Registered Users', // Change the title here
                        font: {
                            size: 20
                        }
                    }
                }
            }
        });


        <?php if ($filteredCategoryData === null): ?>

        const ctx2 = document.getElementById('postCountFiltered').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: 'User Count',
                datasets: [{
                    label: 'Filtered Category Data',
                    data: <?php echo $numberOfPostsJson; ?>, // Replace this data with your own
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Number of Posts', // Change the title here
                        font: {
                            size: 20
                        }
                    }
                }
            }
        });
        <?php else: ?>
            const categories = <?php echo json_encode(array_column($filteredCategoryData, 'category')); ?>;
            const counts = <?php echo json_encode(array_column($filteredCategoryData, 'numberOfPosts')); ?>;

            const ctx3 = document.getElementById('postCountFiltered').getContext('2d');
            const myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Filtered Counts',
                    data: counts, // Replace this data with your own
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Number of Posts', // Change the title here
                        font: {
                            size: 20
                        }
                    }
                }
            }
        });
        <?php endif;?>


        
</script>

<button class="btn btn-success filter">Filter</button>
<button class="btn btn-success unfilter">Remove Filter</button>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Page</th>
            <th>Total Visits</th>
            <th>Link to Post</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filteredPageData as $row): ?>
            <tr>
                <td><?php echo $row['page']; ?></td>
                <td><?php echo $row['total_visits']; ?></td>
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<table class="table table-striped">
    <h2>Order of Most Recent Visits</h2>
    <thead>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>Page</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filteredVisitData as $row): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['page']; ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<table class="table table-striped">
    <h2>Most Popular Posts</h2>
    <thead>
        <tr>
            <th>Post</th>
            <th>Times Visited</th>
            <th>Post Link</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($postData as $row): ?>
            <tr>
                <td><?php echo $row['post_title']; ?></td>
                <td><?php echo $row['times_visited']; ?></td>
                <td><a href="https://localhost/requirements/AaronReganAhmed360/app/pages/post.php?slug=<?php echo $row['post_title']; ?>">View Post</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script>
document.querySelector('.filter').addEventListener('click', ()=> {
            const currentUrl = window.location.href;
            if(currentUrl == "<?= ROOT ?>pages/admin.php?section=adminViewReport&filter=filter") return;
            window.location.href = `<?= ROOT ?>pages/admin.php?section=adminViewReport&filter=filter`;

        })

document.querySelector('.unfilter').addEventListener('click', ()=> {
        const currentUrl = window.location.href;
        if(currentUrl == "<?= ROOT ?>pages/admin.php?section=adminViewReport") return;
        window.location.href = `<?= ROOT ?>pages/admin.php?section=adminViewReport`;

})

</script>