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

$story_id = $data->storyid;
//echo "Story id from create chapter: " . $story_id;

//Make database call to get story_id
//Check session for user_id

//Insert story information into database
try {
    //Insert story information into database
     //$conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
    $conn = new PDO("mysql:host=$SERVER;dbname=$DATABASE", $USERNAME, $PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st=$conn->prepare("INSERT INTO chapters (chapter_number, chapter_text, story_id) VALUES (?, ?, ?)");
    $st->execute(array($chapter_number, $chapter_text, $story_id));
    //$result = $conn->exec($sql);

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
//$conn->close();
$conn = null;



//Might make separate backend for create_chapter and send post request there
//Send back story_id if request is successful

print $story_id;

?>