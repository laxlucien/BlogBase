<?php
  include("logic.php");
  require('db.php');
  include('auth_social.php');
 ?>
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
              <a href="index.php"><img src="home.png"> Home </a></p>
              <a href="hot.php"><p><img src="hot.png"> Hot! </a></p>
              <a href="viewSaved.php"><p><img src="saved.png"> Saved </a></p>
              <a href="archived.php"><p><img src="history.png"> Archived </a></p>
              <hr>
          </div>
          <div class="Authors">
            <center>
              <p style="color: orange;"><a href="social.php">Social</a></p>
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

        <br>
        <center>
          <h1>Social</h1>
          <br>
          <h3>A list of users will be displayed below.</h3>
        </center>
        <br>
        <center>
          <?php
          //this will get the userid from the username_wrong
          $pleaseWork = $_SESSION['username'];
            $getUserID = "SELECT userid FROM users WHERE username='$pleaseWork'";
            $loggedOn = $con->query($getUserID);
            if($loggedOn->num_rows > 0){
              while($row = $loggedOn->fetch_assoc()){
                $realUserID = $row["userid"];

                //the above makes it so you can recieve the variables for the person who is logged in
                //this will get the rest of the data for the form so we can update the table

                ?><table><?php
                  //this is all to display the things

                  $socialPart = "SELECT t1.userid as user1, t2.userid as user2, t1.username as usern1, t2.username as usern2
                                  FROM users as t1
                                  cross join users as t2";
                  $getSocialPart = $con->query($socialPart);
                  if($getSocialPart->num_rows > 0){
                    while($row2 = $getSocialPart->fetch_assoc()){
                      $followerID = $row2["user1"];
                      $followedUserID = $row2["user2"];
                      $usernameLog = $row2["usern1"];
                      $usernameComp = $row2["usern2"];

                      $sql = "INSERT INTO `social_follow`
                              SET follower_id = '$followerID',
                                  followed_user_id = '$followedUserID',
                                  username_log = '$usernameLog',
                                  username_comp = '$usernameComp'
                                  ON DUPLICATE KEY UPDATE
                                      follower_id = VALUES(follower_id),
                                      followed_user_id = VALUES(followed_user_id),
                                      username_log = VALUES(username_log),
                                      username_comp = VALUES(username_comp)";
                      $resultToEnd = mysqli_query($con, $sql);
                      //above loads all the entries into the db
                    }
                  }
                  $currentValues = "SELECT username, follow_id, unique_number FROM users, social_follow WHERE userid!='$realUserID' and is_approved=1 and follower_id='$realUserID' and followed_user_id=userid";
                  $getCurrentValues = $con->query($currentValues);
                  if($getCurrentValues->num_rows > 0){
                    while($row1 = $getCurrentValues->fetch_assoc() ){
                      ?>
                        <tr>
                          <td><h2>@<?php echo $row1["username"]; ?></h2></td>
                      <?php
                      //$socialPart = "SELECT follow_id, userid FROM social_follow, users WHERE userid=follower_id";
                      //$getSocialPart = $con->query($socialPart);
                      //while($row2 = $getSocialPart->fetch_assoc()){
                        if($row1["follow_id"] == 1 ){
                          ?>
                          <td><a href="approve_follow1.php?unique_number=<?php echo $row1["unique_number"]; ?>">Following</a></td>
                            <?php
                          }
                        else{
                          ?>
                          <td><a href="approve_follow2.php?unique_number=<?php echo $row1["unique_number"]; ?>">Follow</a></td>
                          <?php
                        }
                        echo "</tr>";
}
                    }
                  }
                }
                //^^^ this is the end of the isset() statement
                ?>
              </table>

                <?php


            ?>
        </center>
<script src="script.js"></script>
      </body>
  </html>
