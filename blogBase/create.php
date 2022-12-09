<?php
include 'logic.php';
include('auth_create.php');
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

    <script src="ckeditor.js">
        CKEDITOR.editorConfig = function(config) {
            config.toolbarGroups = [{
                    name: 'document',
                    groups: ['mode', 'document', 'doctools']
                },
                {
                    name: 'clipboard',
                    groups: ['clipboard', 'undo']
                },
                {
                    name: 'editing',
                    groups: ['find', 'selection', 'spellchecker', 'editing']
                },
                {
                    name: 'forms',
                    groups: ['forms']
                },
                {
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup']
                },
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
                },
                {
                    name: 'links',
                    groups: ['links']
                },
                {
                    name: 'insert',
                    groups: ['insert']
                },
                {
                    name: 'styles',
                    groups: ['styles']
                },
                {
                    name: 'colors',
                    groups: ['colors']
                },
                {
                    name: 'tools',
                    groups: ['tools']
                },
                {
                    name: 'others',
                    groups: ['others']
                },
                {
                    name: 'about',
                    groups: ['about']
                }
            ];

            config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';
        };
    </script>

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

    <!--------------------- side bar
        <div class="sidebar">
            <div class="shortcut-links">
                <a href=""><img src="home.png"><p> Home </p></a>
                <a href=""><img src="hot.png"><p> Hot! </p></a>
                <a href=""><img src="saved.png"><p> Saved </p></a>
                <a href=""><img src="history.png"><p> Recent's</p></a>
                <hr>
            </div>
            <div class="Authors">
                <a href=""><img src="follow.png"><p> Following </p></a>
                <a href=""><img src=""></a>
            </div>
        </div>*/ --------------------->
        <?php
        //this is the place that sets up the authentification for the page in tandom with auth_session.php
          $current_user = $_SESSION['username'];
          $test_auth = "SELECT username FROM users where username='$current_user' and writer=1";
          $help = $con->query($test_auth);
          if($help->num_rows > 0){
            //the rest of the statement is at the bottom and applies if the user doesn't have the proper
            //access to the page. If they dont they are not able to see any of the information
            ?>
    <h1 style='font-size: 24px; text-align: center; padding-top: 15px;'><strong>Blog Submission's </strong></h1>
    <div style='align-items: center; text-align:center;'class="makePost">
        <form method="Get">
            <br>
            <br>
            <input style='color:black; background-color: white; height: 30px; text-align:center;' type="text" name="title" placeholder="POST TITLE" class="title-box">
            <br>
            <br>
            <textarea name="editor1">

        </textarea>
            <script>
                CKEDITOR.replace('editor1');
            </script>

            <br>
            <button name="new_post" class="btn">Save Post</button>
        </form>
        <!---------<form method="Get">

                <textarea name="content" class="content-box"></textarea>

        </form>------------->
    </div>
    <?php
    }else{
      ?>
      <center>
        <p><h3>You do not have access to the writer page.</h3></p>
        <br>
        <p><h3>Return to <a href="index.php">Home?</a></h3></p>
      </center>
      <?php
    }

    ?>
    


</body>

</html>
