<?php
  $page_title = "Dashboard";
  include_once $_SERVER['DOCUMENT_ROOT'] . '/portapage/web-assets/tpl/app_header.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/portapage/web-assets/tpl/app_nav.php';

  //Session Variables
  $user_id = $_SESSION['user_id'];
  $email = $_SESSION['email'];

  $folder_sql = <<<SQL
    SELECT * FROM folders WHERE user_id = $user_id;
SQL;

  $folder_result = $conn->query($folder_sql);

  if ($folder_result->num_rows > 0) {
    while ($row = $folder_result->fetch_assoc()) {
      $folder_id = $row['folder_id'];
      $folder_name = $row['name'];

      //Cover Image
      $cover_image_sql = <<<SQL
      SELECT picture FROM pictures WHERE folder_id = $folder_id LIMIT 1;
SQL;
      $cover_image_result = $conn->query($cover_image_sql);
      $cover_image_row = $cover_image_result->fetch_assoc();
      $cover_image = base64_encode($cover_image_row['picture']);

      /*TODO Find out how this works.*/
      $folder_thumbnail = "
        <div class='row'>
          <div class='col-sm-6 col-md-4'>
            <div class='thumbnail'>
              <a href='folder.php?folderid=$folder_id&foldername=$folder_name'>
                <img src='data:image/jpeg;base64, $cover_image' alt='". $row['name'] ."' style='max-width: 200px;'>
                <div class='". $row['name'] . "'>
                $folder_name
              </a>
              <p>...</p>
            </div>
          </div>
        </div>
      ";
      echo $folder_thumbnail;
    }
  } else {
    echo "<div class='alert alert-primary' role='alert'>You have no folders. Try creating one!</div>";
  }
?>
