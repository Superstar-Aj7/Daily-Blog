

<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

// This variables will keep track of errors and form values
// we find while processing the form but we'll make them global
// so we can display POST results on the form when there's an error.
$errors = array();
$Match_error = array();
$email= "";
$username = "";
$dob = "";
$password = "";


    // Check whether the form was submitted
if (isset($_POST["submitted"]) && $_POST["submitted"]) 
{
    // If we got here through a POST submitted form, process the form

    // Collect and validate form inputs
    $email = test_input($_POST["email"]);
    $username = test_input($_POST["username"]);      
    $dob = test_input($_POST["dob"]);
    $password = test_input($_POST["password"]);
    
    // Form Field Regular Expressions
    
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^(?=.*[^a-zA-Z])[^\s]{6,20}$/";
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    
    // Validate the form inputs against their Regexes 
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email address";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
    }
    if (!preg_match($dobRegex, $dob)) {
        $errors["dob"] = "Invalid DOB";
    }


    $dateFormat = date("Y-m-d", strtotime($dob));


    try {
        $db = new PDO("mysql:host=localhost; dbname=aai493", "aai493", "Canelo7alvarez");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          } catch (PDOException $e) 
                 {
                    die("PDO Connect: " . $e->getMessage() . "\n<br />");
                 }

      $q1 = "SELECT email FROM Users WHERE email ='$email'";
      $result_1 = $db->query($q1);
      $match = $result_1->fetch();

      if($match)
      {
        $Match_error["email_exits"] = "Email already exists.";
      }

      $q2 = "SELECT screen_name FROM Users WHERE screen_name = '$username'";
      $result_2 = $db->query($q2);
      $match2 = $result_2->fetch();

      if ($match2) {
        $Match_error["username_exists"] = "Username already exists.";
    }

            if(empty($errors)&& empty($Match_error))
            {
                $target_dir = "uploads/";
                $imageFileType = strtolower(pathinfo($_FILES["profile-photo"]["name"],PATHINFO_EXTENSION));
                $uid =uniqid();
                $target_file = $target_dir . $uid . "." . $imageFileType;

                if ($_FILES["profile-photo"]["size"] > 1000000)
                 {
                    $errors["pic_too_large"] = "File is too large. Maximum 1MB. "; 
                }

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    $errors["invalid_pic_type"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                    
                }

                        if(empty($errors))
                        {
                            $filestatus = move_uploaded_file($_FILES["profile-photo"]["tmp_name"], $target_file);

                            if($filestatus)
                            {
                                $query = "INSERT INTO Users (email, screen_name, password_hash, date_of_birth, avatar_url) 
                                VALUES ('$email', '$username', '$password', '$dateFormat', '$target_file')";
                                $result = $db->exec($query);

                                        if($result)
                                        {
                                            $db = null;
                                            $query = null;
                                            header("Location: mainprelog.php");
                                            exit();
                                            
                                        } else{
                                             $errors["insert_error"] = "Error uploading user info";
                                           }

                            } else{
                                    $errors["Moved_file"] = "File could not be uploaded.";
                                   }

                            
                        }
            }
    


}
 // submit method was POST
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/eventHandler.js"></script>
</head>
<body>
    
    <div class="signup-container">
        <h1>DailyBlog</h1>
        <h2>Create your account</h2>
        <form  id="signup-form" action="signup.php" method="post" enctype="multipart/form-data">
            <!--Form Begins-->
            <div class="input-group">
                <input type="hidden" name="submitted" value="1" />
                <label for="email"><b>Email</label>
                <input type="email" name="email" id="email">
                <span id="error-text-email" class="error-text hidden"> Invalid Email Address</span>
                <?php
                if (isset($Match_error["email_exits"])) {
                    echo "<span class='error-text'>" . htmlspecialchars($Match_error["email_exits"]) . "</span>";
                }?>
                
            </div>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
                <span id="error-text-username" class="error-text hidden">Invalid Username, no spaces, no special characters</span>
                <?php
                if (isset($Match_error["username_exists"])) {
                    echo "<span class='error-text'>" . htmlspecialchars($Match_error["username_exists"]) . "</span>";
                }
                ?>

            </div>
            <div class="input-group">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" id="dob" />
                <span id="error-text-dob" class="error-text hidden">Invalid Dob</span>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <span id="error-text-pwd" class="error-text hidden"> Invalid password,at least 6 characters long, no spaces,at least one non-letter character.</span>
            </div>
            <div class="input-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password">
                <span id="error-text-cpwd" class="error-text hidden">Passwords don't match</span>
            </div>
            <div class="input-group">
                <label for="profile-photo">Profile Picture</label>
                <input type="file" accept="image/*" name="profile-photo" id="profile-photo" />
                <span id="error-text-pfp" class="error-text hidden">Invalid Profile Picture</span>
                <?php
              if (!empty($errors)) {
                foreach ($errors as $key => $message) {
                    echo "<span class='error-text'>" . htmlspecialchars($message) . "</span>";
                }
            }
              ?>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>
    <script src="js/signupEventRegistration.js"></script>
</body>
</html>