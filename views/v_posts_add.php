<link rel="stylesheet" type="text/css" href="../css/sample-app.css" />

<form method='POST' action='/posts/p_add'>

    <label for='content'>New Post:</label><br>
    <textarea name='content' id='content' rows='15' columns='25'></textarea>

    <br><br>
    <input type='submit' value='New post'>

</form> 

<!-- Ajax results will go here -->
<div id='results'></div>