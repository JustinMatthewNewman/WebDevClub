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
    <li><a href="../index.html">Home</a></li>
    <li><a href="../about.html">About</a></li>
    <li><a href="../projects.html">Projects</a></li>
    <li><a href="../graphs.html">Graphs</a></li>
    <li><a id ="signout" href="./login.php">Chat</a></li>
    </ul>
    <div class="icon">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>

  </nav>
    <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
        <?php 
          if($_SESSION['photo'] != ""){
             ?><img src="<?php echo $_SESSION['photo']?>" alt=""><?php
          } else {
             ?><img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg" alt=""><?php
          } ?>
          <div class="details">
            <span><?php echo htmlspecialchars($_SESSION["username"]); ?>
            <a href="profile.php" class="profile">⚙</a>
          </span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <?php 
        if ($_SESSION["admin"] != 0) { ?>
          <a href="admin.php" class="logout">Admin Panel</a>
        <?php } ?>
        <a href="logout.php" class="logout">Log out</a>
        
      </header>
      <div class="search">
        <span class="text">Select an user to start chat</span>
      </div>
      <div class="users-list">
      </div>
    </section>
  </div>
  <script>
    usersList = document.querySelector(".users-list");
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
            usersList.innerHTML = data;
        }
    }
  }
  xhr.send();
  </script>
</body>
</html>