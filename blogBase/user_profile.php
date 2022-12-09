<?php
ob_start();
include 'logic.php';
require("db.php");
include('auth_profile.php');
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->


<html lang="eng">
    <head>
        <meta charset="utf-8"><!-- comment -->
        <meta name="viewport" content="width=device-width, intitial-scale=1.0">
        <title>Blog Base e-newspaper</title>
        <link rel="stylesheet" href="BBlog.css">
        <style>

        form {
            align-content: center;
            align-items: center;
            align-self: center;
        }

        label{
            font-size: 30px;
        }
        h6{
          font-size: 22px;
        }

        .form-input {

            border-radius: 25px;
            text-decoration: none;
            padding: 16px 32px;
            margin:4px 2px;
            cursor: pointer;
            width: 50%;
        }
        input[type=button], input[type=submit], input[type=reset]{
            background-color: black;
            color: white;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            padding: 16px 32px;
            margin:4px 2px;
            cursor: pointer;
            width: 50%;
        }
        </style>

    </head>

    <body>

      <nav class="flex-div">
          <div class="nav-left flex-div">
              <img class="menu-icon" src="menu_icon.png">
              <a href="index.php"><img src="logo1.png" class="logo" ></a>
          </div>
          <div class="nav-mid flex-div">
              <div class="search-box flex-div">
                <form action="search-proc.php" method="POST" id="searchForm">
            <input type="text/submiit" name="search" placeholder="search"/> <img src="search.png">
        </form>
              </div>
          </div><!-- comment -->
          <div class="nav-right flex-div">
              <a href="admin.php"><img src="admin_img.png"></a>
              <a href="graphDes.php"><img src="gd.png"></a>
              <a href="create.php"><img src="editor_img.png"></a>
              <a href="ad_design.php"><img src="ad.png"></a>
              <a href="user_profile.php"><img src="follow.png"></a>
              <a href="login.php" >Login</a><!-- comment -->
              <a href="register.php" style="padding: 10px 10px">Sign Up</a>
              <a href="logout.php">Logout</a>
          </div>
      </nav>

      <!--------------------- side bar --------------------->
      <div class="sidebar">
          <div class="shortcut-links">
              <a href="index.php"><img src="home.png"> Home </a></p>
              <a href="hot.php"><p><img src="hot.png"> Hot! </a></p>
              <a href="viewSaved.php"><p><img src="saved.png"> Saved </a></p>
              <a href="archived.php"><p><img src="history.png"> Archived </a></p>
              <hr>
          </div>
          <div class="Authors">
            <center>
              <p><a href="social.php">Social</a></p>
            </center>
              <?php
            
              if(isset($_SESSION["username"])){
                $loggedInUser = $_SESSION["username"];
                $getUserID = "SELECT userid FROM users WHERE username='$loggedInUser'";
                $loggedOn = $con->query($getUserID);
                if($loggedOn->num_rows > 0){
                  while($row = $loggedOn->fetch_assoc()){
                    $realUserID = $row["userid"];
                $followList = "SELECT username FROM users, social_follow WHERE username!='$loggedInUser' and follower_id='$realUserID' and follow_id=1 and followed_user_id=userid";
                $getFollowList = $con->query($followList);
                if($getFollowList->num_rows > 0){
                  while($row1 = $getFollowList->fetch_assoc()){

               ?>
                  <a href=""><p><img src="follow.png"><?php echo $row1["username"]; ?></a></p>
                <?php
              }
              }
              }
              }
            }else{
              ?>
              <center>
                <p>Not following anyone</p><br>
                <p>or</p><br>
                <p>Need to login</p>
              </center>
              <?php
            }
               ?>
          </div>
      </div>



        <center>
          <p><h1><?php echo $_SESSION['username'] ?>'s profile:<br></h1>
            <h3>Here you can make edits to your profile.</h3></p>
            <br>

          <?php
            $theUser = $_SESSION['username'];
            $mainSql = "SELECT username, fname, lname, email FROM users WHERE username='$theUser'";
            $mainResult = $con->query($mainSql);
            if($mainResult->num_rows > 0){
              while($row = $mainResult->fetch_assoc()){

              ?>
              <center>
                  <form class=" align-items-center justify-content-center" action="" method="post">
                      <div class="form-group">
                          <label for="username">Username:</label><br>
                          <h6>Current Username: <?php echo "" . $row['username'] . ""; ?></h6><br>
                      </div>
                  </form>
                  <br>
                  <?php
                  if(isset($_REQUEST['fname'])){
                      $fname = stripslashes($_REQUEST['fname']);
                      $fname = mysqli_real_escape_string($con, $fname);
                      $firstname   = "UPDATE users SET fname='$fname' WHERE username='" . $_SESSION["username"] . "'";
                      $result   = mysqli_query($con, $firstname);
                      if($result){
                        header("Location: user_profile.php");
                        exit();
                      }else{
                        echo "Error: There was a problem executing the statement...";
                      }
                    }else{
                  ?>
                  <form class=" align-items-center justify-content-center" action="" method="post">
                      <div class="form-group">
                          <label for="fname">First name:</label><br>
                          <h6>Current first name: <?php echo "" . $row['fname'] . ""; ?></h6><br>
                            <h6>What would you like to change your first name to?</h6><br>
                          <input class="form-control form-input" type="text" id="fname" name="fname" placeholder="First Name" required /><!-- comment -->
                      </div>
                      <div class="form-group">
                          <input type="submit" value="Submit" name="submit" class="form-control"/>
                      </div>
                    </form>
                    <?php
                  }
                     ?>
                      <br>

                  <?php
                  if(isset($_REQUEST['lname'])){
                      $lname = stripslashes($_REQUEST['lname']);
                      $lname = mysqli_real_escape_string($con, $lname);
                      $lastname   = "UPDATE users SET lname='$lname' WHERE username='" . $_SESSION["username"] . "'";
                      $result1   = mysqli_query($con, $lastname);
                      if($result1){
                        header("Location: user_profile.php");
                        exit();
                      }else{
                        echo "Error: There was a problem executing the statement...";
                      }
                    }else{
                   ?>
                      <form class=" align-items-center justify-content-center" action="" method="post">
                      <div class="form-group">
                          <label for="lname">Last name:</label><br>
                          <h6>Current last name: <?php echo "" . $row['lname'] . ""; ?></h6><br>
                            <h6>What would you like to change your last name to?</h6><br>
                          <input class="form-control form-input" type="text" id="lname" name="lname" placeholder="Last Name" required /><!-- comment -->
                      </div><!-- comment -->
                      <div class="form-group">
                          <input type="submit" value="Submit" name="submit" class="form-control"/>
                      </div>
                    </form>
                    <?php
                  }
                     ?>
                      <br>
                      <?php
                  if(isset($_REQUEST['email'])){
                      $email = stripslashes($_REQUEST['email']);
                      $email = mysqli_real_escape_string($con, $email);
                      $newemail   = "UPDATE users SET email='$email' WHERE username='" . $_SESSION["username"] . "'";
                      $result2   = mysqli_query($con, $newemail);
                      if($result2){
                        header("Location: user_profile.php");
                        exit();
                      }else{
                        echo "Error: There was a problem executing the statement...";
                      }
                    }else{
                      ?>
                      <form class=" align-items-center justify-content-center" action="" method="post">
                      <div class="form-group">
                          <label for="email">Email:</label><br>
                          <h6>Current email address: <?php echo "" . $row['email'] . ""; ?></h6><br>
                          <h6>What would you like to change your email address to?</h6><br>
                          <input class="form-control form-input" type="email" id="email" name="email" placeholder="Email" required />
                      </div>
                      <div class="form-group">
                          <input type="submit" value="Submit" name="submit" class="form-control"/>
                      </div>
                    </form>
                    <?php
                  }
                     ?>
                      <br>
                  <?php
                  if(isset($_REQUEST['password'])){
                      $password = stripslashes($_REQUEST['password']);
                      $password = mysqli_real_escape_string($con, $password);
                      $newpassword   = "UPDATE users SET password='" . md5($password) . "' WHERE username='" . $_SESSION["username"] . "'";
                      $result3   = mysqli_query($con, $newpassword);
                      if($result3){
                        header("Location: user_profile.php");
                        exit();
                      }else{
                        echo "Error: There was a problem executing the statement...";
                      }
                    }else{
                   ?>
                      <form class=" align-items-center justify-content-center" action="" method="post">
                      <div class="form-group">
                          <label for="password">Password:</label><br>
                          <h6>What would you like to change your current password to?</h6><br>
                          <input class="form-control form-input" type="password" id="password" name="password" placeholder="Password" required />
                      </div>
                      <div class="form-group">
                          <input type="submit" value="Submit" name="submit" class="form-control"/>
                      </div>
                    </form>
                    <?php
                  }
                     ?>
                </center>
              <?php
            }
            }
ob_end_flush();
          ?>
          <script src="script.js"></script>

        </center>
    </body>
</html>
