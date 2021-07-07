<?php

include './connect.php';
include './functions/func.php';

session_start();

if(!user_verify()){
  header('location: login.php?auth=error');
  exit;
}

if( isset($_GET['delId'])){
  $delId = filter_get('delId', $conn);
  $query = "DELETE FROM posts WHERE id = {$delId} AND user_id = {$_SESSION['user_id']}";
  $result = $conn->query($query);

  if($result && mysqli_affected_rows($conn)){
    header('location: myPosts.php?msg=Post Deleted');
  } else {
    header('location: myPosts.php?msg=Error! Post not deleted');
  }
}
