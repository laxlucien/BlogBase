<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="BBlog.css">
</head>
<body> 
    <?php
    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $databaseName = "blog_base";
    
    $con = mysqli_connect($hostName,$userName , $password, $databaseName);

    if (!$con) {
        echo"<h3 class='container bg-dark text-center p-3 text-warning rounded-lg mt-5'>not able to establish database connection</h3>";
    }

    $sql = "SELECT * FROM BLOG_POSTS";
    $query = mysqli_query($con, $sql);

    if (isset($_REQUEST["new_post"])) {
        $title = $_REQUEST["title"];
        $content = $_REQUEST["editor1"];

        $sql = "INSERT INTO blog_posts(postTitle, postDesc, postCont) VALUES('$title','$content','$content')";
        mysqli_query($con, $sql);
    }
    ?>



</body>
</html>
