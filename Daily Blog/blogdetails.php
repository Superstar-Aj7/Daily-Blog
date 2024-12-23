
<?php

session_start();

if(!isset($_SESSION["user_id"])){
  header("location: mainprelog.php");
  exit();
}


      $user_id = $_SESSION["user_id"];
      $avatar = $_SESSION["avatar_url"];
      $username = $_SESSION["screen_name"];


       $post_id = $_GET["post_id"];


       try {
        $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        die("PDO Connect: " . $e->getMessage() . "\n<br />");
      }

      $query ="SELECT bp.post_id, bp.content AS post_content, bp.featured_image_url AS post_image, bp.date_created AS post_date, u.screen_name AS post_user_name,
       u.avatar_url AS post_user_avatar,count(c.comment_id) AS comment_count, c.comment_id, c.content AS comment_content, c.date_created AS comment_date, uc.screen_name AS comment_user_name,
       uc.avatar_url AS comment_user_avatar, SUM(CASE WHEN v.vote_type = 'upvote' THEN 1 ELSE 0 END) AS upvotes, SUM(CASE WHEN v.vote_type = 'downvote' THEN 1 ELSE 0 END) AS downvotes,
       SUM(CASE WHEN v.vote_type = 'upvote' THEN 1 ELSE 0 END) - SUM(CASE WHEN v.vote_type = 'downvote' THEN 1 ELSE 0 END) AS vote_score FROM BlogPosts bp LEFT JOIN Users u ON bp.user_id = u.user_id
       LEFT JOIN Comments c ON c.post_id = bp.post_id LEFT JOIN Users uc ON c.user_id = uc.user_id LEFT JOIN Votes v ON v.comment_id = c.comment_id WHERE bp.post_id = '$post_id' GROUP BY bp.post_id, c.comment_id
       ORDER BY vote_score DESC";

      $result = $db->query($query);
      $row = $result->fetch();

      $result2 = $db->query($query);
      $error = "";
      $errors2 = "";

      if (isset($_POST["submitted"]) && $_POST["submitted"]){


          if(!empty($content)){

            try {
              $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
              $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
              die("PDO Connect: " . $e->getMessage() . "\n<br />");
            }
             
  
            $q2 = "INSERT INTO Comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";
            $result = $db->query($q2);


            if(!$result){
              $error2 = "There was a problem inserting your comment";
            }else{
              $db = null;
              $query = null;

              }
              

          } else{
            $error = "Comment Cannot be Empty!";
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
            <img src="<?=$avatar?>" alt="Profile Photo" class="profile-photo">
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

      
      <section id="content" class="grid-item">
        <div class="blog-post">
          <div class="blog-post-header">
            <div class="blog-post-profile">
              <img src="<?=$row["post_user_avatar"] ?>" alt="Profile Photo">
              <span><?=$row["post_user_name"]?></span>
            </div>
            <div class="blog-post-date">
              <span><?=$row["post_date"]?></span>
            </div>
          </div>
          <div class="blog-post-content">
            <p><?= $row["post_content"]?></p>
          </div>
          <div class="blog-post-footer">
            <div class="blog-post-comments">
              <a href="#"><?=$row["comment_count"]?> comments</a>
            </div>
          </div>
           
          
          <!-- Comments Section -->
          <div class="comments-section">
            <h3>Comments</h3>
            <?php if($row["comment_count"] != 0){?>
            <?php while($row2 = $result2->fetch()){?>
            <div class="comment">
              <div class="comment-username"><?=$row["comment_user_name"]?></div>
              <div class="comment-date"><?=$row["comment_date"]?></div>
              <div class="comment-content"><?=$row["comment_content"]?></div>
              <div class="comment-votes">
                <button class="upvote-btn">  Upvotes (<a href="#" class="vote-link"><?=$row["upvotes"]?></a>)</button>
                <button class="downvote-btn"> Downvotes (<a href="#" class="vote-link"><?=$row["upvotes"]?></a>)</button>
              </div>
            </div>
            <?php
            }
              $db = null;
              $query = null;
              ?>
              <?php
              }?>
          </div>
  
          <!-- Comment Box -->
          <form id="blogdetails-form" method="post" action="blogdetails.php">
            <div class="comment-box">
              <textarea id="textArea_2" name="content" placeholder="Add a comment..."></textarea>
              <input type="hidden" name="submitted" value="1" />
              <div id="error-text-area2" class="error-text hidden">Comment can't be empty!</div>
              <div>Number of characters: <span id="newCount">0</span>/1000</div>
              <div class="bottom error-text hidden" id="newCount-error-message">LIMIT EXCEEDED</div>
              <button type="submit" class="comment-box">Post Comment</button>
            </div>
          </form>
        </div>
      </section>

      <!-- Right sidebar begins -->
      <aside id="right-sidebar" class="grid-item">
      </aside>
    </main>

    <!-- Footer begins -->
    <footer id="footer">
    </footer>
    <script src="js/blogDetailsEventRegistration.js"></script>
</body>
</html>