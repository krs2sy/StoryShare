<?php
    $msg = null;
    $refresh = false;
    if (isset($_GET['msg']))
    {
        //Creates a new session once the user is logged in.
        $msg=$_GET['msg'];
    }
    $options = array('', 'Beginner', 'Intermmediate', 'Expert', 'Hobbyist');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Story Share</title>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' />
	<link rel='stylesheet' href='http://localhost/StoryShare/styles/main.css' />
</head>
<body>
	<script src='http://localhost/StoryShare/navbar.php' type='text/javascript'></script>
	<section class="row">
    <div class="grid">

	<h2>Create Account</h2>

	<section class='new_post'>
	<?php
        if ($msg != null) {
            echo "<p style='color:red';>$msg </p>";
        }
    ?>
		<form action='http://localhost:8080/StoryShare_Servlet/CreateAccount.jsp' method='post'>
	      <table>
	        <tr>
	          <td>Username*: </td>
	          <td><input type="text" name="servlet_username" ></td>
	        </tr>
	        <tr>
	          <td>Password*: </td>
	          <td><input type="password" name="servlet_password" /></td>
	        </tr>
	        <tr>
	          <td>Name: </td>
	          <td><input type="text" name="servlet_name" /></td>
	        </tr>
	        <tr>
	          <td>Email: </td>
	          <td><input type="text" name="servlet_email" /></td>
	        </tr>
	        <tr>
	          <td>Experience: </td>
	          <td><select name="servlet_experience">
                 <?php //code for iterating for option based on https://stackoverflow.com/questions/19884685/php-option-value ?>
                 <?php foreach ($options as $key => $value): ?>
                 <option value="<?php echo $value; ?>"> <?php echo $value; ?>
                 </option>
            <?php endforeach; ?></td>
	        </tr>
	        <tr>
	          <td>Biography: </td>
	          <td><input type="text" name="servlet_bio" /></td>
	        </tr>
	        <tr>
	          <td colspan="2" align="right">
	             <input type="submit" name="btn" value="Submit information" />
	          </td>
	        </tr>
	      </table>
	   </form>
	</section>
	<hr />
    </div>
    </section>
	<script src='http://localhost/StoryShare/footer.js'></script>
</body>