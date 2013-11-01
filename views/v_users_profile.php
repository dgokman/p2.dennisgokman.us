<html>
<body>
<h1>This is the profile of <?=$user->first_name?></h1>


<form action="p_upload" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>
<?php 
{
echo "<img src=" . "'/uploads/" . $name . "'>" . "</img>";
}
?>
</body>
</html>

