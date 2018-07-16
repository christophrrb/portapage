<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $folder_id = $_REQUEST['folderid'];

  $pictures_sql = <<<SQL
    SELECT * FROM pictures WHERE folder_id = $folder_id;
SQL;

  $pictures_result = $conn->query($pictures_sql);

  if ($pictures_result) {
    if ($pictures_result->num_rows > 0) {
      while ($row = $pictures_result->fetch_assoc()) {
        $image = base64_encode($row['picture']);
        $thumbnail = "
          <div class='row'>
            <div class='col-xs-6 col-md-3'>
              <a href='#' class='thumbnail'></a>
              <img src='data:image/jpeg;base64,$image' alt='". $row['name'] ."' style='max-width: 500px'; border-radius: 50%;'>
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
