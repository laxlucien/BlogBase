<?php
// Include the database configuration file
include 'logic.php';
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $con->query("INSERT into ad_displays (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                header("Location: ad_design.php");
            }else{
                $statusMsg = "File upload failed, please try again.";
                header("Location: ad_design.php");
            }
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
                header("Location: ad_design.php");
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                header("Location: ad_design.php");
    }
}else{
    $statusMsg = 'Please select a file to upload.';
                header("Location: ad_design.php");
}

// Display status message
echo $statusMsg;
?>
