<html>
<?php require('logic.php'); ?>
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
      <br><br>
      <center>
        <p><h3>That username has already been used.</h3></p>
        <br>
        <p><h3>Would you like to register <a href="register.php">again?</a><br>Or<br>Would you like to <a href="index.php">return</a> to home?</h3></p>

      </center>
    </body>
</html>
