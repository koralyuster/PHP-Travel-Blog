<?php

// we write it because we call session in the second time:
//if session success or not:
if (session_id() == '') {
  session_start();
}

include_once './functions/func.php';
$user = user_verify();

?>

<header class="container-fluid  bg-dark p-2 shadow">
  <div class="container bg-dark text-white">
    <div class="row align-items-center">
      <nav class="col-lg-6 logo">
        <a href="index.php" class="text-white me-2">Home</a>
        <a href="about.php" class="text-white me-2">About</a>
        <a href="blog.php" class="text-white me-2">Blog</a>
      </nav>
      <nav class="col-lg-6 text-end">
        <?php if ($user) : ?>
          <span>Welcome <?= $_SESSION['user_name'] ?> | </span>
          <a href="myPosts.php" class="text-white me-2">Your Posts</a>
          <a href="logout.php" class="text-danger me-2">Logout</a>
          <!-- img profil will be here -->
        <?php endif; ?>
        <?php if (!$user) : ?>
          <a href="signup.php" class="text-white me-2">Sign up</a>
          <a href="login.php" class="text-white me-2">login</a>
        <?php endif; ?>
      </nav>
    </div>
  </div>
</header>