<?php
    session_start();
    $username = 'Anonymous';
    $titles = array('Synergy', 'Data Shield', 'Story Title');
    $user_ids = array('0', '0', '1');
    $authors = array('shardi3', 'shardi3', 'katie');
    $descrs = array('A group of friends go on adventures and balance the forces of heat and cold.', 'Students of a cybersecurity academy use special computers to save their city from a hacker.', 'Click on the title to view the story.');
    $dates = array('12/05/17', '12/17/17', '01/28/18');
    $refresh = false;

    //Checks the parameter passed in by the login servlet
    if (isset($_GET['username']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['username']=$_GET['username'];
        $refresh = true;
        //header("Refresh:0; url=index.php");
    }

    //Checks the parameter passed in by the login servlet
    if (isset($_GET['id']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['user_id']=$_GET['id'];
        $refresh = true;
    }

    if (isset($_GET['name']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['name']=$_GET['name'];
        $refresh = true;
    }
    if (isset($_GET['email']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['bio']=$_GET['email'];
        $refresh = true;
    }
    if (isset($_GET['experience']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['experience']=$_GET['experience'];
        $refresh = true;
    }
    if (isset($_GET['bio']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['bio']=$_GET['bio'];
        $refresh = true;
    }
    if (isset($_GET['date']))
    {
        //Creates a new session once the user is logged in.
        $_SESSION['date']=$_GET['date'];
        $refresh = true;
    }

    //Checks the parameter passed in by the logout servlet
    if (isset($_GET['loggedout']))
    {
        //Deletes the session with the user
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        unset($_SESSION['experience']);
        unset($_SESSION['bio']);
        unset($_SESSION['date']);
        //header("Refresh:0; url=index.php");
        $refresh = true;
    }
    if ($refresh) {
        header("Refresh:0; url=index.php");
    }
    //Sets the username value to the logged-in user's username
    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
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
    <script src='navbar.php' type='text/javascript'></script>

 <h2>Stories</h2>
  
    <?php //echo "$username"?>

   <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!<script src="js/bootstrap.min.js"></script> -->

 <section class="listed stories new_post">
  <label style="color: blue; font-size: 12px"><b>Filters</b></label>
    </br>
    </br>
    </br>
             <?php
                 for($key = count($titles) - 1; $key >= 0; $key--) {
                    echo "<div class='group'>";
                    echo "<div class='post_left'>";
                    $prof_url = 'profile.php?prof_id=' . $user_ids[$key];
                    echo "<label style='color: blue; font-size: 18px'><i><a href='viewstory.php'>$titles[$key]</a></i></label> by <label style='color: blue; font-size: 18px'><a href=" . $prof_url .">$authors[$key]</a></label>";
                    echo "<p style='font-size: 12px'>$descrs[$key]</p>";
                    echo "</div>";
                    echo "<div class='post_right'>";
                    echo "<p>Updated: $dates[$key]</p>";
                    echo "</div>";
                    echo "</div>";
                 }
             ?>
            </section>
        </section>


      </div>
    </section>
    <script src="footer.js"></script>

</body>
</html>