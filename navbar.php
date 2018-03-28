<?php
session_start();
//Embedding javascript into php based on https://stackoverflow.com/questions/23574306/executing-php-code-inside-a-js-file/23574397
$username = "";
if (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
}
header("Content-type: application/javascript");
$text1 = "Login";
$link1 = "http://localhost:8080/StoryShare_Servlet/LoginServlet";
$text = "";
$link="?";
$logout = "";
if ($username != "") {
    $link1 = "http://localhost:8080/StoryShare_Servlet/LogoutServlet";
    $text1 = "Logout";
    $link = "http://localhost/StoryShare/profile.php";
    $text = "Welcome, $username";
    //$logout = '<li><a href="http://localhost/StoryShare/forum.php">Logout</a></li>\';
}
?>

//From navbar example

document.write('\
\
 <nav class="navbar navbar-inverse navbar-static-top">\
  <div class="container">\
    <div class="navbar-header">\
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">\
        <span class="sr-only">Toggle navigation</span>\
        <span class="icon-bar"></span>\
        <span class="icon-bar"></span>\
        <span class="icon-bar"></span>\
      </button>\
      <a class="navbar-brand" href="http://localhost/StoryShare/index.php">Story Share</a>\
    </div>\
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">\
      <ul class="nav navbar-nav navbar-right">\
        <li><a href=<?php echo "$link1" ?>><?php echo "$text1"; ?></a></li>\
         <li><a href=<?php echo "$link" ?>><?php echo "$text"; ?></a></li>\
        <li><a href="http://localhost/StoryShare/forum.php">Forums</a></li>\
      </ul>\
    </div>\
  </div>\
</nav>\
');