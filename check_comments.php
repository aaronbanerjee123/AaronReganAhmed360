<?php

include '../core/init.php';
$post_id = $_GET['post_id'];
$last_date =$_GET['last_date'];

$query = "SELECT comments.*, users.username, comments.date as comment_date FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = :post_id AND comments.date > :date";
$comments = query($query, ['post_id' => $post_id, 'date' => $last_date]);

foreach ($comments as $key => $comment) {
    $comments[$key]['time_ago'] = time_elapsed_string($comment['comment_date']);
}

header('Content-Type: application/json');
echo json_encode($comments);

// $post_id = $_GET['post_id'];

// $query = "SELECT id from posts where slug=:slug";
// $row = query_row($query, ['slug'=> $slug]);


// $post_id = $row['post_id'];

// $query = "SELECT * from comments where post_id=:post_id";
// $new_comments = query($query,['post' =>$post_id]);

