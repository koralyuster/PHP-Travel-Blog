<?php

include './connect.php';
include './functions/func.php';

$user = user_verify();

$query = "SELECT * FROM posts LIMIT 0,4";
$result = $conn->query($query);

$ar = [];
while ($rows = mysqli_fetch_assoc($result)) {
  array_push($ar, $rows);
}
//check:
// echo "<pre>";
// print_r($ar);
// echo "</pre>";

?>

<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>
<main class="container-fluid" style="min-height:90vh">
  <div class="container text-center p-4">
    <h1>Big page title here!</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, omnis.</p>
    <?php if (!$user) : ?>
      <a href="singup.php" class="btn btn-primary">Join us</a>
    <?php endif; ?>
  </div>

  <div class="row">
    <?php foreach ($ar as $item) : ?>

      <div class="col-lg-3 p-2">
        <div class="card p-0 shadow-sm">
          <div style="float:right;  height:100px; 
            background-image:url(<?= strlen($item["img_url"]) > 4 ? $item["img_url"] : "https://cdn.pixabay.com/photo/2015/06/27/16/34/food-823607__340.jpg" ?>); background-size:cover; background-position:center;"></div>
          <div class="card-body">
            <h5 class="card-title"><?= $item['title']; ?></h5>
            <!-- להוסיף תקציר לכל פוסט -->
            <a href="#" class="btn btn-primary">Show post</a>
          </div>
        </div>
      </div>

    <?php endforeach; ?>
  </div>
</main>
<?php include "./template_html/footer.php"; ?>
<?php include "./template_html/footer_body.php"; ?>