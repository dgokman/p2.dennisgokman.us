<link rel="stylesheet" type="text/css" href="../css/sample-app.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<form method='POST' action='/posts/p_add'>

    <label for='content'>New Post:</label><br>
    <textarea name='content' id='content' rows='15' columns='25'></textarea>

    <br><br>
    <input type='submit' value='New post'>

</form> 

<!-- Ajax results will go here -->
<div id='results'></div>