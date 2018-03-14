<?php
    $username = 'Marissa';
    $title = null;
    $descr = null;
    $story = null;
    $comment = null;
    $date = null;
    $msg_title = null;
    $msg_descr = null;

    //List of information of posts to display
    $titles = array('Resources for Space Travel?', 'Which character should star next?');
    $stories = array('New Story', 'Synergy');
    $comments = array(3, 8);
    $dates = array('01/01/18', '01/08/18');

    //For the option menu of list of your stories
    $yourstories = array('New Story', 'Synergy', 'Data Shield', 'UVa History');
    //$storyMatrix = array('Title' => $title, 'Comment' => $comments, 'Date' => $dates);

    function addPost(&$title, &$descr, &$story, &$comment, &$date, &$titles, &$stories, &$comments, &$dates) {
        $title = $_POST['title'];
        $descr = $_POST['descr'];
        $story = $_POST['selectStory'];
        $comment = 0;
        $date = date('m/d/y');
        $titles[] = $title;
        $stories[] = $story;
        $comments[] = $comment;
        $dates[] = $date;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['post'])) {
            if (empty($_POST['title']))
                $msg_title = "Please enter a title";
            if (empty($_POST['descr']))
                $msg_descr = "Please enter a description.";
            else {
                addPost($title, $descr, $story, $comment, $date, $titles, $stories, $comments, $dates);

            }
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

    <h2>Forums</h2>

    <section class="new_post">
        <h3>New Post</h3>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <label>Title: </label>
            <input type="text" name="title" autofocus onblur="" />
            <?php
                echo "$msg_title";
            ?>
            <br/>
            <label>Description: </label>
            ​<textarea name="descr" rows="8" cols="70"></textarea>
            <br/>
            <?php
                echo "$msg_descr";
            ?>
            <br/>
            <label>Story: </label>
            <select name="selectStory">
            <?php //code for iterating for option based on https://stackoverflow.com/questions/19884685/php-option-value ?>
            <?php foreach ($yourstories as $key => $value): ?>
                <option value="<?php echo $value; ?>"> <?php echo $value; ?>
                 </option>
            <?php endforeach; ?>

            </select>
            <input style = "float: right" type="submit" name="post" value="Post" onclick="" />   <!-- use input type="submit" with the required attribute -->
        </form>
        <?php
            if ($title != null && $descr != null) {
                echo "Created new post with title: \"$title\" and description: \"$descr\" from story: <i>$story</i> <br/>";
            }
        ?>
        <br/>

    </section>
    <section class="new_post">
        <h3>Posts</h3>
         <label>Options: </label>
        <select>
            <option value="allPosts">All Posts</option>
            <option value="myPosts">My Posts</option>
        </select>

        <?php
            //Displaying each post in order from most recent
            for($key = count($titles) - 1; $key >= 0; $key--) {
                //echo "<li>$titles[$key], $stories[$key], $comments[$key], $dates[$key]</li>";
                echo "<div class='group'>";
                echo "<div class='post_left'>";
                echo "<p style='font-size: 18px'>$titles[$key]</p>";
                echo "<p style='color: blue'><i><a href='viewstory.php'>$stories[$key]</a></i></p>";
                echo "</div>";
                echo "<div class='post_right'>";
                echo "Updated: $dates[$key]";
                echo "</br>";
                echo "<p>$comments[$key] comments</p>";
                echo "</div>";
                echo "</div>";

            }
         ?>

    </section>

    <script src="footer.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->

</body>
</html>