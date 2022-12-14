<?php
// Update the details below with your MySQL details
require('logic.php');

session_start();
if(isset($_SESSION["username"])){
  $loggedInUser = $_SESSION["username"];

// Below function will convert datetime to time elapsed string
function time_elapsed_string($datetime, $full = false) {
$now = new DateTime;
$ago = new DateTime($datetime);
$diff = $now->diff($ago);
$diff->w = floor($diff->d / 7);
$diff->d -= $diff->w * 7;
$string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
foreach ($string as $k => &$v) {
    if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
        unset($string[$k]);
    }
}
if (!$full) $string = array_slice($string, 0, 1);
return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// This function will populate the comments and comments replies using a loop
function show_comments($comments, $parent_id = -1) {
$html = '';
// Iterate the comments using the foreach loop
foreach($comments as $help){
    if ($help['parent_id'] == $parent_id) {
        // Add the comment to the $html variable
        $html .= '
        <div class="comment">
            <div>
                <h3 class="name">' . htmlspecialchars($help['name'], ENT_QUOTES) . '</h3>
                <span class="date">' . time_elapsed_string($help['submit_date']) . '</span>
            </div>
            <p class="content">' . nl2br(htmlspecialchars($help['content'], ENT_QUOTES)) . '</p>
            <a class="reply_comment_btn" href="#" data-comment-id="' . $help['id'] . '">Reply</a>
            ' . show_write_comment_form($help['id']) . '
            <div class="replies">
            ' . show_comments($comments, $help['id']) . '
            </div>
        </div>
        ';
    }
}
return $html;
}

// This function is the template for the write comment form
function show_write_comment_form($parent_id = -1) {
  require('logic.php');
  if(isset($_SESSION["username"])){
    $loggedInUser = $_SESSION["username"];
  $getSignedIn = $con->query("SELECT username FROM users WHERE username='$loggedInUser'");
  $row = $getSignedIn->fetch_assoc();
  $current = $row["username"];
$html = '
<div class="write_comment" data-comment-id="' . $parent_id . '">
    <form>
        <input name="parent_id" type="hidden" value="' . $parent_id . '">
        <input name="name" type="hidden" value="' . $current . '">
        <textarea name="content" placeholder="Write your comment here..." required></textarea>
        <button type="submit">Submit Comment</button>
    </form>
</div>
';
return $html;
}
}
$realPageID = 0;
// Page ID needs to exist, this is used to determine which comments are for which page
if (isset($_GET['page_id'])) {
  $realPageID = $_GET['page_id'];
// Check if the submitted form variables exist
if (isset($_POST['name'], $_POST['content'])) {
    // POST variables exist, insert a new comment into the MySQL comments table (user submitted form)
    $stmt = $con->prepare('INSERT INTO comments (page_id, parent_id, name, content, submit_date) VALUES (?,?,?,?,NOW())');
    $stmt->execute([ $_GET['page_id'], $_POST['parent_id'], $loggedInUser, $_POST['content'] ]);
    exit('Your comment has been submitted!');
}
}
// Get all comments by the Page ID ordered by the submit date
$stmt = $con->query("SELECT * FROM comments WHERE page_id = '$realPageID' ORDER BY submit_date DESC");
$comments = $stmt;
$comments1 = $stmt->fetch_all(MYSQLI_ASSOC);

// Get the total number of comments
$stmt = $con->query("SELECT COUNT(*) AS total_comments FROM comments WHERE page_id = $realPageID");
$comments_info = $stmt->fetch_assoc();
} else {
exit('You need to sign in to view comments...');
}

?>

<div class="comment_header">
<span class="total"><?=$comments_info['total_comments']?> comments</span>
<a href="#" class="write_comment_btn" data-comment-id="-1">Write Comment</a>
</div>

<?=show_write_comment_form()?>

<?=show_comments($comments1)?>
