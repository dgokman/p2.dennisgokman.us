<?php
class users_controller extends base_controller {


    public function __construct() {
        parent::__construct();
    } 

    public function signup() {

        # Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";

        # Render template
            echo $this->template;
        

    }

    public function p_signup() {
         
        # Search the db for input email
        $q = "SELECT email 
        FROM users 
        WHERE email = '".$_POST['email']."'";
        

        $email = DB::instance(DB_NAME)->select_field($q);

        # If we find a matching e-mail, signup has failed
        if($email) {
        die("<link rel='stylesheet' type='text/css' href='../css/sample-app.css' />" . '<p>Someone has signed up with that e-mail address</p>' . '<br>' . '<a href="/users/signup">Back to Sign Up</a>');
          }
        
        # More data we want stored with the user
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();
        
        # Encrypt the password  
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 


        # Dump out the results of POST to see what the form submitted
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);
        
        #Check that all fields have been entered
        if (!$_POST['first_name'] || !$_POST['last_name'] || !$_POST['email'] || !$_POST['password'])
         {
        die("<link rel='stylesheet' type='text/css' href='../css/sample-app.css' />" . '<p>You did not complete all of the required fields</p>' . '<br>' . '<a href="/users/signup">Back to Sign Up</a>');
          }
        
        
        
        #Send e-mail upon registration
        $to = $_POST['email'];
        $subject = "Welcome to Sweatr!";
        $message = "Hello! Thank you for joining Sweatr. Now start posting and following!";
        mail($to,$subject,$message);
        echo "<link rel='stylesheet' type='text/css' href='../css/sample-app.css' />" . '<p>You\'re signed up and have received e-mail confirmation</p>' . '<br>' . '<a href="/users/login">Back to Sweatr</a>';  
             
    }
    
    public function login($error = NULL) {

    # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";
        
    # Pass data to the view
        $this->template->content->error = $error;

    # Render template
        echo $this->template;
    

    }
    
    public function p_login() {

    # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
    $_POST = DB::instance(DB_NAME)->sanitize($_POST);

    # Hash submitted password so we can compare it against one in the db
    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
    
    #Check that all fields have been entered
        if (!$_POST['email'] || !$_POST['password'])
         {
        Router::redirect("/users/login/error");
          }

    # Search the db for this email and password
    # Retrieve the token if it's available
    $q = "SELECT token 
        FROM users 
        WHERE email = '".$_POST['email']."' 
        AND password = '".$_POST['password']."'";

    $token = DB::instance(DB_NAME)->select_field($q);

    # If we didn't find a matching token in the database, it means login failed
    if(!$token) {

       # Note the addition of the parameter "error"
        Router::redirect("/users/login/error"); 
    }
    else {

        /* 
        Store this token in a cookie using setcookie()
        Important Note: *Nothing* else can echo to the page before setcookie is called
        Not even one single white space.
        param 1 = name of the cookie
        param 2 = the value of the cookie
        param 3 = when to expire
        param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
        */
        setcookie("token", $token, strtotime('+2 weeks'), '/');

        # Send them to the main page - or whever you want them to go
        Router::redirect("/");

    }
    }
    public function profile() {

    # If user is blank, they're not logged in; redirect them to the login page
    if(!$this->user) {
        Router::redirect('/users/login');
    }

    # If they weren't redirected away, continue:

    # Setup view
    $this->template->content = View::instance('v_users_profile');
    $this->template->title   = "Profile Page of". $this->user->first_name;
    

    # Render template
    echo $this->template;
}
   public function logout() {

    # Generate and save a new token for next login
    $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

    # Create the data array we'll use with the update method
    # In this case, we're only updating one field, so our array only has one entry
    $data = Array("token" => $new_token);

    # Do the update
    DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

    # Delete their token cookie by setting it to a date in the past - effectively logging them out
    setcookie("token", "", strtotime('-1 year'), '/');

    # Send them back to the main index.
    Router::redirect("/");

}


   #Allow image uploading
   
   public function p_upload() {
   $allowedExts = array("gif", "jpeg", "jpg", "png");
   $temp = explode(".", $_FILES["file"]["name"]);
   $filename = $_FILES["file"]["name"];
   $extension = end($temp);
   if ((($_FILES["file"]["type"] == "image/gif")
   || ($_FILES["file"]["type"] == "image/jpeg")
   || ($_FILES["file"]["type"] == "image/jpg")
   || ($_FILES["file"]["type"] == "image/pjpeg")
   || ($_FILES["file"]["type"] == "image/x-png")
   || ($_FILES["file"]["type"] == "image/png"))
   && ($_FILES["file"]["size"] < 20000)
   && in_array($extension, $allowedExts))
    {
   if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
    echo "<link rel='stylesheet' type='text/css' href='../css/sample-app.css' />" . "<p>You have uploaded a picture</p>" . "<br><a href='/users/profile'>Back to profile</a><br>";

   #Check if file exists and save to uploads folder
    if (file_exists("uploads/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "uploads/" . $_FILES["file"]["name"]);
      
    #Shows uploaded image
      $url = "<img src='../uploads/" . $_FILES["file"]["name"] . "'></img>";
      echo "<img src='../uploads/" . $_FILES["file"]["name"] . "'></img>";
       }
      }
     }
     else
      {
     echo "<link rel='stylesheet' type='text/css' href='../css/sample-app.css' />" . "<p>Invalid file</p>" . "<br><a href='/users/profile'>Back to profile</a><br>";
      }
  

  }

} # eoc