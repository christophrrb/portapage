<?php
  $page_title = "Create a Folder";
  include_once $_SERVER['DOCUMENT_ROOT'] . '/portapage/web-assets/tpl/app_header.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/portapage/web-assets/tpl/app_nav.php';
?>

<div class="col-md-2"></div>
<div class="col-md-8">
  <div class="card">
    <div class="card-header">Create a Folder</div>
    <div class="card-body">
      <form action="/portapage/index.php?action=createfolder" method="post">
        <!-- Folder Name -->
        <div class="form-group row">
          <label for="folder-name" class="col-md-4">Folder Name</label>
          <input type="text" name="folder-name" id="folder-name" class="col-md-8">
        </div>
        <!-- Submit -->
        <div class="form-group row">
          <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="col-md-2"></div>
