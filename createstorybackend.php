<?php
// createstorybackend.php
//  Gets the values and insert into the database.

$SERVER = "localhost";
$DATABASE = "myl2vu";
$USERNAME = "myl2vu";
$PASSWORD = "ilikeseals";

$post_data = file_get_contents("php://input");
$data = json_decode($post_data);
$story_title = $data->storytitle;
$story_descr = $data->storydescr;
$story_date = $data->storydate;
$user_id = 0;
if (isset($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];
}
$story_id = -1;

//Make database call to get story_id
//Check session for user_id

try {
    //Insert story information into database
     //$conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
    $conn = new PDO("mysql:host=$SERVER;dbname=$DATABASE", $USERNAME, $PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st=$conn->prepare("INSERT INTO stories (story_title, story_description, user_id, story_date) VALUES (?, ?, ?, ?)");
    $st->execute(array($story_title, $story_descr, $user_id, $story_date));
    //$result = $conn->exec($sql);


    $st = $conn->prepare("SELECT `story_id` FROM stories WHERE story_title = ? AND story_description = ? AND user_id = ?");
    $st->execute(array($story_title, $story_descr, $user_id));

    //$result = $st->setFetchMode(PDO::FETCH_ASSOC);
    for($i=0; $row = $st->fetch(); $i++){
        $story_id = $row['story_id'];
        //break;
    }

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