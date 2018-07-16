<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'] . "/portapage/db.php";
  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

  switch ($action) {
    case 'signup':
      signup();
    break;

    case 'login':
      login();
    break;

    case 'createfolder':
      create_folder();
    break;

    case 'uploadimage':
      upload_image();
    break;

    case 'logout':
      logout();
    break;

    case 'deleteimage':
      delete_image();
    break;

    default:
      header("Location: forms/signup.php");
    break;
  }

  function signup() {
    global $conn;

    $email = $_REQUEST['email_id'];
    $pw = $_REQUEST['pw']; $pw = password_hash($pw, PASSWORD_DEFAULT);

    echo "Hi. ";

    //SQL Statements
    $sign_up_sql = <<<SQL
      INSERT INTO users(email, pw)
      VALUES("$email", "$pw");
SQL;

    $id_and_email_sql = <<<SQL
      SELECT user_id, email FROM users WHERE email = "$email";
SQL;

    //SQL Results
    $sign_up_result = $conn->query($sign_up_sql);
    $id_and_email_result = $conn->query($id_and_email_sql);

    if ($sign_up_result && $id_and_email_result) {
      while ($row=$id_and_email_result->fetch_assoc()) { //Get user_id.
        $_SESSION['user_id'] = $row['user_id'];
      }
      $_SESSION['email'] = $email;
      header("Location: dashboard.php");
    } else {
      echo "The data was not inserted into the database";
    }
  }

  function login() {
    global $conn;

    $email = $_REQUEST['email_id'];
    $pw = $_REQUEST['pw'];

    $user_sql = <<<SQL
      SELECT user_id, email, pw FROM users WHERE email = "$email";
SQL;

    $user_result = $conn->query($user_sql);

    if ($user_result) {

      //Get the user_id and password.
      while ($row=$user_result->fetch_assoc()) {
        $_SESSION['user_id'] = $row['user_id'];
        $hashed_pw = $row['pw'];
      }

      //Check to see if the passwords match.
      if (password_verify($pw, $hashed_pw)) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
      } else {
        echo "The passwords do not match.";
      }

    } else {
      echo '$user_result failed.';
    }
  }

  //Create Folder
  function create_folder() {
    global $conn;

    $folder_name = $_REQUEST['folder-name'];
    $user_id = $_SESSION['user_id'];

    $create_folder_sql = <<<SQL
      INSERT INTO folders(name, user_id)
      VALUES("$folder_name", $user_id);
SQL;

    $create_folder_result = $conn->query($create_folder_sql);

    if ($create_folder_result) {
      header("Location: dashboard.php");
    } else {
      echo "The folder wasn't created.";
      mysqli_error($conn);
    }
  }

  //Upload Image
  function upload_image() {
    global $conn;

    $user_id = $_SESSION['user_id'];
    $image_name = $_REQUEST['image-name'];
    $folder_id = $_REQUEST['folder-id'];
    $imagetmp = addslashes(file_get_contents($_FILES['image']['tmp_name']));

    $upload_sql = <<<SQL
      INSERT INTO pictures(folder_id, user_id, name, picture)
      VALUES($folder_id, $user_id, "$image_name", "$imagetmp");
SQL;

    $upload_result = $conn->query($upload_sql);

    if ($upload_result) {
      header("Location: dashboard.php");
    } else {
      echo mysqli_error($conn);
    }
  }

  //Delete Image
  function delete_image() {
    global $conn;

    $user_id = $_SESSION['user_id'];
    $picture_id = $_REQUEST['pictureid'];
    $folder_id = $_REQUEST['folderid'];

    $delete_image_sql = <<<SQL
      DELETE FROM pictures WHERE picture_id = $picture_id and user_id = $user_id;
SQL;

    $delete_image_result = $conn->query($delete_image_sql);

    if ($delete_image_result) {
      header("Location: folder.php?folderid=$folder_id&foldername=$folder_name");
    } else {
      echo $delete_image_sql;
      mysqli_error($conn);
    }
  }

  //Logout
  function logout() {
    session_unset();
    session_destroy();
    header("Location: forms/login.php");
  }
?>
