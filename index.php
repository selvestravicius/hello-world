<?php
session_start();
require_once 'Dbconnect.php';

if (isset($_SESSION['userSession'])!="") {
 header("Location: home.php" );
 exit;
}

if (isset($_POST['btn-login'])) {

 $email = strip_tags($_POST['email']);
 $password = strip_tags($_POST['password']);

 $email = $DBcon->real_escape_string($email);
 $password = $DBcon->real_escape_string($password);

 $query = $DBcon->query("SELECT * FROM tbl_users WHERE email='$email'");
 $row=$query->fetch_array();

 $count = $query->num_rows; // if email/password are correct returns must be 1 row

 if (password_verify($password, $row['password']) && $count==1) {
  $_SESSION['userSession'] = $row['user_id'];

 header('Location: home.php' );
 } else {
  $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
    </div>";
 }

 $DBcon->close();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dienotvarke</title>

<?php include_once 'head.html';?>
</head>
<body>

<div class="signin-form">

 <div class="container">


       <form class="form-signin" method="post" id="login-form">

        <h2 class="form-signin-heading">Darbuotojų dienotvarkės administravimo sistema</h2><hr />

        <?php
  if(isset($msg)){
   echo $msg;
  }
  ?>

        <div class="form-group">
        <input type="email" class="form-control" placeholder="El-paštas" name="email" required />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" placeholder="Slaptažodis" name="password" required />
        </div>

      <hr />

        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
                <span class="glyphicon glyphicon-log-in"></span> &nbsp; Prisijungti
            </button>

            <a href="register.php" class="btn btn-default" style="float:right;">Registruotis čia</a>

        </div>
      </form>
    </div>
</div>

</body>
</html>
