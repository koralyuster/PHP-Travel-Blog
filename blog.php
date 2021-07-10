<?php

include './connect.php';
//session_start();

$query_for_pages = "SELECT COUNT(*) as total FROM posts";
$result_pages = $conn->query($query_for_pages);
$total = mysqli_fetch_assoc($result_pages);

$per_page = 4;
$totalPages = ceil($total['total'] / $per_page);
$page = isset($_GET['page']) ? ($_GET['page'] - 1) * $per_page : 0;

$query = "SELECT * FROM posts LIMIT {$page},{$per_page}";
$result = $conn->query($query);

$ar = [];

while ($rows = mysqli_fetch_assoc($result)) {
  array_push($ar, $rows);
}

?>

<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>
<main class="container-fluid" style="min-height:90vh">
  <div class="container text-center p-4">
    <h1>Travel in Israel</h1>
  </div>

  <div class="row container-fluid">
    <?php foreach ($ar as $item) : ?>
      <div class="card mb-3">
        <div style="float:right;  height:220px; 
            background-image:url(<?= strlen($item["img"]) > 4 ? $item["img"] : "https://cdn.pixabay.com/photo/2015/06/27/16/34/food-823607__340.jpg" ?>); background-size:cover; background-position:center;"></div>
        <div class="card-body">
          <h5 class="card-title"><?= $item['title']; ?></h5>
          <p></p>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
          <div><?= $item['date_created']; ?></div>
          <a href="#" class="btn btn-primary">Show post</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>



  <div class="d-flex justify-content-center mb-3">
    <?php
    for ($i = 0; $i < $totalPages; $i++) :
    ?>
      <a href="blog.php?page=<?= $i + 1 ?>" class="ms-2 btn btn-light shadow-sm"><?= $i + 1 ?> </a>
    <?php endfor; ?>
  </div>

</main>
<?php include "./template_html/footer.php"; ?>
<?php include "./template_html/footer_body.php"; ?>