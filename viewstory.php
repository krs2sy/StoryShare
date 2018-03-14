<?php
    $username = 'Marissa';
    $comment = null;
    $date = null;
    $comment_msg  = null;
    //List of information of posts to display
    $users = array('Marissa', 'Chris6');
    $comments = array('I liked this.', 'Can\'t wait till the next chapter.');
    $dates = array('01/01/18', '01/08/18');
    //For the option menu of list of your stories
    //$storyMatrix = array('Title' => $title, 'Comment' => $comments, 'Date' => $dates);
    function addcomment(&$user, &$comment, &$date, &$users, &$comments, &$dates) {
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
               addComment($user, $comment, $date, $users, $comments, $dates)
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
    <script src="navbar.js"></script>


    <section class="new_post">
        <h3>Story Title</h3>
            <select id="selectStory">
                <option value="ch1">Chapter 1</option>
                <option value = "ch2">Chapter 2</option>
                <option value="ch3">Chapter 3</option>
            </select>


            </br>
            ​ <textarea readonly rows="15" cols="150" id="textArea"
              style="max-height:100px;min-height:100px; resize: none">It was the season of sales. The august establishment of Walpurgis and Nettlepink had lowered its prices for an entire week as a concession to trade observances, much as an Arch-duchess might protestingly contract an attack of influenza for the unsatisfactory reason that influenza was locally prevalent. Adela Chemping, who considered herself in some measure superior to the allurements of an ordinary bargain sale, made a point of attending the reduction week at Walpurgis and Nettlepink's. "I'm not a bargain hunter," she said, "but I like to go where bargains are." With a view to providing herself with a male escort Mrs. Chemping had invited her youngest nephew to accompany her on the first day of the shopping expedition, throwing in the additional allurement of a cinematograph theatre and the prospect of light refreshment. As Cyprian was not yet eighteen she hoped he might not have reached that stage in masculine development when parcel-carrying is looked on as a thing abhorrent. </textarea>
            </br>
            </br>
          <label style="font-size: 18px"><b>Comments</b></label>
          </br>
      
          <?php
            //Displaying each post in order from most recent
            for($key = count($comments) - 1; $key >= 0; $key--) {
                echo "<div class='group'>";
                echo "<div class='post_left'>";
                echo "<label style='color:blue; font-size: 12px'><i>$users[$key]</label>";
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