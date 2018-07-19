<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $user_id = $_SESSION['user_id'];

  $folder_sql = <<<SQL
    SELECT * FROM folders WHERE user_id = $user_id;
SQL;

  $folder_result = $conn->query($folder_sql);

  if (!$folder_result->num_rows > 0) {
    header("Location: create_new_folder.php");
  }
?>

<div class="card">
  <div class="card-header">Upload Image</div>
  <div class="card-body">
    <form action="/portapage/index.php?action=uploadimage" method="post" enctype="multipart/form-data">
      <!-- Image Name -->
      <label class="col-md-2 my-4" style="float: left;">Image Name</label>
      <input type="text" name="image-name" class="form-control col-md-10 my-4" style="float: right;">
      <!-- Folder -->
      <label class="col-md-2 my-4" style="float: left;">Folder</label>
      <select class="form-control col-md-10" style="float: right;" name="folder-id">
        <?php
          while ($row = $folder_result->fetch_assoc()) {
            echo "<option value=" . $row['folder_id'] . ">" . $row['name'] . "</option>";
          }
        ?>
      </select>
      <!-- Image -->
      <label for="upload" class="col-md-2" style="float: left;">Upload Image</label>
      <input type="file" name="image" class="form-control col-md-10" style="float:right;">
      <button type="submit" class="btn btn-primary my-3 col-md-3" style="float: right;">Submit</button>
    </form>
  </div>

  <!-- I had a problem with the file size, so I changed the max_allowed packet in my my.cnf file for SQL (/opt/lampp/etc/my.cnf) for mysqld and mysqldump. I then had the error that innodb_log_file_sizze was too small (This error: The size of BLOB/TEXT data inserted in one transaction is greater than 10% of redo log size. Increase the redo log size using innodb_log_file_size.) because innodb_log_file_size needs to be at greater than 10% of the largest BLOB size allowed by my database. I changed it to 100M, but in hindisght I probably should have changed it to some number above 160 because a MEDIUMBLOB can be up to 16M. -->
