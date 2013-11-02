<link rel="stylesheet" type="text/css" href="../css/sample-app.css" />
<link rel="stylesheet" type="text/css" href="/css/sample-app.css" />
<form method='POST' action='/users/p_login'>

    Email<br>
    <input type='text' name='email'>

    <br><br>

    Password<br>
    <input type='password' name='password'>

    <br><br>
    <?php if(isset($error)): ?>
        <p>
            Login failed. Please double check your email and password.
        </p>
        <br>
    <?php endif; ?>
    <input type='submit' value='Log in'>

</form>