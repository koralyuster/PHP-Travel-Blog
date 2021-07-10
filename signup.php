<?php

include "./connect.php";
include "./functions/func.php";

$errors = [];

if (isset($_POST['submit'])) {
  $formValid = true;
  $name = filter_post("name", $conn);
  //if the email invalid will return back null to the variable
  //FILTER_VALIDATE_EMAIL-> check if the info is valid email address
  $email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
  $password = filter_post("password", $conn);

  //Check the name is at least 2 chars:
  if (strlen($name) < 2) {
    $formValid = false;
    $errors["name"] = "* Enter Valid Name, Min 2 Chars";
  }

  //Check if the email is valid:
  if (!$email) {
    $formValid = false;
    $errors["email"] = "* Enter Valid Email";
  }

  //Check if the password length is bigger than 3:
  if (strlen($password) < 3) {
    $formValid = false;
    $errors["password"] = "* Enter Valid Password, Min 3 Chars";
  }

  if (isset($_FILES['myFile']) && $_FILES['myFile']['error'] == 0) {
    $max_file_size = 5 * 1024 * 1024;
    if ($_FILES['myFile']['size'] > $max_file_size) {
      $formValid = false;
      $error['file_max'] = '* File too big, maximum 5 mb.';
    }
    $ex = ['png', 'jpg', 'gif', 'svg', 'jpeg'];
    $fileInfo = pathinfo($_FILES['myFile']['name']);
    if (!in_array(strtolower($fileInfo['extension']), $ex)) {
      $formValid = false;
      $errors['file_type'] = '* File must be picture like, jpg, png, gif or svg';
    }
  }
}

if ($formValid) {
  //Password encryption:
  $password = password_hash($password, PASSWORD_BCRYPT);

  $query = "INSERT INTO users(name,email,password) VALUES('{$name}','{$email}','{$password}')";
  $result = $conn->query($query);
  if ($conn->insert_id > 0) {
    echo "success";

    //upload file:
    if (isset($_FILES['myFile']) && $_FILES['myFile']['error'] == 0) {
      $fileInfo = pathinfo($_FILES['myFile']['name']);
      //to connect the id to the user_id veribale:
      $user_id = $conn->insert_id;
      //connect file: 
      $fileName = "user_images/" . $user_id . "." . $fileInfo['extension'];
      move_uploaded_file($_FILES['myFile']['tmp_name'], $fileName);
      //update the table of the user:
      $query_edit = "UPDATE users SET img = '{$fileName}' WHERE id = '{$user_id}'";
      $result_edit = $conn->query($query_edit);
    }
    //msg=success-> will be write in the url also that signup success
    header("location: login.php?success=ok");
  } else {
    $errors["email2"] = "* Email is exist in system, try again or login.";
  }
}


?>

<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>

<main class="container-fluid" style="min-height:90vh">
  <div class="container p-4">
    <h1>Sign Up And Join Us Now!</h1>
    <p>join us and take part of post posts in our blog.</p>

    <form method="POST" class="col-lg-6 shadow-sm p-3" enctype="multipart/form-data">

      <div>
        <label>Name:</label>
        <input value="<?= old("name") ?>" type="text" name="name" class="form-control">
        <small class="text-danger">
          <?= isset($errors["name"]) ? $errors["name"] : "" ?>
        </small>
      </div>

      <div>
        <label>Email:</label>
        <input value="<?= old("email") ?>" type="email" name="email" class="form-control">
        <small class="text-danger">
          <?= isset($errors["email"]) ? $errors["email"] : ""; ?>
        </small>
        <small class="text-danger">
          <?= isset($errors["email2"]) ? $errors["email2"] : ""; ?>
        </small>
      </div>

      <div>
        <label>Password:</label>
        <input value="<?= old("password") ?>" type="password" name="password" class="form-control">
        <small class="text-danger">
          <?= isset($errors['password']) ? $errors['password'] : ''; ?>
        </small>
      </div>

      <div>
        <label>Your profile image(avater):</label>
        <input class="form-control" type="file" name="myFile">
        <small class="text-danger">
          <?= isset($errors['file_max']) ? $errors['file_max'] : ''; ?>
        </small>
        <small class="text-danger">
          <?= isset($errors['file_type']) ? $errors['file_type'] : ''; ?>
        </small>
      </div>

      <button name="submit" class="btn btn-success mt-3">Sign up</button>

    </form>
  </div>

  <?php include "./template_html/footer.php"; ?>
  <?php include "./template_html/footer_body.php"; ?>