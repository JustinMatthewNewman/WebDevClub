<?php
// Initialize the session
session_start();
// Include config file
require_once "config.php";
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
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
      <a href="welcome.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>

      </header>
      <div class="chat-box">
      <?php 
    if(isset($_SESSION['id'])){
        $outgoing_id = $outgoing_msg_id;
        $incoming_id = $incoming_msg_id;
        $output = "";
        $currentUser = $_SESSION['id'];
        $sentTo = $person;
        $query = $pdo->prepare("SELECT * from messages");
        $query->execute();
        $messages = $query->fetchAll();
        foreach ($messages as $msg) {
             ?> <div id="<?php echo $msg['msg_id']; ?>" class="chat incoming"> <?php echo $msg['msg']; ?> &nbsp <button class="button2" onclick="delFromPage(<?php echo $msg['msg_id']; ?> )">×</button></div> <?php
            }
    }
?>
      </div>
    </section>
  </div>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
  <script>
        function delFromPage(number) {
      document.getElementById(number).remove();
    var userdata = {'msgid':number};
    $.ajax({
            type: "POST",
            url: "delete.php",
            data:userdata, 
            success: function(data){
                console.log(data);
            }
            });     
  }
  </script>
</body>
</html>
