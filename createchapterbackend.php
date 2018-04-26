<?php
// createstorybackend.php
//  Gets the values and insert into the database.

$SERVER = "localhost";
$DATABASE = "myl2vu";
$USERNAME = "myl2vu";
$PASSWORD = "ilikeseals";

$post_data = file_get_contents("php://input");
$data = json_decode($post_data);
$chapter_number = $data->chapternumber;
$chapter_text = $data->chaptertext;
//$user_id = $_SESSION["user_id"];
$story_id = $data->storyid;
echo "Story id from create chapter: " . $story_id;

//Make database call to get story_id
//Check session for user_id

//Insert story information into database
 $conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

$sql="INSERT INTO chapters (chapter_number, chapter_text, story_id) VALUES ('" . $chapter_number . "', '" . $chapter_text . "', " . $story_id . ")";

if (!mysqli_query($conn,$sql))
{
     die('Error: ' . mysqli_error($conn));
 }
$conn->close();



//Might make separate backend for create_chapter and send post request there
//Send back story_id if request is successful

print $story_id;

?>