<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $folder_sql = <<<SQL
?>

<div class="card">
  <div class="card-header">Upload Image</div>
  <div class="card-body">
    <form action="index.php?action=uploadimage" method="post" enctype="multipart/form-data">
      <!-- Image Name -->
      <label class="col-md-2 my-4" style="float: left;">Image Name</label>
      <input type="text" name="image-name" class="form-control col-md-10 my-4" style="float: right;">
      <!-- Folder -->
      <label class="col-md-2 my-4" style="float: left;">Image Name</label>
      <select class="form-control" name="folder-name">
        <?php
          while ($)
        ?>
      </select>
      <!-- Image -->
      <label for="upload" class="col-md-2" style="float: left;">Upload Image</label>
      <input type="file" name="image" class="form-control col-md-10" style="float:right;">
      <button type="submit" class="btn btn-primary my-3 col-md-3" style="float: right;">Submit</button>
    </form>
  </div>
