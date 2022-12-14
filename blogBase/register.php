<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require('logic.php');
?>

<html>
    <head>
        <title>Blogbase - Sign Up</title>
        <meta charset="utf-8"><!-- <meta -->
        <meta name="viewport" content="width=device-width, inital-scale=1"><!-- comment -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="BBlog.css">
                  <link rel="stylesheet" href="enter.css">

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
          <?php
          session_start();
          if(isset($_SESSION["username"])){
            $loggedInUser = $_SESSION["username"];
            ?>
            <div class="nav-right flex-div">
                <a href="admin.php"><img src="admin_img.png"></a>
                <a href="graphDes.php"><img src="gd.png"></a>
                <a href="create.php"><img src="editor_img.png"></a>
                <a href="ad_design.php"><img src="ad.png"></a>
                <a href="user_profile.php" style="padding: 10px"><img src="follow.png"></a>
                <u><?php echo $_SESSION['username'] ?></u>
                <a href="logout.php" style="padding: 10px">Logout</a>
            <?php
          }else{
            ?>
      <div class="nav-right flex-div">
          <a href="admin.php"><img src="admin_img.png"></a>
          <a href="graphDes.php"><img src="gd.png"></a>
          <a href="create.php"><img src="editor_img.png"></a>
          <a href="ad_design.php"><img src="ad.png"></a>
          <a href="user_profile.php"><img src="follow.png"></a>
          <a href="login.php" >Login</a><!-- comment -->
          <a href="register.php" style="padding: 10px">Sign Up</a>
      </div>
      <?php
    }
    ?>
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
              session_start();
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
        <div class="d-flex align-items-center justify-content-center">
            <h1>Register for BlogBase:</h1><!-- comment -->
        </div>
        <br><br>
        <?php
        require('logic.php');
        if(isset($_REQUEST['username'])){
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $fname = stripslashes($_REQUEST['fname']);
            $fname = mysqli_real_escape_string($con, $fname);
            $lname = stripslashes($_REQUEST['lname']);
            $lname = mysqli_real_escape_string($con, $lname);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_escape_string($con, $password);
            $Admin = $_REQUEST['Admin'];
            $graphic_Des = $_REQUEST['graphic_Des'];
            $writer = $_REQUEST['writer'];
            $reader = $_REQUEST['reader'];
            $advr = $_REQUEST['advr'];

        $check = "SELECT * FROM `users` WHERE username='$username'";
        $check_select = mysqli_query($con, $check);
        $random_name = mysqli_num_rows($check_select);
        if($random_name > 0){
          header("Location: username_wrong.php");
        }else{

        $query    = "INSERT into `users` (username, fname, lname, email, password, Admin, graphic_des, writer, reader, advr)
                     VALUES ('$username', '$fname', '$lname', '$email', '" . md5($password) . "', '$Admin', '$graphic_Des', '$writer', '$reader', '$advr')";
        $result   = mysqli_query($con, $query);

            if ($result) {
                echo "<div><h3>Registered successfully.</h3></div>";
                header("Location: login.php");
            }
            else{
                echo "<div><h3>Required fields are missing...</h3></div>";
            }
          }
        }
        else{
        ?>
    <center>
        <form class=" align-items-center justify-content-center" action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required />
            </div>
            <div class="form-group">
                <label for="fname">First name:</label>
                <input class="form-control" type="text" id="fname" name="fname" placeholder="First Name" required /><!-- comment -->
            </div>
            <div class="form-group">
                <label for="lname">Last name:</label>
                <input class="form-control" type="text" id="lname" name="lname" placeholder="Last Name" required /><!-- comment -->
            </div><!-- comment -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Email" required />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required />
            </div>
            <div class="form-group">
              <label for="Admin">Admin:</label>
              <input type="checkbox" id="Admin" name="Admin" value="1" class="#"/>
              <br>
              <label for="graphic_Des">Graphic Designer:</label>
              <input type="checkbox" id="graphic_Des" name="graphic_Des" value="1" class="#"/>
              <br>
              <label for="writer">Writer:</label>
              <input type="checkbox" id="writer" name="writer" value="1" class="#"/>
              <br>
              <label for="reader">Reader:</label>
              <input type="checkbox" id="reader" name="reader" value="1" class="#" required />
              <br>
              <label for="advr">Advritiser:</label>
              <input type="checkbox" id="advr" name="advr" value="1" class="#"/>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" value="Submit" name="submit" class="form-control"/>
            </div>
        </form>
    </center>
        <?php
        }
        ?>
        <br>
    <center>
      <h3>Already have an account? <a href="login.php">login</a> here.</h3>
      <br>
      <h3>Not what you wanted to see? Go <a href="index.php">back</a> to home.</h3>
    </center>
    <script src="script.js"></script>
    </body>
</html>
