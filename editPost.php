<?php

include './connect.php';
include './functions/func.php';

session_start();

//check if user connect:
if (!user_verify()) {
  header('location: login.php?auth=error');
  exit;
}

if (!isset($_GET['editId'])) {
  header('location: myPosts.php?msg=error');
}

$editId = filter_get("editId", $conn);
$query_select = "SELECT * FROM posts WHERE id = {$editId} AND user_id = {$_SESSION['user_id']}";
$result_select = $conn->query($query_select);
if (mysqli_num_rows($result_select) == 1) {
  $product = mysqli_fetch_assoc($result_select);
} else {
  header('location: myPosts.php?msg=error');
}

$errors = [];

if (isset($_POST['submit'])) {
  $formValid = true;
  $title = filter_post('title', $conn);
  $article = filter_post('article', $conn);
  $img = filter_post('img', $conn);

  if (strlen($title) < 2) {
    $formValid = false;
    $errors['title'] = 'Enter valid title, min 2 characters';
  }

  if (strlen($article) < 10) {
    $formValid = false;
    $errors['article'] = 'Post should be at least 10 characters';
  }

  if ($formValid) {
    $query = "UPDATE posts SET title = '{$title}', article = '{$article}', img = '{$img}' WHERE id={$editId} AND user_id = {$_SESSION['user_id']}";
    $result = $conn->query($query);

    //if we got id so success:
    if ($result && mysqli_affected_rows(($conn))) {
      header('location: myPosts.php?msg=Post added successfully');
    } else {
      $errors['general'] = 'There is a problem, try again please';
    }
  }

  // echo "<pre>";
  // print_r(mysqli_affected_rows(($conn)));
  // echo "</pre>";
}

?>

<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>

<main class="container-fluid" style="min-height:90vh">
  <div class="container">
    <h1>Edit post:</h1>

    <h3 class="text-danger">
      <?= isset($errors['general']) ? $errors['general'] : "" ?>
    </h3>

    <form method="POST" class="col-lg-6 p-3">

      <div>
        <label>Title:</label>
        <input value="<?= $product['title'] ?>" class="form-control" type="text" name="title">
        <small class="text-danger">
          <?= isset($errors['title']) ? $errors['title'] : ""; ?>
        </small>
      </div>

      <div>
        <label>Text:</label>
        <textarea class="form-control" name="article" style="height:15rem"><?= $product['article'] ?></textarea>
        <small class="text-danger">
          <?= isset($errors['article']) ? $errors['article'] : ""; ?>
        </small>
      </div>

      <div>
        <label>Image:</label>
        <input value="<?= $product['img'] ?>" class="form-control" type="text" name="img">
        <img src="<?= $product["img"] ?>" height="100">
        <small class="text-danger">
          <?= isset($errors['img']) ? $errors['img'] : ""; ?>
        </small>
      </div>

      <div class="d-flex justify-content-between">
        <a href="myPosts.php" class="btn btn-dark mt-3">Back</a>

        <button name="submit" class="btn btn-primary mt-3">Edit post</button>
      </div>


    </form>

  </div>
</main>

<?php include "./template_html/footer.php"; ?>
<?php include "./template_html/footer_body.php"; ?>