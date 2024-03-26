<?php
include '../../core/init.php';

if(!empty($_POST['id'])) {
    $query= "SELECT * from posts where id = :id limit 1";
    $result = query_row($query, ['id' => $_POST['id']]);
 
    
    
    // Check if there's a valid result
    if ($result) {
        // Extract data from the result
        $row = $result;
        // Build the HTML code using the retrieved data
        $htmlContent = '<div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <a href="' . ROOT . 'pages/post.php?slug=' . $row['slug'] . '">
                        <h3 class="mb-0">' . $row['title'] . '</h3>
                    </a>
                    <div class="mb-1 text-muted">' . date("Y-m-d", strtotime($row['date'])) . '</div>
                    <p class="card-text mb-auto">' . substr($row['content'], 0, 200) . '</p>
                    </div>
                    
                    <div class="col-lg-5 col-12 d-lg-block">
                        <img src="'. ROOT.'pages/'.$row['image'].'"class="bd-placeholder-img w-100" height="250" style="object-fit:cover;" />
                    </div>  
                </div>
            </div>';
        //Add edit button if the user is the owner of the post
      

        // Complete the HTML code
     
        // Return the HTML code
        echo $htmlContent;
    }
}
?>
