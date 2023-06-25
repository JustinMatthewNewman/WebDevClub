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
    <link rel="stylesheet" href="../css/style2.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <!-- <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1> -->

        <?php 
        // Include config file
            require_once "config.php";
            $name = $_SESSION['username'];
            $query = $pdo->prepare("SELECT * from users");
            $query->execute();
            $users = $query->fetchAll();
            foreach ($users as $user) {
                if ($user['id'] != $_SESSION['id']) {
                    
          ?>

        <a href="chat.php?value=<?php echo $user['id']; ?>">
        <div class="content">
          <?php 
          if($user['photo'] != ""){
             ?><img src="<?php echo $user['photo']?>" alt=""><?php
          } else {
             ?><img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg" alt=""><?php
          } ?>
          <div class="details">
            <span><?php echo $user['username']; ?></span>
          </div>
        </div>
        
        <?php 
      if ($user['status'] == 1)
      {
        ?> <div class="status-dot"><i class="fas fa-circle"></i><p>Online</p></div> <?php
      } else { ?>
        <div class-"status-dot"><i class="fas fa-circle"></i><p>away</p></div> <?php
      }
      }} ?>
        </a>
      <div class="users-list">
      </div>
    </div>
</body>
</html>