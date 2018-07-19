<?php
  $folder_name = $_REQUEST['foldername'];
  $page_title = $folder_name;
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $user_id = $_SESSION['user_id'];
  $folder_id = $_REQUEST['folderid'];

  $pictures_sql = <<<SQL
    SELECT * FROM pictures WHERE folder_id = $folder_id and user_id = $user_id;
SQL;

  $pictures_result = $conn->query($pictures_sql);

  if ($pictures_result) {
    if ($pictures_result->num_rows > 0) {
      while ($row = $pictures_result->fetch_assoc()) {
        $image = base64_encode($row['picture']);
        $image_name = $row['name'];
        $image_id = $row['picture_id'];
        $exif = exif_read_data("data://image/jpeg;base64," . base64_encode($row['picture']));
        // echo $exif['Orientation'];

        // Image Orientation from EXIF Data
        if ($exif['Orientation'] == 6) {
          $orientation = "90deg";
        } else {
          $orientation = "0deg";
        }

        $thumbnail = "
          <div class='row' style='padding: 50px;'>
            <div class='col-xs-6 col-md-3'>
              <a href='/portapage/picture.php?pictureid=$image_id&folderid=$folder_id&foldername=$folder_name' class='thumbnail'>
                <img src='data:image/jpeg;base64,$image' alt='". $row['name'] ."' style='max-width: 500px; border-radius: 5%; transform: rotate($orientation);'>
              </a>
              $image_name <br>
              <a href='index.php?action=deleteimage&pictureid=$image_id&folderid=$folder_id&foldername=$folder_name'>Delete</a>
            </div>
          </div><br>
        ";
        echo $thumbnail;
      }
    }
  } else {
    echo $pictures_sql;
    mysqli_error($conn);
  }
?>
