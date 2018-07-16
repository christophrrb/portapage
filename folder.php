<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $user_id = $_SESSION['user_id'];
  $folder_id = $_REQUEST['folderid'];
  $folder_name = $_REQUEST['foldername'];

  $pictures_sql = <<<SQL
    SELECT * FROM pictures WHERE folder_id = $folder_id and user_id = $user_id;
SQL;

  $pictures_result = $conn->query($pictures_sql);

  if ($pictures_result) {
    if ($pictures_result->num_rows > 0) {
      while ($row = $pictures_result->fetch_assoc()) {
        $image = base64_encode($row['picture']);
        $image_id = $row['picture_id'];
        $thumbnail = "
          <div class='row'>
            <div class='col-xs-6 col-md-3'>
              <a href='/portapage/picture.php?pictureid=$image_id&folderid=$folder_id&foldername=$folder_name' class='thumbnail'>
                <img src='data:image/jpeg;base64,$image' alt='". $row['name'] ."' style='max-width: 500px'; border-radius: 50%;'>
              </a>
            </div>" .
            $row['name']
          . "</div><br>
        ";
        echo $thumbnail;
      }
    }
  } else {
    echo mysqli_error($conn);
  }
?>
