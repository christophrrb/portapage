<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  $user_id = $_SESSION['user_id'];
  $folder_name = $_REQUEST['foldername'];
  $picture_id = $_REQUEST['pictureid'];
  $folder_id = $_REQUEST['folderid'];

  $pictures_sql = <<<SQL
    SELECT * FROM pictures WHERE folder_id = $folder_id and user_id = $user_id;
SQL;

  $picture_result = $conn->query($pictures_sql);

  //Go-back-to-folder link
  $folder_id = $_REQUEST['folderid'];
  echo "<a href='/portapage/folder.php?folderid=$folder_id&foldername=$folder_name'>Go back to $folder_name</a><br><br>";

  $picture_value_increment = 0;
  $continue_increment = true;

  //Picture Array
  echo "<script> var pictures = []; var picture_names = []; </script>";

  if ($picture_result) {
    while ($row = $picture_result->fetch_assoc()) {
      $max = $picture_result->num_rows;
      echo "<script> var max = $max; </script>";
      $image = "\"" . base64_encode($row['picture']) . "\"";
      $image_name = "\"" . $row['name'] . "\"";

      echo "<script> pictures.push($image); picture_names.push($image_name); </script>";

      //Set slider value
      if ($row['picture_id'] == $picture_id && $continue_increment) {
        echo "<script> var picture_value = $picture_value_increment; </script>";
        $continue_increment = false;
      } else {
        $picture_value_increment++;
      }

      //Echo Image
      // echo
      // "<div class='card'
      //   <img class='card-img-top' src='data:image/jpeg;base64, $image' alt'$image_name' style='max-width: 100%'>
      //   <div class='card-body'>
      //     <p class='card-text'>$image_name</p>
      //   </div>
      // </div>
      // ";
    } //End of While Loop
  } else {
    mysqli_error($conn);
  }
?>

<div class='card'>
   <img class='card-img-top' alt='$image_name' style='max-width: 100%' id="image-card">
   <div class='card-body'>
     <p class='card-text' id="card-text"></p>
   </div>
 </div>

<input type='range' min='1' class='slider' id='picture-slider'>

<script>
  document.getElementById("picture-slider").setAttribute("max", max);

  document.getElementById("image-card").setAttribute("src", "data:image/jpeg;base64," + (pictures[picture_value]));
  document.getElementById("card-text").innerHTML = picture_names[picture_value];
</script>
