<?php
	// check to see if the form was submitted
	if (isset($_POST["submitted"]) && $_POST["submitted"]) {
		// get the username and password and check that they aren't empty
		$email = trim($_POST["email_2"]);
		$password = trim($_POST["pwd"]);
    $error = "";
    
		if (strlen($email) > 0 && strlen($password) > 0) {
	
			try {
        $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("PDO Connect: " . $e->getMessage() . "\n<br />");
    }
		  
			//verify the email/password
		  	$q = "SELECT user_id,screen_name, avatar_url FROM Users WHERE email = '$email' AND password_hash = '$password';";
		  	$result = $db->query($q);
		  
		  	if ($row = $result->fetch()) {
		  		// login successful
		  		session_start();
				$_SESSION["user_id"] = $row["user_id"];
				$_SESSION["avatar_url"] = $row["avatar_url"];
        $_SESSION["screen_name"] = $row["screen_name"];
				header("Location: main.php");
				$db = null;
				exit();
			} else {
				// login unsuccessful
				$error = ("The username/password combination was incorrect.");
				$db = null;
			}
		} else {
			$error = ("You must enter a non-blank username/password combination to login.");
		}
	} else {
		$error = "";
	}

?>

<?php

try {
  $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("PDO Connect: " . $e->getMessage() . "\n<br />");
}

   $query = "SELECT u.screen_name, u.avatar_url, p.content, p.featured_image_url, p.date_created, COUNT(c.comment_id) AS comment_count FROM BlogPosts AS p LEFT JOIN Comments AS c ON p.post_id = c.post_id INNER JOIN Users AS u ON p.user_id = u.user_id GROUP BY p.post_id, u.screen_name, u.avatar_url, p.content, p.featured_image_url, p.date_created ORDER BY p.date_created DESC LIMIT 5";
   $data = $db->query($query);
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
        </div>
    </header>

    <!-- Grid begins -->
    <main id="main-grid">
      <!-- Left sidebar begins-->
      <aside id="left-sidebar" class="grid-item">
        <a href="mainprelog.php">
        <button>Home</button>
        </a>
        <a href="#">
        <button>Manage Post</button>
        </a>
        <a href="#">
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
          
          <!-- Dynamic comment display -->
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
                <span><a href = "#"><?=$row["comment_count"]?> Comments</a></span>
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
        <div class="login-container">
        <form id="login-form" action="mainprelog.php" method="post">
        <input type="hidden" name="submitted" value="1" />
        <label for="email_2">Email:</label><br>
        <input type="text" id="email_2" name="email_2"><br/>
        <span id="error-text-mainprelog-username" class="error-text hidden">Invalid email</span>
        <label for="pwd">Password:</label><br>
        <input type="password" id="pwd" name="pwd"><br/>
        <span  id="error-text-mainprelog-password"class=" error-text hidden">Invalid Password</span><br/><br/>
        <span class=" error-text"><?=$error?></span><br/><br/>
        
        <input type="submit" value="Login">
        Dont have an account? <a href = "signup.php" >SignUp</a>
        </form>
        </div>
      </aside>
    </main>

    <!-- Footer begins -->
    <footer id="footer">
    </footer>
    <script src="js/mainPrelogEventRegistration.js"></script>
</body>
</html>
