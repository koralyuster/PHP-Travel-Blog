<?php

include './connect.php';
include './functions/func.php';

session_start();

$errors = [];

if (isset($_POST['submit'])) {
  $formValid = true;
  $email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
  $password = filter_post("password", $conn);

  //Check Email:
  if (!$email) {
    $formValid = false;
    $errors['email'] = "* Enter Valid Email";
  }

  //Check Password:
  if (strlen($password) < 3) {
    $formValid = false;
    $errors['password'] = "* Enter Valid Password, Min 3 Chars";
  }

  if ($formValid) {
    //check email == email sql:
    $query = "SELECT * FROM users WHERE email = '{$email}'";
    $result = $conn->query($query);

    //check if there is a email, at least 1 row:
    if (mysqli_num_rows($result) == 1) {
      //inside the $users i will keep the row that in the $result as an associative array:
      $user = mysqli_fetch_assoc($result);
      //check:
      //print_r($user);

      //password_verify()-> Verifies that a password matches a hash:
      //check password:
      // the first params (password), the seconds params its (password of user from the database)
      if (password_verify($password, $user['password'])) {
        echo 'success';
        //SESSION for the system recognize the user:
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        //keep the ip of user:
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        //keep the browser that the user login from:
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        header('location: myPosts.php');
      } else {
        //General error: code 1 - problem with the email:
        $errors['general'] = '* Email or password not match, code:2';
      }
    } else {
      //General error: code 1 - problem with the email:
      $errors['general'] = '* Email or password not match, code:1';
    }
  }
}

?>


<?php include "./template_html/tag_header.php"; ?>
<?php include "./template_html/header.php"; ?>
<main class="container-fluid" style="min-height:90vh">
  <div class="container p-4">
    <h1>Welcome Back! LOGIN</h1>

    <h3 class="text-danger">
      <?= isset($errors['general']) ? $errors['general'] : ""; ?>
    </h3>

    <!-- if we delete the session we will see this error
    auth -> from file-> myPosts.php -->
    <h3 class="text-danger">
      <?= isset($_GET['auth']) ? "Error: You need to be logged in" : "" ?>
    </h3>

    <!-- we will get this message only after the user signup successfully -->
    <h3 class="text-success">
      <?= isset($_GET['success']) ? "You signup successfully, now login." : ""; ?>
    </h3>

    <div class="mt-4">
      <form method="POST" class="col-lg-6 shadow p-3">
        <div>
          <lable>Email:</lable>
          <input type="email" name="email" class="form-control">
          <small class="text-danger">
            <?= isset($errors['email']) ? $errors['email'] : ""; ?>
          </small>
        </div>

        <div>
          <lable>Password:</lable>
          <input type="text" name="password" class="form-control">
          <small class="text-danger">
            <?= isset($errors['password']) ? $errors['password'] : ""; ?>
          </small>
        </div>

        <button name="submit" class=" btn btn-success mt-3">Sign in</button>

    </div>
    </form>
  </div>
  </div>
</main>
<?php include "./template_html/footer.php"; ?>
<?php include "./template_html/footer_body.php"; ?>