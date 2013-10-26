<h1>This is the profile of <?=$user->first_name?></h1>

public function profile($user_name == NULL) {

    /*
    If you look at _v_template you'll see it prints a $content variable in the <body>
    Knowing that, let's pass our v_users_profile.php view fragment to $content so 
    it's printed in the <body>
    */
    $this->template->content = View::instance('v_users_profile');

    /* $title is another variable used in _v_template to set the <title> of the page
    $this->template->title = "Profile";

    #  Set client files that need to load in the <head>
    $client_files_head = Array("/css/profile.css");
    $this->template->client_files_head = Utils::load_client_files($client_files_head);  

    # Set client files that need to load before the closing </body> tag
    $client_files_body = Array("/js/profile.min.js");
    $this->template->client_files_body = Utils::load_client_files($client_files_body);  


    # Pass information to the view fragment
    $this->template->content->user_name = $user_name;

    # Render View
    echo $this-template;

}