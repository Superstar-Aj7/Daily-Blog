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


   $q1 = "SELECT bp.post_id, bp.content AS post_content, bp.featured_image_url AS post_image, bp.date_created AS post_date, u.screen_name AS post_user_name,
    u.avatar_url AS post_user_avatar, COUNT(DISTINCT c.comment_id) AS comment_count, c.comment_id, c.content AS comment_content, c.date_created AS comment_date,
    uc.screen_name AS comment_user_name,uc.avatar_url AS comment_user_avatar, SUM(CASE WHEN v.vote_type = 'upvote' THEN 1 ELSE 0 END) AS upvotes, SUM(CASE WHEN v.vote_type = 'downvote' THEN 1 ELSE 0 END) AS downvotes
    FROM BlogPosts bp LEFT JOIN Users u ON bp.user_id = u.user_id LEFT JOIN Comments c ON c.post_id = bp.post_id LEFT JOIN Users uc ON c.user_id = uc.user_id
    LEFT JOIN Votes v ON v.comment_id = c.comment_id WHERE bp.user_id = '$user_id' GROUP BY bp.post_id, c.comment_id ORDER BY bp.date_created DESC, c.date_created ASC";


  $query= $db->query($q1);
  $results = $query->fetchAll();


 $currentPostId = null;
$posts = [];

foreach ($results as $row) {
    if ($currentPostId !== $row['post_id'])
     {
        $currentPostId = $row['post_id'];
        $posts[$currentPostId] = ['post_content' => $row['post_content'],'post_image' => $row['post_image'], 'post_date' => $row['post_date'],
            'post_user_name' => $row['post_user_name'], 'post_user_avatar' => $row['post_user_avatar'],'comments' => [], 'comment_count' => $row['comment_count'] ?? 0];
     }

      if (!empty($row['comment_id'])) 
      {
          $posts[$currentPostId]['comments'][] = ['comment_content' => $row['comment_content'], 'comment_date' => $row['comment_date'],'comment_user_name' => $row['comment_user_name'],'comment_user_avatar' => $row['comment_user_avatar'], 'upvotes' => $row['upvotes'],'downvotes' => $row['downvotes']];
      }
}
           $db = null;
           $q1 = null;


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

      <!--Content section begins-->
      <section id="content" class="grid-item">
        <div class="search-bar">
          <input type="text" placeholder="Search...">
          <button>Search</button>
        </div>

        <div class="profile-info">
            <img src="<?=$avatar?>" alt="Profile Photo" class="profile-photo">
            <span class="profile-name"><?=$username?></span>
        </div>

       <?php foreach ($posts as $post) {
    ?>
    <div class="blog-post">
        <div class="blog-post-header">
            <div class="blog-post-profile">
                <img src="<?=$post['post_user_avatar'] ?>" alt="Profile Picture" />
                <span class="profile-name"><span style="color:black"><?=$post['post_user_name']?><span></span>
            </div>
            <div class="blog-post-date">Posted on: <?= $post['post_date'] ?></div>
        </div>
        <div class="blog-post-content">
            <?php if ($post['post_image']){ ?>
                <img src="<?=$post['post_image'] ?>" alt="Blog Image" class="attached-image" />
            <?php }; ?>
            <p><?= $post['post_content'] ?></p>
        </div>
        <div class="blog-post-footer">
            <a href="blogdetails.php?post_id=<?=$row['post_id']?>" class="blog-post-comments"><?= $post['comment_count'] ?> Comments</a>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <h3>Comments</h3>
        <?php foreach ($post['comments'] as $comment){ ?>
            <div class="comment">
            <span class="comment-username"><?=$comment['comment_user_name'] ?></span>
            <span class="comment-date"><?= $comment['comment_date'] ?></span>
            <p class="comment-content"><?= $comment['comment_content'] ?></p>
            <div class="comment-votes">
                <button class="upvote-btn">
                    <a href="#" class="vote-link"><?= $comment['upvotes'] ?></a> Upvote
                </button>
                <button class="downvote-btn">
                    <a href="#" class="vote-link"><?= $comment['downvotes'] ?></a> Downvote
                </button>
            </div>
        </div>
        <?php } ?>
    </div>
    </div>
    <?php
}
?>


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