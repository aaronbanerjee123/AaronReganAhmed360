<?php
session_start();

$errors = [];
include __DIR__ . '/../core/init.php';



if (!empty($_POST)) {
    // Your PHP login logic here
    // I'm assuming you have the necessary functions like `query`, `authenticate`, and `redirect_admin` defined elsewhere
    
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $row = query($query, ['email' => $_POST['email']]);

    if ($row) {
        if (password_verify($_POST['password'], $row[0]['password'])) {
          
            authenticate($row);
            // redirect_home();
            header("location: ../pages/home.php");
        } else {
            $errors['email'] = "Wrong email or password";
        }
    } else {
        $errors['email'] = "Wrong email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InsightInk - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
      background-color: #FFEBE7;
    }

    .container {
      margin-top: 5rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-control {
      border-radius: 0.5rem;
    }

    .btn {
      border-radius: 0.5rem;
    }

    .text-danger {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 5px;
    }

    .text-muted {
      color: #6c757d;
      font-size: 0.875rem;
      margin-top: 10px;
    }

    .text-center a {
      text-decoration: none;
    }

    .text-center a:hover {
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center"><a href="<?=ROOT?>pages/home.php">InsightInk</a></h1>
    <h2 class="text-center">Please sign in</h2>
    <form method="post">
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
        <?php if (!empty($errors['email'])): ?>
          <small class="text-danger"><?php echo $errors['email']; ?></small>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="text-center">
        Don't have an account? <a href="<?= ROOT ?>pages/signup.php">Signup here</a>
      </div>
      <button type="submit" class="btn btn-info btn-block">Sign in</button>
    </form>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
