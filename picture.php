<?php
  $page_title = "Upload Image";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_header.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/web-assets/tpl/app_nav.php";

  //Get the user_id, folder_name, picture_id, and folder_id.
  $user_id = $_SESSION['user_id'];
  $folder_name = $_REQUEST['foldername'];
  $picture_id = $_REQUEST['pictureid'];
  $folder_id = $_REQUEST['folderid'];

  //Get the images from the database.
  $pictures_sql = <<<SQL
    SELECT * FROM pictures WHERE folder_id = $folder_id and user_id = $user_id;
SQL;

  $picture_result = $conn->query($pictures_sql);

  //Go-back-to-folder link
  $folder_id = $_REQUEST['folderid'];
  echo "<a href='/portapage/folder.php?folderid=$folder_id&foldername=$folder_name'>Go back to $folder_name</a><br><br>";

  //Picture value increment is used to find the picture index for the Javascript array. Continue increment is to continue incrementing picture_value_increment.
  $picture_value_increment = 0;
  $continue_increment = true;

  //Create Picture and Picture Name Array
  echo "<script> var pictures = []; var picture_names = []; </script>";

  if ($picture_result) { //If we have at least one picture
    while ($row = $picture_result->fetch_assoc()) {
      $max = $picture_result->num_rows; //This is the amount of pictures we have.
      echo "<script> var max = $max; </script>"; //This saves the amount of pictures we have to a Javascript variable called max.
      $image = "\"" . base64_encode($row['picture']) . "\""; //This takes the base64 encoding and places quotes around it (I guess these need to be strings for HTML to read it.).
      $image_name = "\"" . $row['name'] . "\""; //This places quotes around the image name.

      echo "<script> pictures.push($image); picture_names.push($image_name); </script>"; //This puts the picture and name of the picture in the Javascript array.

      //Set slider value
      if ($row['picture_id'] == $picture_id && $continue_increment) { //If the picture_id is equal to the one passed in from the URL and we haven't found a match between the two yet (the purpose of continue_increment), then put picture_value_increment in a Javascript variable named picture_value.
        echo "<script> var picture_value = $picture_value_increment; </script>";
        $continue_increment = false; //We've found a match, so don't increment anymore.
      } else {
        $picture_value_increment++; //We haven't found a match, so "increase the index" by 1.
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
    mysqli_error($conn); //Just in case there are errors. :)
  }
?>

<div class='card'>
   <img class='card-img-top' alt='$image_name' style='max-width: 100%' id="image-card">
   <div class='card-body'>
     <p class='card-text' id="card-text"></p>
   </div>
 </div>

<!-- Picture Slider -->
<br>
<center><input type='range' min='0' class='slider' id='picture-slider' class=''></center>

<script>
  var picture_slider = document.getElementById("picture-slider");

  picture_slider.setAttribute("max", (max - 1));
  picture_slider.setAttribute("value", picture_value);

  document.getElementById("image-card").setAttribute("src", "data:image/jpeg;base64," + (pictures[picture_value]));
  document.getElementById("card-text").innerHTML = picture_names[picture_value];

  picture_slider.oninput = function () {
    document.getElementById("image-card").setAttribute("src", "data:image/jpeg;base64," + (pictures[picture_slider.value]));
    document.getElementById("card-text").innerHTML = picture_names[picture_slider.value];
  }
</script>
