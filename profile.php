<?php
    $username = 'Marissa';
    $title = null;
    $comment = null;
    $date = null;
    $msg_title = null;
    $follower = false;

    $titles = array('Synergy', 'Data Shield');
    $comments = array(7, 2);
    $dates = array('12/05/17', '12/17/17');
    //$storyMatrix = array('Title' => $title, 'Comment' => $comments, 'Date' => $dates);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['create'])) {
            if (empty($_POST['title']))
                $msg_title = "Please enter a title";
            else {
                $title = $_POST['title'];
                $comment = 0;
                $date = date('m/d/y');
                $titles[] = $title;
                $comments[] = $comment;
                $dates[] = $date;

            }
        }
        else if (isset($_POST['follow'])) {
            $follower = !$follower;
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

    <script src="navbar.js"></script>

    <!-- highlight / showcase -->
    <section class="row">
      <div class="grid">

        <section class="profile col">

          <h2>Marissa</h2>
            <section class = "profile_header">
                <div class = "col">
                    <p>Joined: 12/17/2018</p>
                    <p>Experience: Hobbyist</p>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <?php
                        //Follow button shows up if you're not following
                        $value = null;
                        if (!$follower) {
                            $value = "Follow";
                        }
                        else {
                            $value = "Unfollow";
                        }
                        echo "<input type='submit' name='follow' value=$value onclick='' />";
                    ?>
                    </form>
                </div>
                <div class = "col profile_icon">
                    <img src="./images/MarissaPhoto.jpg" alt="Avatar" height="100px" width="100px">
                    <label style="color: blue">edit</label>
                </div>
            </section>


            <section class = "bio group">
                <h4>Biography:</h4>
                <p>I am a computer science person who is more of a hobbyist</p>
            </section>
            <section class = "followers group">
                <h4>I Follow:</h4>
                <ul>
                    <li>Katie</li>
                    <li>Chris6</li>
                </ul>

            </section>

            <section class = "followers group" >
                <h4>My Followers:</h4>
                <ul id = "followers_list">
                    <li>SeaLove</li>
                    <?php
                        if ($follower)
                            echo "<li>$username</li>";
                    ?>
                </ul>

            </section>
        </section>
        <section class="col profile_stories">
             <section class = "new_story">
                <h3>New Story</h3>
                 <div style="margin-bottom: 22px">

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <label>Title: </label>
                    <input type="text" name="title" autofocus required onblur="" />
                    <div id="title-msg" class="feedback"></div>
                    <?php
                        if ($title != null) {
                            echo "Created new story with title, <i>$title</i> <br/>";
                        }
                    ?>
                    <br/>
                    <input type="submit" name="create" value="Create" onclick="" />   <!-- use input type="submit" with the required attribute -->
                </form>

                </div>
                 <h3>My Stories</h3>

                 <?php
                    //Displaying each story
                    foreach($titles as $key=>$value) {
                        // do stuff
                        //echo "<li>$titles[$key], $comments[$key], $dates[$key]</li>";
                        echo "<div class='group'>";
                        echo "<div class='post_left'>";
                        echo "<label style='color: blue; font-size: 18px'><i>$titles[$key]</i></label>";
                        echo "<p style='font-size: 12px'>Updated: $dates[$key]</p>";
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