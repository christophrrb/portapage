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

  //Card Deck
  echo "<div class='card-deck'>";


  if ($folder_result->num_rows > 0) {
    while ($row = $folder_result->fetch_assoc()) {
      $folder_id = $row['folder_id'];
      $folder_name = $row['name'];
      $folder_description = $row['description'];

      //Cover Image
      $cover_image_sql = <<<SQL
      SELECT picture FROM pictures WHERE folder_id = $folder_id LIMIT 1;
SQL;
      $cover_image_result = $conn->query($cover_image_sql);
      $cover_image_row = $cover_image_result->fetch_assoc();
      $cover_image = base64_encode($cover_image_row['picture']);

      if ($cover_image) { //If there is a cover image, load it on the website. If not, don't. The difference between the if code and the else code is that one is echoing an img tag (if) and one isn't (else).
        $folder_thumbnail = "
          <div class='card'>
            <a href='folder.php?folderid=$folder_id&foldername=$folder_name'>
              <img src='data:image/jpeg;base64, $cover_image' alt='". $row['name'] ."' class='card-img-top'>
              <div class='card-body'>
                <h4>$folder_name</h4>
                <p><i>$folder_description</i></p>
              </div>
            <a href='folder.php?folderid=$folder_id&foldername=$folder_name'>
          </div>

        ";
        echo $folder_thumbnail;
      } else {
        $folder_thumbnail = "
          <div class='card'>
            <a href='folder.php?folderid=$folder_id&foldername=$folder_name'>
              <div class='card-body'>
                <h4>$folder_name</h4>
                <p><i>$folder_description</i></p>
              </div>
            <a href='folder.php?folderid=$folder_id&foldername=$folder_name'>
          </div>

        ";
        echo $folder_thumbnail;
      }
    }
  } else {
    echo "<div class='alert alert-primary' role='alert'>You have no folders. Try creating one!</div>";
  }

  echo "</div>"
?>
