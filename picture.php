<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $user_id = $_SESSION['user_id'];
  $folder_name = $_REQUEST['foldername'];

  $picture_id = $_REQUEST['pictureid'];

  $picture_sql = <<<SQL
    SELECT name, picture FROM pictures WHERE picture_id = $picture_id and user_id = $user_id;
SQL;

  $picture_result = $conn->query($picture_sql);

  //Go back to folder.
  $folder_id = $_REQUEST['folderid'];
  echo "<a href='/portapage/folder.php?folderid=$folder_id&foldername=$folder_name'>Go back to $folder_name</a><br><br>";

  if ($picture_result) {
    while ($row = $picture_result->fetch_assoc()) {
      $image = base64_encode($row['picture']);
      $image_name = $row['name'];

      echo "<img src='data:image/jpeg;base64, $image' alt'$image_name' style='max-width: 100%'>";
    }
  } else {
    mysqli_error($conn);
  }
?>
