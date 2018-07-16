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
      echo $row['folder_id'];
      /*TODO Find out how this works.*/
      $folder_thumbnail = "
        <div class='row'>
          <div class='col-sm-6 col-md-4'>
            <div class='thumbnail'>
              <img src='...' alt='...'>
              <div class='caption'>
                <a href='folder.php?folderid=" . $row['folder_id'] ."'>" . $row['name'] . "</a>
                <p>...</p>
                <p><a>This may be removed</a>
              </div>
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
