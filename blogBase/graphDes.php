<?php
  include("logic.php");
  include("auth_editor.php");
 ?>
<!DOCTYPE html>
<head>
        <meta charset="utf-8"><!-- comment -->
        <meta name="viewport" content="width=device-width, intitial-scale=1.0">
        <title>Blog Base e-newspaper</title>
        <link rel="stylesheet" href="BBlog.css">
        <script src="script.js"></script>
</head>
<body>
  <html lang="eng">
      <head>
          <meta charset="utf-8"><!-- comment -->
          <meta name="viewport" content="width=device-width, intitial-scale=1.0">
          <title>Blog Base e-newspaper</title>
          <link rel="stylesheet" href="BBlog.css">
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
          <?php
          //this is the place that sets up the authentification for the page in tandom with auth_session.php
            $current_user = $_SESSION['username'];
            $test_auth = "SELECT username FROM users where username='$current_user' and (Admin=1 or graphic_Des=1)";
            $help = $con->query($test_auth);
            if($help->num_rows > 0){
              //the rest of the statement is at the bottom and applies if the user doesn't have the proper
              //access to the page. If they dont they are not able to see any of the information
              ?>
              <center><h1><u>Content Approval or Denial:</u></h1></center>
              <br><br>
              <center><h3>Posts waiting to be approved:</h3></center>
              <br>
                <?php
                require('logic.php');
               try {
                 $stmt = $con->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts WHERE is_approved=0 ORDER BY postID DESC');
                 ?><table class="main-space"><?php
                 $i =0;
                 if($stmt->num_rows > 0){
                   $stmt->fetch_assoc();
                 foreach($stmt as $row) {

                     echo "<center><td>";
                     echo '<div class="card">';
                     echo '<div class="container">';
                     echo '<h1><a href="viewpost2.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h1>';
                     echo '</div>';
                     echo '<p>Posted on ' . $row['postDate'] . '</p><br>';
                     echo '<p>' . $row['postDesc'] . '</p>';
                     echo '<p><a href="viewpost2.php?id=' . $row['postID'] . '">Read More</a></p>';
                     echo '</div>';
                     echo "</td></center>";
                     $i = $i+1;
                     if($i % 3 == 0 )
                     {
                         echo "<tr></tr>";
                         echo "<tr></tr>";
                     }
                   }
               }else{
                 ?>
                 <br><center><h5>There are no posts waiting to be approved</h5></center><br>
                 <?php
               }
             }catch (PDOException $e) {
                   echo $e->getMessage();
               }
               echo "</table>";
               ?>

           </div>
           </div>
           </center>
           <br>
           <center><h3>Currently approved posts:</h3></center>
           <br>
                <?php
                try {
                  $stmt = $con->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts WHERE is_approved=1 ORDER BY postID DESC');
                  ?><table class="main-space"><?php
                  $i =0;
                  if($stmt->num_rows > 0){
                  $stmt->fetch_assoc();
                  foreach($stmt as $row) {

                      echo "<center><td>";
                      echo '<div class="card">';
                      echo '<div class="container">';
                      echo '<h1><a href="viewpost2.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h1>';
                      echo '</div>';
                      echo '<p>Posted on ' . $row['postDate'] . '</p><br>';
                      echo '<p>' . $row['postDesc'] . '</p>';
                      echo '<p><a href="viewpost2.php?id=' . $row['postID'] . '">Read More</a></p>';
                      echo '</div>';
                      echo "</td></center>";
                      $i = $i+1;
                      if($i % 3 == 0 )
                      {
                          echo "<tr></tr>";
                          echo "<tr></tr>";
                      }
                    }
                } else{
                  ?>
                  <br><center><h5>There are no posts that are currently approved</h5></center><br>
                  <?php
                }
              }catch (PDOException $e) {
                    echo $e->getMessage();
                }

                echo "</table>";
                ?>

            </div>
            </div>
            </center>
            <?php
                }else{
                  ?>
                  <center>
                    <p><h3>You do not have access to the editor page.</h3></p>
                    <br>
                    <p><h3>Return to <a href="index.php">Home?</a></h3></p>
                  </center>
                  <?php
                }

                ?>
                <script src="script.js"></script>

</body>
</html>
