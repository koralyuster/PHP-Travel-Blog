<?php

include './connect.php';
include './functions/func.php';

session_start();

//check if the user connect:
if (!user_verify()) {
  header('location: login.php?auth=error');
  //stop running the code if there problem:
  exit;
}

$errors = [];

if (isset($_POST['submit'])) {
  $formValid = true;
  $title = filter_post("title", $conn);
  $article = filter_post("article", $conn);
  $img = filter_post("img", $conn);

  if (strlen($title) < 2) {
    $formValid = false;
    $errors['title'] = 'Enter valid title, min 2 characters';
  }

  if (strlen($article) < 10) {
    $formValid = false;
    $errors['article'] = 'Post should be at least 10 characters';
  }

  if ($formValid) {
    $query = "INSERT INTO posts (title,article,img, user_id) VALUES ('{$title}', '{$article}', '{$img}', '{$_SESSION["user_id"]}')";
    $result = $conn->query($query);

    //check if we got id:
    if ($conn->insert_id > 0) {
      header("location: myPosts.php?msg=Post added successfully");
    } else {
      $errors['general'] = 'There is a problem, try again please';
    }
  }
}

?>


<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>

<main class="container-fluid" style="min-height:90vh">
  <div class="container">
    <h1>Add new post</h1>

    <h3 class="text-danger">
      <?= isset($errors['general']) ? $errors['general'] : "" ?>
    </h3>

    <form method="POST" class="col-lg-6 p-3">

      <div>
        <label>Title:</label>
        <input value="<?= old('title') ?>" class="form-control" type="text" name="title">
        <small class="text-danger">
          <?= isset($errors['title']) ? $errors['title'] : ""; ?>
        </small>
      </div>

      <div>
        <label>Text:</label>
        <textarea class="form-control" type="text" name="article" style="height:15rem"><?= old('article') ?></textarea>
        <small class="text-danger">
          <?= isset($errors['article']) ? $errors['article'] : ""; ?>
        </small>
      </div>

      <div>
        <label>Image:</label>
        <input value="<?= old('img') ?>" class="form-control" type="text" name="img">
        <small class="text-danger">
          <?= isset($errors['img']) ? $errors['img'] : ""; ?>
        </small>
      </div>

      <div class="d-flex justify-content-between">
        <a href="myPosts.php" class="btn btn-dark mt-3">Back</a>

        <button name="submit" class="btn btn-primary mt-3">Add new post</button>
      </div>


    </form>

  </div>
</main>

<?php include "./template_html/footer.php"; ?>
<?php include "./template_html/footer_body.php"; ?>