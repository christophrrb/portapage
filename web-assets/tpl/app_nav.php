<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/portapage/dashboard.php">Portapage</a>
  <a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" href="/bdpa-loans/index.php?action=logout"></a>

    <?php
      if (isset($_SESSION['user_id'])) {
        $navbar_options =
        "
          <form class='form-inline my-2 my-lg-0'>
            <a class='btn btn-secondary header-padding mx-4' href='/portapage/forms/upload_image.php'>File Upload</a>
            <a class='btn btn-secondary header-padding' href='/portapage/forms/create_new_folder.php'>Create New Folder</a>
            <a class='btn btn-secondary my-2 my-sm-0' href='/portapage/index.php?action=logout' style='position: absolute; right: 20px'>Logout
            <span class='glyphicon glyphicon-log-out'></span></a>
          </form>
        ";
        echo $navbar_options;
      }
    ?>
  </div>
</nav>
<div class="container">
  <br>
