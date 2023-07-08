

<?php
session_start();

// Database connection details
$host = 'localhost';
$db_name = 'root';
$db_user = 'CP476';
$db_password = 'password';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate credentials against user table in the database
  // You need to implement the logic to query the user table and validate the credentials
  

  try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      // Successful login, set session variable
      $_SESSION['username'] = $user['username'];
      // Redirect to a logged-in page or display a success message
      header('Location: dashboard.php');
      exit;
    } else {
      // Invalid credentials, display an error message
      $error = 'Invalid username or password';
    }
  } catch (PDOException $e) {
    // Handle database connection errors
    $error = 'Database Error: ' . $e->getMessage();
  }
}

// Display the login form and error message (if any)
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <?php if (isset($error)) echo "<p>$error</p>"; ?>
  <form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Login">
  </form>
</body>
</html>
