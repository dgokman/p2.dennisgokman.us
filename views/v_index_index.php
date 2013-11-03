<link rel="stylesheet" type="text/css" href="css/sample-app.css"/>
<div id="welcome">
<h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1><br>
<a href="/posts/add">Make a post</a><br>
<a href="/posts/index">View Posts</a><br>
<a href="/posts/follow">Start following</a><br>
</div>
<p>+1 Features: E-mail Confirmation upon sign-up, Upload a profile photo</p>
