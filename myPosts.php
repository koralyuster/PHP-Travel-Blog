<?php

include './connect.php';
include './functions/func.php';

session_start();

//if the user not verify we send him to login page:
if (!user_verify()) {
  header('location:login.php?auth=error');
  //stop the code and not keep running:
  exit;
}

//if the user_id that in the sql = to the user_id in the session:
//brings out the rows of the records user by the session:
$query = "SELECT * FROM posts WHERE user_id = {$_SESSION['user_id']}";
$result = $conn->query($query);

$ar = [];
while ($row = mysqli_fetch_assoc($result)) {
  array_push($ar, $row);
}
//check:
// echo "<pre>";
// print_r($ar);
// echo "</pre>";

?>

<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>
<main class="container-fluid" style="min-height:90vh">
  <div class="container p-4">
    <h1>My Posts</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, omnis.</p>

    <h3 class="text-success">
      <?= isset($_GET['msg']) ? filter_get("msg", $conn) : ""; ?>
    </h3>

    <a href="addPost.php" class="btn btn-primary">Add new post</a>

    <table class="table table-striped">
      <div class="table-responsive">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>article</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ar as $item) : ?>
            <tr>
              <td><?= $item["id"] ?></td>
              <td><?= $item["title"] ?></td>
              <td><?= $item["article"] ?></td>
              <td>
                <a href="editPost.php?editId=<?= $item['id'] ?>" class="badge bg-dark">Edit</a>
              </td>
              <td>
                <a href="#" onclick="delPost(<?= $item['id'] ?>)" class="badge bg-danger">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </div>
    </table>

  </div>
</main>
<?php include "./template_html/footer.php"; ?>
<script>
  const delPost = (_id) => {
    if (confirm("Are you sure you want to delete the post?")) {
      window.location.href = "deletePost.php?delId=" + _id;
    }
  }
</script>
<?php include "./template_html/footer_body.php"; ?>