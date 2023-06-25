
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/chat_style_nav.css">
</head>
<body>  
<nav>
    <ul class="nav-links">
      <li><a href="./index.html">Home</a></li>
      <li><a href="./about.html">About</a></li>
      <li><a href="./projects.html">Projects</a></li>
      <li><a href="./graphs.html">Graphs</a></li>
      <li><a id ="signout" href="./login.php">Chat</a></li>
    </ul>
  </nav>
    <div class="wrapper">
    <section class="users">
      <header>
      <a href="welcome.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <div class="content">
        <?php 
          if($_SESSION['photo'] != ""){
             ?><img src="<?php echo $_SESSION['photo']?>" alt=""><?php
          } else {
             ?><img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg" alt=""><?php
          } ?>
          <div class="details">
            <span><?php echo htmlspecialchars($_SESSION["username"]); ?>
          </span>
          </div>
        </div>
        
        <a href="logout.php" class="logout">Log out</a>
      </header>
<?php
session_start();
require_once "config.php";
      $id = $_SESSION["id"];
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
      // Prepare a select statement
      $sql = "SELECT id, username, admin, password, photo FROM users WHERE id = $id";
      if($stmt = $pdo->prepare($sql)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
          // Attempt to execute the prepared statement
          if($stmt->execute()){
              // Check if username exists, if yes then verify password
                  if($row = $stmt->fetch()){
                      $id = $row["id"];
                          // Password is correct, so start a new session
                          session_start();
                          $p = $_POST['photoIMG'];
                          $query = $pdo->prepare("UPDATE `users` SET `photo` = '$p' WHERE id = $id");
                          if($query->execute()){
                          // Redirect user to welcome page
                          header("location: login.php");
                          } 
                      }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
          // Close statement
          unset($stmt);
      }
    }
  // Close connection
  unset($pdo);
      unset($query);
?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Enter Link To Photo</label>
                <input type="text" name="photoIMG" class="form-control" value="<?php echo $photo; ?>">
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <a href="reset-password.php" class="logout">Reset Password</a>
    </section>
  </div>

</body>
</html>