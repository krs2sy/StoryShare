<?php
    $servername = "localhost";
    $db_name = "myl2vu";
    $db_user = "myl2vu";
    $db_pwd = "ilikeseals";

    session_start();
    $username = 'Anonymous';
    $author_id = -1;
    $author_username = '';
    $story_id = 1;
    $chapter_number = 1;
    $num_chapters = 1;

    if (isset($_GET['story_id']))
    {
        $story_id = $_GET['story_id'];
    }
    if (isset($_GET['chapter_number']))
    {
        $chapter_number = $_GET['chapter_number'];
    }

    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }

    $story_title = 'Story Title';
    $chapter_text = '';
    $comment = null;
    $date = null;
    $comment_msg  = null;
    //List of information of posts to display
    $users = array('Marissa', 'Chris6');
    $comments = array('I liked this.', 'Can\'t wait till the next chapter.');
    $dates = array('01/01/18', '01/08/18');
    //For the option menu of list of your stories
    //$storyMatrix = array('Title' => $title, 'Comment' => $comments, 'Date' => $dates);
    function addcomment(&$username, &$comment, &$date, &$users, &$comments, &$dates) {
        $comment = $_POST['comment'];
        $date = date('m/d/y');
        $users[] = $username;
        $comments[] = $comment;
        $dates[] = $date;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['create_comment'])) {
            if (empty($_POST['comment']))
                $comment_msg = "Please enter a comment";
            else {
               addComment($username, $comment, $date, $users, $comments, $dates);
            }
        }
    }

    function getStoryInfo(&$servername, &$db_user, &$db_pwd, &$db_name, &$story_id, &$story_title, &$author_id, &$author_username, &$chapter_number, &$chapter_text, &$num_chapters) {
        // Create connection
        $conn = new mysqli($servername, $db_user, $db_pwd, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM stories AS s JOIN chapters AS c ON s.story_id = c.story_id JOIN users AS u ON s.user_id = u.user_id WHERE s.story_id = " . $story_id . " AND c.chapter_number = " . $chapter_number;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "id: " . $row["user_id"]. " - Username: " . $row["username"] . "<br>";
                $story_title = $row["story_title"];
                $author_id = $row["user_id"];
                $author_username = $row["username"];
                $chapter_text = $row["chapter_text"];
                break;
            }

        } else {
            echo "0 results";
        }
        $sql = "SELECT count(1) FROM chapters WHERE story_id = " . $story_id;
        $result = $conn->query($sql);
        $row = $result->fetch_array();

        $num_chapters = $row[0];

        $conn->close();
    }
    getStoryInfo($servername, $db_user, $db_pwd, $db_name, $story_id, $story_title, $author_id, $author_username, $chapter_number, $chapter_text, $num_chapters);

?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="styles/main.css">

    <!-- required scripts for IE -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <title>Story Share</title>
  </head>
<body>
    <script src='navbar.php' type='text/javascript'></script>


    <section class="new_post">
        <h3><?php echo "<i>$story_title</i> by <a href='profile.php?prof_id=$author_id'>$author_username</a></label>"; ?></h3>
            <select id="selectChapter" onchange="if (this.value) window.location.href='http://localhost/StoryShare/viewstory.php?story_id=<?php echo $story_id;?>&chapter_number='+this.value">
                 <?php
                 //Iterating through each chapter a story has
                 for($key = 1; $key < $num_chapters+1; $key++) { ?>
                 <option value="<?php echo $key; ?>"> <?php echo "Chapter $key"; ?>
                 </option>
                 <?php  }  ?>
            </select>
            <script>
                //Trying to set option by chapter number

       		    document.getElementById('selectChapter').value = <?php echo $chapter_number ?>;
             </script>

            </br>
            ​ <textarea readonly rows="15" cols="150" id="textArea"
              style="max-height:100px;min-height:100px; resize: none"> <?php echo "$chapter_text"; ?> </textarea>
            </br>
            </br>
          <label style="font-size: 18px"><b>Comments</b></label>
          </br>
      
          <?php
            //Displaying each post in order from most recent
            for($key = count($comments) - 1; $key >= 0; $key--) {
                echo "<div class='group'>";
                echo "<div class='post_left'>";
                if ($users[$key] != "Anonymous") {
                    echo "<label style='color:blue; font-size: 12px'><i><a href='profile.php'>$users[$key]</a></label>";
                }
                else {
                    echo "<label style='font-size: 12px'>$users[$key]</label>";
                }
                echo "<p style='font-size: 12px'>$comments[$key]</p>";
                echo "</div>";
                echo "<div class='post_right'>";
                echo "<label style='font-size: 10px'><i>Updated: $dates[$key]</label>";
                echo "</br>";
                echo "</div>";
                echo "</div>";
            }
         ?>

            </br>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
            <label>Write comment: </label>
            </br>
            ​<textarea name="comment" rows="8" cols="150" style="max-height:100px;min-height:100px; resize: none"></textarea>
            <?php
                echo "$comment_msg";
            ?>

            <input style = "float: right" type="submit" name="create_comment" value="Post" onclick="" />   <!-- use input type="submit" with the required attribute -->
        </form>


        <div id="content" class="feedback"></div>


    </section>

    <script src="footer.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->

</body>
</html>