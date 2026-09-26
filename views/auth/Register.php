<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>

<body>

    <h2>Create Account</h2>

    <form method="POST" action="/Photo-sharing-application/Controller/UserController.php">

        <label>First Name:</label>
        <input type="text" name="first_name" required>
        <br><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" required>
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <label>Location:</label>
        <input type="text" name="location">
        <br><br>

        <label>Description:</label>
        <textarea name="description"></textarea>
        <br><br>

        <label>Occupation:</label>
        <input type="text" name="occupation">
        <br><br>

        <button type="submit" name="register">Register</button>

    </form>

</body>
</html>