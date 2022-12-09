<?php
include 'logic.php';
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
                <a  style="color: orange" href="index.php"><img src="home.png"> Home </a></p>
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

<center>
        <?php
       try {
         $stmt = $con->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts WHERE is_approved=1 ORDER BY postID DESC');
         ?><table class="main-space"><?php
         $i =0;
         $stmt->fetch_assoc();
         foreach($stmt as $row) {

             echo "<center><td>";
             echo '<div class="card">';
             echo '<div class="container">';
             echo '<h1><a href="viewpost.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h1>';
             echo '</div>';
             echo '<p>Posted on ' . $row['postDate'] . '</p><br>';
             echo '<p>' . $row['postDesc'] . '</p>';
             echo '<p><a href="viewpost.php?id=' . $row['postID'] . '">Read More</a></p>';
             echo '</div>';
             echo "</td></center>";
             $i = $i+1;
             if($i % 3 == 0 )
             {
                 echo "<tr></tr>";
                 echo "<tr></tr>";
             }
           }
       } catch (PDOException $e) {
           echo $e->getMessage();
       }echo "</table>";
       ?>

   </div>
   </div>
   </center>
   <script src="script.js"></script>


    </body>
</html>
