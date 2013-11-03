
<link rel="stylesheet" type="text/css" href="../css/sample-app.css" />

<h1>Profile Page for <?=$user->first_name?></h1>


<form action="p_upload" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>



