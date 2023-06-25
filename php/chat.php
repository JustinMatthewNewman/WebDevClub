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
$outgoing_msg_id = "";
$incoming_msg_id = "";
$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (:incoming_msg_id, :outgoing_msg_id, :msg)";
    // Prepare an insert statement
    $outgoing_msg_id = $_SESSION['id'];
    $_SESSION['value'] = $_GET['value'];
    $incoming_msg_id = $_SESSION['value'];
    $msg = $_POST['msg'];
    // echo $outgoing_msg_id;
    // echo $incoming_msg_id;
    // echo $msg;
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":incoming_msg_id", $param_incoming_msg_id, PDO::PARAM_INT);
        $stmt->bindParam(":outgoing_msg_id", $param_outgoing_msg_id, PDO::PARAM_INT);
        $stmt->bindParam(":msg", $param_msg, PDO::PARAM_STR);
        
        // Set parameters
        $param_incoming_msg_id = $incoming_msg_id;
        $param_outgoing_msg_id = $outgoing_msg_id;
        $param_msg = $msg;
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            //echo "sent";
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        // Close statement
        unset($stmt);
    } else {
        echo "Error";
    }
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
        <?php 
          // Grabs the user's data from the database.
          $name = $_SESSION['username'];
          $_SESSION['value'] = $_GET['value'];
          $person = $_SESSION['value'];
          $query = $pdo->prepare("SELECT * from users where id = $person");
          $query->execute();
          $user = $query->fetch();
        ?>
        <a href="welcome.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <?php
          // Grabs the user's profile photo (if they have set any).
          if($user['photo'] != ""){
             ?><img src="<?php echo $user['photo']?>" alt=""><?php
          } else {
             ?><img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg" alt=""><?php
          } 
        ?>

        <div class="details">
          <span><?php echo $user['username'] ?></span>
        </div>
        <a id ="button1" onclick="del()" class="edit">•••</a>
        <a id="cancel" style="display:none;" onclick="cancel()" class="edit">Cancel</a>

      </header>
    <div class="chat-box">
      

    <?php 
      session_start();
      /**
       * Starts a session and grabs the users sent, and recieved messages.
       * Also, creates a visual aspect of the page to allow users to navigate much easier.
       */
      if(isset($_SESSION['id'])){
        $outgoing_id = $outgoing_msg_id;
        $incoming_id = $incoming_msg_id;
        $output = "";
        $currentUser = $_SESSION['id'];
        $sentTo = $person;
        $query = $pdo->prepare("SELECT * from messages");
        $query->execute();
        $messages = $query->fetchAll();
        $count = 0;
        foreach ($messages as $msg) {
                if($msg['outgoing_msg_id'] === $currentUser AND $msg['incoming_msg_id'] === $sentTo){
                    $count += 1;
                    $output .= '<div id="'.$msg['msg_id'].'" class="chat outgoing">
                                <div class="details">
                                    <p>'. $msg['msg'] .'</p>
                                </div><button class="button2" style="display:none;" onclick="delFromPage('.$msg['msg_id'].')">×</button>
                                </div> ';
                }
                if($msg['outgoing_msg_id'] === $sentTo AND $msg['incoming_msg_id'] === $currentUser) {
                  $count += 1;
                    if ($user['photo'] != "") {
                      $output .= '<div class="chat incoming">
                      <img src=" ' . $user['photo'] . ' " alt="">
                      <div class="details">
                          <p>'. $msg['msg'] .'</p>
                      </div>
                      </div>';
                    } else {
                      $output .= '<div class="chat incoming">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg" alt="">
                      <div class="details">
                          <p>'. $msg['msg'] .'</p>
                      </div>
                      </div>';
                    }
                }
                echo $output;
                $output = "";
            }
            if ($count <= 0)
            {
              echo "No messages yet! Say something to " . $user['username'];
            }

    }
?>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?value=" . $person;  ?>" method="post" class="typing-area">
        <input type="text" class="incoming_msg_id" name="incoming_msg_id" value="<?php echo $incoming_msg_id; ?>" hidden>
        <input type="text" class="outgoing_msg_id" name="outgoing_msg_id" value="<?php echo $outgoing_msg_id; ?>" hidden>
        <input type="text" name="msg" class="form-control" placeholder="Type a message...">
        <input class="send-btn" type="submit" value="Send">
      </form>
    </section>
  </div>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>

  /**
   * Changes from chat to edit mode. Allows users to delete their own messages.
   */
  function del() {
    const a = Array.from(document.getElementsByClassName('button2'));
    a.forEach(e =>{
      e.style.display = 'block'; 
    })
    document.getElementById('button1').style.display = 'none'; 
    document.getElementById('cancel').style.display = 'block';
  }

  /**
   * Changes from edit mode to chat mode.
   */
  function cancel() {
    document.getElementById('button1').style.display = 'block'; 
    document.getElementById('cancel').style.display = 'none';

    const a = Array.from(document.getElementsByClassName('button2'));
    a.forEach(e =>{
      e.style.display = 'none'; 
    })    
  }

  /**
   * Deletes a given message from a chat.
   * @param number: the id number for the given message
   */
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
