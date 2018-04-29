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

//Insert story information into database
 $conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

$sql="INSERT INTO stories (story_title, story_description, user_id, story_date) VALUES ('" . $story_title . "', '" . $story_descr . "', " . $user_id . ", '" . $story_date . "')";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
    $sql = "SELECT `story_id` FROM stories WHERE story_title = '" . $story_title . "' AND story_description = '" . $story_descr . "' AND user_id = " . $user_id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            //Get last row
            while($row = $result->fetch_assoc()) {
                $story_id = $row["story_id"];
                break;
            }

        } else {
            echo "0 results";
        }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();



//Might make separate backend for create_chapter and send post request there
//Send back story_id if request is successful

print $story_id;

?>