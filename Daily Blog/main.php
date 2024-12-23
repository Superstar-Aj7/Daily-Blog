<?php 

session_start();

if(!isset($_SESSION["user_id"])){
  header("location: mainprelog.php");
  exit();
}

  $user_id = $_SESSION["user_id"];
  $avatar = $_SESSION["avatar_url"];
  $username = $_SESSION["screen_name"];

  try {
    $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die("PDO Connect: " . $e->getMessage() . "\n<br />");
  }
  
     $query = "SELECT u.screen_name, u.avatar_url, p.post_id, p.content, p.featured_image_url, p.date_created, COUNT(c.comment_id) AS comment_count FROM BlogPosts AS p LEFT JOIN Comments AS c ON p.post_id = c.post_id INNER JOIN Users AS u ON p.user_id = u.user_id GROUP BY p.post_id, u.screen_name, u.avatar_url, p.content, p.featured_image_url, p.date_created ORDER BY p.date_created DESC LIMIT 20";
     $data = $db->query($query);

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <title>Blog Website</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
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

        <div class="posts">
          <div class="remaining-posts">Most recent posts:</div>
          
          <!-- Blog Post #1 -->
          <?php while($row = $data->fetch()){
            ?>
          <div class="blog-post">
            <div class="blog-post-header">
              <div class="blog-post-profile">
                <img src="<?=$row["avatar_url"]?>">
                <span><?=$row["screen_name"]?></span>
              </div>
              <div class="blog-post-date">
                <span><?=$row["date_created"]?></span>
              </div>
            </div>
            <div class="blog-post-content">
              <img src="<?=$row["featured_image_url"]?>" >
              <p><?=$row["content"]?></p>
            </div>
            <div class="blog-post-footer">
              <div class="blog-post-comments">
                <span><a href = "blogdetails.php?post_id=<?=$row["post_id"]?>"><?=$row["comment_count"]?> Comments</a></span>
              </div>
            </div>
          </div>
          <?php
           }
           $db = null;
           $data = null;
          
          ?>
        </div>
      </section>

      <!-- Right sidebar begins -->
      <aside id="right-sidebar" class="grid-item">
      </aside>
    </main>

    <!-- Footer begins -->
    <footer id="footer">
    </footer>
</body>
</html>
