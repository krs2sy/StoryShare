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
    $story_descr = '';
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
    $is_author = false;
    if(isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == $author_id) {
            $is_author=true;
        }
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
        if (isset($_POST['update_chapter'])) {

            updateStoryChapter($servername, $db_user, $db_pwd, $db_name, $_POST['title'], $_POST['description'], $chapter_number, $_POST['chaptertext'], $story_id);

        }
    }

    //Updates story and chapter based on new information
    function updateStoryChapter(&$servername, &$db_user, &$db_pwd, &$db_name, &$story_title, &$story_descr, &$chapter_number, &$chapter_text, &$story_id) {
        try {
            //Insert story information into database
             //$conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
            $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_user, $db_pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $st=$conn->prepare("UPDATE stories SET `story_title` = ?, `story_description` = ? WHERE `story_id`=?");
            $st->execute(array($story_title, $story_descr, $story_id));

            $st=$conn->prepare("UPDATE chapters SET `chapter_text` = ? WHERE `chapter_number`=? AND `story_id`=?");
            $st->execute(array($chapter_text, $chapter_number, $story_id));
            //$result = $conn->exec($sql);

        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        //$conn->close();
        $conn = null;
    }

    function getStoryInfo(&$servername, &$db_user, &$db_pwd, &$db_name, &$story_id, &$story_title, &$story_descr, &$author_id, &$author_username, &$chapter_number, &$chapter_text, &$num_chapters) {
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
                $story_descr = $row["story_description"];
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
    getStoryInfo($servername, $db_user, $db_pwd, $db_name, $story_id, $story_title, $story_descr, $author_id, $author_username, $chapter_number, $chapter_text, $num_chapters);

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
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.16/angular.min.js"></script>
  </head>
<body ng-app ng-init="edit=false">
    <script src='navbar.php' type='text/javascript'></script>


    <section class="new_post">
        <h3 ng-show="!edit"><?php echo "<i>$story_title</i> by <a href='profile.php?prof_id=$author_id'>$author_username</a></label>"; ?></h3>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="text" ng-show="edit" name="title" value="<?php echo $story_title?>" /> <br />
            <input type="text" ng-readonly="!edit" name="description" value="<?php echo $story_descr?>" /> <br />
            <br />
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
            <?php
                if(isset($_SESSION['user_id'])) {
                    if ($_SESSION['user_id'] == $author_id) {
                        echo 'Edit: <input type="checkbox" ng-model="edit">';
                    }
                }
            ?>



                <input ng-show="edit" type='submit' name='update_chapter' value="Update" onclick='' />
                <br />
            ​   <textarea ng-readonly="!edit" [ng-minlength=1] rows="40" name="chaptertext"> <?php echo "$chapter_text"; ?> </textarea>
                <input type="hidden" name="chapter_number" value="<?php echo $chapter_number;?>">
                <input type="hidden" name="story_id" value="<?php echo $story_id;?>">
             </form>
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