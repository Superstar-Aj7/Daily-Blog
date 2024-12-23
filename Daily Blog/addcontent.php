<?php
session_start();

if(!isset($_SESSION["user_id"])){
  header("location: mainprelog.php");
  exit();
}
    else
    {

      $user_id = $_SESSION["user_id"];
      $avatar = $_SESSION["avatar_url"];
      $username = $_SESSION["screen_name"];
      $error ="";
      $errors =  array();
      
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); //encodes
        return $data;
         }

            if (isset($_POST["submitted"]) && $_POST["submitted"])
            {
              
              $post_content = $_POST["post_content"];
              $featured_image = $_FILES["featured_image"];
              $errors = array();
            
            
              if(strlen($post_content)!= 0)
              {
                $post_content = test_input($post_content);
          
                $target_dir = "featured_image/";
                $imageFileType = strtolower(pathinfo($_FILES["featured_image"]["name"],PATHINFO_EXTENSION));
                $uid =uniqid();
                $target_file = $target_dir . $uid . "." . $imageFileType;
                 
                  if ($_FILES["featured_image"]["size"] == 0)
                  {
                    try {
                      $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
                      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        } catch (PDOException $e) 
                               {
                                  die("PDO Connect: " . $e->getMessage() . "\n<br />");
                               }

                               $query = "INSERT INTO BlogPosts (user_id, content) VALUES($user_id,'$post_content')";
                               $result = $db->exec($query);

                               if($result)
                               {
                                 $db = null;
                                 $results = null;
                                 header("location: blogmanagement.php");
                                 exit();
                               }else
                                   { 
                                     $errors["Post_error_image"] = "Unable to upload post";
           
                                    }
                     

                  }  else
                  {
                    if ($_FILES["featured_image"]["size"] > 1000000) 
                    {
                      $errors["Too_large"] = "File is too large. Maximum 1MB. ";
                    }
          
                  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
                    {
                     $errors["Invalid_image"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                    }
    
                    if(count($errors) == 0)
                    {
                      $filestatus = move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file);
    
                      if($filestatus)
                      { 
                        try {
                          $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
                          $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                            } catch (PDOException $e) 
                                   {
                                      die("PDO Connect: " . $e->getMessage() . "\n<br />");
                                   }
                           
                        $query = "INSERT INTO BlogPosts (user_id, content, featured_image_url) VALUES($user_id,'$post_content','$target_file')";
                        $result = $db->exec($query);
    
                        if($result)
                        {
                          $db = null;
                          $results = null;
                          header("location: blogmanagement.php");
                          exit();
                        }else
                            { 
                              $errors["Post_error_image"] = "Unable to upload post";
    
                             }
    
                      } else
                          {
                            $errors["Upload_error"] = "There was a problem uploading your image";
                          }
                    }
                  }

              } else
                  {
                    $error = "You must enter a post content.";
                  }








            } 
          

    }



?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blog Website</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/eventHandler.js"></script>
</head>
<body>
    <!--Header begins-->
    <header id="header">
        <div class="container">
          <nav>
            <ul>
              <li><h1>DailyBlog</h1></li>
            </ul>
          </nav>
          <div class="profile-container">
            <img src="<?=$avatar?>"  class="profile-photo">
            <span class="profile-name"><?=$username?></span>
            <a href="Logout.php">
            <button class="logout-btn">Logout</button>
            </a>
          </div>
        </div>
    </header>

    <!-- Grid begins -->
    <main id="main-grid">
      <!-- Left sidebar begins-->
      <aside id="left-sidebar" class="grid-item">
        <a href="main.php">
        <button>Home</button>
        </a>
        <a href="blogmanagement.php">
        <button>Manage Post</button>
        </a>
        <a href="addcontent.php">
        <button>Create Post</button>
        </a>
        <div style="margin-top: auto;">
          <a href="#">Contact us</a>
        </div>
      </aside>

      <!--Content section begins-->
      <section id="content" class="grid-item">
        <div class="search-bar">
          <input type="text" placeholder="Search...">
          <button>Search</button>
        </div>
        <div class="create-post">
          <form id="addcontent-form" method="post" action="addcontent.php" enctype="multipart/form-data">
            <input type="hidden" name="submitted" value="1" />
            <textarea  class="textarea"  id="textArea" name="post_content" placeholder="Type message"></textarea>
            <div  id="error-text-addcontent" class="error-text hidden">Post cannot be Empty!</div>
            <div>Number of characters: <span id="count">0</span>/2000</div> <div id="count-error-message" class="error-text bottom hidden">LIMIT EXCEEDED</div>
            <div class="error-text"><?=$error?></div>
           <?php
           if (isset($errors) && count($errors) > 0) {
               foreach ($errors as $key => $message) {
                   ?>
                   <div class="error-text"><?= htmlspecialchars($message) ?></div>
                   <?php
               }
           }
           ?>

            <button class="post-button" type="submit"style="float: right">Post</button>
            <label for="add-image" class="add-image-button">+</label>
            <input type="file" name="featured_image" id="add-image">
            </form>
        </div>
        
        
      <!-- Right sidebar begins -->
      <aside id="right-sidebar" class="grid-item">
      </aside>
    </main>

    <!-- Footer begins -->
    <footer id="footer">
    </footer>
    <script src="js/addContentEventRegistration.js"></script>
</body>
</html>
