<?php
    $servername = "localhost";
    $db_name = "myl2vu";
    $db_user = "myl2vu";
    $db_pwd = "ilikeseals";

    session_start();
    $story_id = null;
    $story_title = '';
    $num_chapters = 1;

    if (isset($_GET['story_id']))
    {
        $story_id = $_GET['story_id'];
    }
    if (isset($_GET['story_title']))
    {
        $story_title = $_GET['story_title'];
    }
    function getNumChapters(&$servername, &$db_user, &$db_pwd, &$db_name, &$story_id, &$num_chapters) {
        // Create connection
        $conn = new mysqli($servername, $db_user, $db_pwd, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);

        }
        $sql = "SELECT count(1) FROM chapters WHERE story_id = " . $story_id;
        $result = $conn->query($sql);
        $row = $result->fetch_array();

        $num_chapters = $row[0];

        $conn->close();
    }
    getNumChapters($servername, $db_user, $db_pwd, $db_name, $story_id, $num_chapters);
?>

<!DOCTYPE html>
<html >
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
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.16/angular.min.js"></script>
</head>
<body ng-app="storyshareApp" ng-init= "story = { story_id: <?php echo $story_id; ?>, title: <?php echo $story_id; ?>}; chapter = { number: <?php echo $num_chapters+1; ?>, text:''}; msgs={text_msg :''};">

    <script src='navbar.php' type='text/javascript'></script>

    <h3>New Chapter for {{ story.title }}</h3>

    <div ng-controller="ChapterController" class="new_post">
       <br />
       <h3>Chapter {{ chapter.number }}</h3>
       <textarea
          ng-model="chapter.text"
          [name="text"]
          [ng-minlength=1]
          rows="40"
          >

      </textarea>
      {{msgs.text_msg}}<br />
      {{data}}

       <!-- let's add a button to clear the username variable -->
       <button ng-click="submit()">Create Chapter</button>
    </div>

    <script>
        var myApp = angular.module('storyshareApp', []);

        myApp.controller("ChapterController", function ($scope, $http, $window)
        {


            var onChapterSuccess = function (data, status, headers, config) {
                $window.location.href = 'http://localhost/StoryShare/viewstory.php?story_id=' + $scope.story.story_id + '&chapter_number=' + $scope.chapter.number;

            };

            var onChapterError = function (data, status, headers, config) {
                $scope.data = "error";
            };

    	   $scope.submit = function() {
    	       var okay = true;
    	       //Checks if all fields are entered
               if ($scope.chapter.text == "") {
                    $scope.msgs.text_msg = "Please enter text.";
                    okay = false;
               }
               else {
                    $scope.msgs.text_msg = "";
               }
               if (okay) {


                    //Set date_created for story
                    //Code for date format based on: https://stackoverflow.com/questions/12409299/how-to-get-current-formatted-date-dd-mm-yyyy-in-javascript-and-append-it-to-an-i
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!

                    var yyyy = today.getFullYear();
                    if(dd<10){
                        dd='0'+dd;
                    }
                    if(mm<10){
                        mm='0'+mm;
                    }
                    //var today = mm+'/'+dd+'/'+yyyy;
                    var today = yyyy + '-' + mm + '-' + dd;
                    //$today=date("Y-m-d",strtotime($today));
                    $scope.date_created = today;

    	            //Will take to next page.
                    $scope.data = "send";

    	            var promise = $http.post("createchapterbackend.php", {"chapternumber": $scope.chapter.number, "chaptertext": $scope.chapter.text, "storyid": $scope.story.story_id});
                    //var promise = $http.post("http://localhost/in-class/in-class-12/getCityState.php", { "zip": 81657 });
                    $scope.data = "send1";
                    promise.success(onChapterSuccess);
                    $scope.data = "send2";
                    promise.error(onChapterError);


                    //Might try make separate http post request to createchapterbackend

                    //redirect to viewstory at end.

    	       }
    	   }


        });


    </script>

    <script src="footer.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->

</body>
</html>


