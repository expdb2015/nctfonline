<?php require_once('includes/header.php'); ?>


<?php 
 
// If the user is logging in or out 
// then lets execute the proper functions 
if (isset($_GET['action'])) { 
  switch (strtolower($_GET['action'])) { 
    case 'login': 
      if (isset($_POST['email']) && isset($_POST['password'])) { 
        // We have both variables. Pass them to our validation function 
        if (!validateUser($_POST['email'], $_POST['password'])) { 
          // Well there was an error. Set the message and unset 
          // the action so the normal form appears. 
          $_SESSION['error'] = "Bad email or password supplied."; 
          unset($_GET['action']); 
        } 
      }else { 
        $_SESSION['error'] = "email and Password are required to login."; 
        unset($_GET['action']); 
      }       
    break; 
    case 'logout': 
      // If they are logged in log them out. 
      // If they are not logged in, well nothing needs to be done. 
      if (loggedIn()) { 
        logoutUser(); 
        $sOutput .= '<h1>Logged out!</h1><br/>
            <br/><h4>You have been logged out successfully.  </h4>'; 
	    header("Location: index.php");   
      }else { 
        // unset the action to display the login form. 
        unset($_GET['action']); 
      } 
      
    break; 
  } 
} 


// See if the user is logged in. If they are greet them  
// and provide them with a means to logout. 
if (loggedIn()) { 
     //enter home.php
    header("Location: home.php");   
	//userProfile($_SESSION["username"]);

}elseif (!isset($_GET['action'])) { 
  // incase there was an error  
  // see if we have a previous email 
  $semail = ""; 
  if (isset($_POST['email'])) { 
    $semail = $_POST['email']; 
  } 
   
  $sError = ""; 
  if (isset($_SESSION['error'])) { 
    $sError = '<span id="error">' . $_SESSION['error'] . '</span><br/>'; 
  } 
  
    $sOutput .= '<div  class="container col-md-3 col-md-offset-4" >' . $sError . ' 
	    <br>
        <h2>Login</h2>
        <form method="post" action="login.php?action=login">
		     <div class="form-group">
                <label for="email">email</label>
                <input type="text" placeholder="Enter your question  email here" name="email" id="email" value="' .$semail. '"   class="form-control">
             </div>
 			 <div class="form-group">
                <label for="type">password</label>
                <input type="password" placeholder="Enter your password here" name="password" id="password" class="form-control">
             </div>
            <button name="submit" value="submit" class="btn btn-primary btn-large" type="submit">Login!</button> &nbsp;&nbsp; Forget<a href="resetpwd.php">password</a>?
			<h4></h4>
            <h4>Create a new <a href="register.php">account</a>?</h4>
			
	   </form> '; 
} 
 
// lets display our output string. 
echo $sOutput; 

?>

<?php include('includes/footer.html'); ?>