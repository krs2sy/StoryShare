<?php
    $servername = "localhost";
    $db_name = "myl2vu";
    $db_user = "myl2vu";
    $db_pwd = "ilikeseals";

    session_start();
    $username = 'Anonymous';
    $user_id;
    $refresh = false;
    if (isset($_GET['username']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['username']=$_GET['username'];
        $refresh = true;
        //header("Refresh:0; url=index.php");
    }
    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    if (isset($_SESSION['user_id']))
    {
        $user_id = $_SESSION['user_id'];
    }
    $title = null;
    $comment = null;
    $date = null;
    $msg_title = null;
    $follower = false;

    $story_ids = array();
    $titles = array();
    $descrs = array();
    $comments = array();
    $dates = array();
    //$storyMatrix = array('Title' => $title, 'Comment' => $comments, 'Date' => $dates);
    $prof_id = null;
    if (isset($_GET['prof_id']))
    {
        //Creates a new session once the user is logged in.
        $prof_id = $_GET['prof_id'];
        //header("Refresh:0; url=index.php");
    }
    $prof_user = 'Marissa';
    if ($username != 'Anonymous')
    {
        $prof_user = $username;
    }
    $prof_followees = array('chris6', 'Katie');
    $prof_followers = array('SeaLove');
    $prof_date = '12/17/2018';
    $prof_exp = 'Hobbyist';
    $prof_bio = 'I am a student';
    if (isset($_GET['name']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['name']=$_GET['name'];
        $refresh = true;
        //header("Refresh:0; url=index.php");
    }
    if (isset($_GET['email']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['bio']=$_GET['email'];
        $refresh = true;
        //header("Refresh:0; url=index.php");
    }
    if (isset($_GET['experience']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['experience']=$_GET['experience'];
        $refresh = true;
        //header("Refresh:0; url=index.php");
    }
    if (isset($_GET['bio']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['bio']=$_GET['bio'];
        $refresh = true;
        //header("Refresh:0; url=index.php");
    }
    if ($refresh) {
        header("Refresh:0; url=profile.php?prof_id=" . $user_id);
    }
    if (isset($_SESSION['experience']))
    {
        $prof_exp = $_SESSION['experience'];
    }
    if (isset($_SESSION['bio']))
    {
        $prof_bio = $_SESSION['bio'];
    }
    if (isset($_SESSION['date']))
    {
        $prof_date = $_SESSION['date'];
    }

    function addStory(&$title, &$comment, &$date, &$titles, &$comments, &$dates) {
        $title = $_POST['title'];
        $comment = 0;
        $date = date('m/d/y');
        $titles[] = $title;
        $comments[] = $comment;
        $dates[] = $date;
    }

    function follow(&$follower, &$followers, $username) {
        $follower = !$follower;
        if ($follower) {
            $followers[] = $username;
        }
        else {
            unset($followers[count($followers)-1]);
        }
    }

    function getUserInfo(&$servername, &$db_user, &$db_pwd, &$db_name, &$prof_id, &$prof_user, &$prof_exp, &$prof_bio, &$prof_date) {
        // Create connection
        $conn = new mysqli($servername, $db_user, $db_pwd, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE user_id = " . $prof_id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "id: " . $row["user_id"]. " - Username: " . $row["username"] . "<br>";
                $prof_user = $row["username"];
                $prof_exp = $row["experience"];
                $prof_bio = $row["bio"];
                $prof_date = $row["date"];
                break;
            }

        }

        $conn->close();
    }

    if(!isset($_SESSION['user_id']) || ($_SESSION['user_id'] !== $prof_id && $prof_id != null)) {
        getUserInfo($servername, $db_user, $db_pwd, $db_name, $prof_id, $prof_user, $prof_exp, $prof_bio, $prof_date);
    }

    function getStories(&$servername, &$db_user, &$db_pwd, &$db_name, &$prof_id, &$story_ids, &$titles, &$descrs, &$dates, &$comments) {
        // Create connection
        $conn = new mysqli($servername, $db_user, $db_pwd, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM stories WHERE user_id = " . $prof_id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $story_ids[] = $row["story_id"];
                $titles[] = $row["story_title"];
                $descrs[] = $row["story_description"];
                $dates[] = date("m/d/Y", strtotime($row["story_date"]));
                $comments[] = 0;
                //echo $row["username"];
            }
            //print_r($authors);
        }

        $conn->close();
    }
    getStories($servername, $db_user, $db_pwd, $db_name, $prof_id, $story_ids, $titles, $descrs, $dates, $comments);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['create'])) {
            if (empty($_POST['title']))
                $msg_title = "Please enter a title";
            else {
                addStory($title, $comment, $date, $titles, $comments, $dates);

            }
        }
        else if (isset($_POST['follow'])) {
            follow($follow, $prof_followers, $username);
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
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

    <!-- highlight / showcase -->
    <section class="row">
      <div class="grid">

        <section class="profile col">

          <h2><?php echo "$prof_user"; ?></h2>
            <section class = "profile_header">
                <div class = "col">
                    <p>Joined: <?php echo "$prof_date"; ?></p>
                    <p>Experience: <?php echo "$prof_exp"; ?></p>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <?php
                        //Follow button shows up if you're not following
                        $value = null;
                        //Ensure user cannot follow himself/herself
                        if ($username != $prof_user) {
                            if (!$follower) {
                                $value = "Follow";
                            }
                            else {
                                $value = "Unfollow";
                            }
                            echo "<input type='submit' name='follow' value=$value onclick='' />";
                        }

                    ?>
                    </form>
                </div>
                <div class = "col profile_icon">
                    <img src="./images/MarissaPhoto.jpg" alt="Avatar" height="100px" width="100px">

                    <?php
                    //Only logged in users can edit own profile
                    if ($username == $prof_user) {
                        echo "<a href='http://localhost:8080/StoryShare_Servlet/ProfileForm.jsp'>edit</a>";
                    }
                    ?>
                </div>
            </section>


            <section class = "bio group">
                <h4>Biography:</h4>
                <p><?php echo "$prof_bio"; ?></p>
            </section>
            <section class = "followers group">
                <h4>I Follow:</h4>
                <ul>
                    <?php
                        for($key = count($prof_followees) - 1; $key >= 0; $key--) {
                            echo "<li>$prof_followees[$key]</li>";
                        }
                    ?>

                </ul>

            </section>

            <section class = "followers group" >
                <h4>My Followers:</h4>
                <ul id = "followers_list">
                    <?php
                        for($key = count($prof_followers) - 1; $key >= 0; $key--) {
                            echo "<li>$prof_followers[$key]</li>";
                        }

                    ?>
                </ul>

            </section>
        </section>
        <section class="col profile_stories">
             <section class = "new_story">
             <?php
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $prof_id)
                {

                    echo "<h3>New Story</h3>";
                    echo "<div style='margin-bottom: 22px'>";
                    echo "<div class = 'col'>";
                    echo "<form action='http://localhost/StoryShare/createstory.html' method='post'>";
                    echo "<input type='submit' name='create' value='Create' onclick='' />";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
             ?>
                 <h3>My Stories</h3>

                 <?php
                    //Displaying each story in order from most recent

                    //for loop code based on https://stackoverflow.com/questions/5315539/iterate-in-reverse-through-an-array-with-php-spl-solution
                    for($key = count($titles) - 1; $key >= 0; $key--) {
                        //echo "<li>$titles[$key], $comments[$key], $dates[$key]</li>";
                        echo "<div class='group'>";
                        echo "<div class='post_left'>";
                        echo "<label style='color: blue; font-size: 18px'><i><a href='viewstory.php?story_id=$story_ids[$key]&chapter_number=1'>$titles[$key]</a></i></label>";
                        echo "<p style='font-size: 12px'>Updated: $dates[$key]</p>";
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $prof_id)
                        {
                            echo "<a href='createchapter.php?story_id=$story_ids[$key]'>Add Chapter</a>";
                        }
                        echo "</div>";
                        echo "<div class='post_right'>";
                        echo "<p>$comments[$key] comments</p>";
                        echo "</div>";
                        echo "</div>";

                    }
                 ?>

            </section>
        </section>


      </div>
    </section>

    <script src="footer.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
</body>
</html>