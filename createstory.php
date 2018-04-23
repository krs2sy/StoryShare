<!DOCTYPE html>
<html ng-app="storyshareApp">
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
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
</head>
<body ng-init= "story = { story_id: -1, title:'UVa History', description :'', user_id :-1, date_created:''}; chapter = { number: 1, text:''}; msgs={ title_msg: '', descr_msg: '', text_msg :''}">

    <script src='navbar.php' type='text/javascript'></script>

    <h3>New Story</h3>

    <div ng-controller="StoryController" class="new_post">
       Title: <input type="text" ng-model="story.title" id="title" />
       {{msgs.title_msg}}<br />
       Description: <input type="text" ng-model="story.description" id="title" />
       {{msgs.descr_msg}}<br />
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

      {{story.date_created}}
       <!-- let's add a button to clear the username variable -->
       <button ng-click="submit()">Create Story</button>
    </div>

    <script>
       function StoryController($scope) {

    	   $scope.submit = function() {
    	       var okay = true;
    	       //Checks if all fields are entered
    		   if ($scope.story.title == "") {
                    $scope.msgs.title_msg = "Please enter a title.";
                    okay = false;
               }
               else {
                    $scope.msgs.title_msg = "";
               }
               if ($scope.story.description == "") {
                    $scope.msgs.descr_msg = "Please enter a description.";
                    okay = false;
               }
               else {
                    $scope.msgs.descr_msg = "";
               }
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
                    var today = mm+'/'+dd+'/'+yyyy;

                    $scope.story.date_created = today;
    	       //Will take to next page.
    	       }
    	   }

       }
       var myApp = angular.module('storyshareApp', []);
       myApp.controller("StoryController", StoryController);
    </script>

    <script src="footer.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->

</body>
</html>


