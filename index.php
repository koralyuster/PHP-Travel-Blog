<?php

include './connect.php';
include './functions/func.php';
echo "<link rel='stylesheet' type='text/css' href='CSS/index.css'>";

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
  <div class="container-fluid d-flex justify-content-center align-items-center">
    <img src="./images/index-israel.jpeg" class=" imgHome" alt="...">
    <figcaption>
      Travel Around Israel
    </figcaption>
  </div>

  <div class="text-center mx-auth mt-3 mb-5">
    <p class="text-center mx-auto" style="font-size:1.2rem; width:65%">We started setting up this site a little before Covid-19 started.
      At first it was supposed to be a blog for trips all over the world, then a global epidemic broke out and we decided to give you the opportunity to share with each other amazing places in the Land of Israel.</p>
    <?php if (!$user) : ?>
      <a href="signup.php" class="btn btn-lg btn-primary">Sing up</a>
    <?php endif; ?>
  </div>



  <div class="text-center">

    <h3>What could you find here?</h3>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col">
        <div class="card">
          <img src="./images/Hiking.png" class="card-img-top mx-auto mt-2" style="width:20%;" alt="...">
          <div class="card-body">
            <h5 class="card-title">Hiking trails in Israel</h5>
            <p class="card-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. In voluptatibus molestias deserunt maiores molestiae quisquam perspiciatis aut quam reiciendis mollitia.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <img src="./images/reco.png" class="card-img-top mx-auto mt-2" style="width:20%;" alt="...">
          <div class="card-body">
            <h5 class="card-title">Recommendations</h5>
            <p class="card-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. In voluptatibus molestias deserunt maiores molestiae quisquam perspiciatis aut quam reiciendis mollitia.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <img src="./images/Tent.png" class="card-img-top mx-auto mt-2" style="width:20%;" alt="...">
          <div class="card-body">
            <h5 class="card-title">Accommodation in nature</h5>
            <p class="card-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. In voluptatibus molestias deserunt maiores molestiae quisquam perspiciatis aut quam reiciendis mollitia.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <img src="./images/location.png" class="card-img-top mx-auto mt-2" style="width:20%;" alt="...">
          <div class="card-body">
            <h5 class="card-title">Interesting stopping points</h5>
            <p class="card-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. In voluptatibus molestias deserunt maiores molestiae quisquam perspiciatis aut quam reiciendis mollitia.</p>
          </div>
        </div>
      </div>
    </div>

  </div>


  <div class="row mt-5">
    <h2 class="text-center">Recommended posts</h2>
    <?php foreach ($ar as $item) : ?>

      <div class="col-lg-3 p-2">
        <div class="card p-0 shadow-sm">
          <div style="float:right;  height:100px; 
            background-image:url(<?= strlen($item["img"]) > 4 ? $item["img"] : "https://cdn.pixabay.com/photo/2015/06/27/16/34/food-823607__340.jpg" ?>); background-size:cover; background-position:center;"></div>
          <div class="card-body">
            <h5 class="card-title"><?= $item['title']; ?></h5>
            <!-- להוסיף תקציר לכל פוסט -->
            <a href="#" class="btn btn-primary">Show post</a>
          </div>
        </div>
      </div>

    <?php endforeach; ?>
  </div>

  <div class="text-center mx-auto mt-3 mb-3">
    <a href="blog.php" class="btn btn-dark">View all</a>
  </div>

</main>
<?php include "./template_html/footer.php"; ?>
<?php include "./template_html/footer_body.php"; ?>