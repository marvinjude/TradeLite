     <?php session_start();

     $connection =  include_once('resources/conection.inc.php');

     if(isset($_SESSION['user']))
     {
      header("location:sales/sell.php");
     }

    if (isset($_POST['submit']))
    { 
      $username = htmlentities($_POST['username']);
      $username = strtoupper(mysqli_real_escape_string($connection,$username));


      $password = htmlentities($_POST['password']);
      $password = strtoupper(mysqli_real_escape_string($connection,$password));
      
      $usertype = NULL;

      if($_POST['usertype'] == 'User'){
        $usertype = 1;
      }else if($_POST['usertype'] == 'Super User'){
        $usertype = 2;
      }
      
      $query = "SELECT * FROM users where username = '$username' AND password = '$password' AND type = '$usertype' ";
      // echo $query;
      $result = mysqli_query($connection, $query);
      $count = mysqli_num_rows($result);

      if($count == 1)
      {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['user'] = serialize($data);
        header("location:sales/sell.php");   // this seems to be the mos uses  page 
      }   
      else
      {
        $_SESSION['login_error'] = 'error';
        // echo 'false data';
      }

    }
    ?>


    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>MUKAZ |Login</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      
      <!-- Ionicons -->
      <link rel="stylesheet" href="css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="css/AdminLTE.min.css">

      <link rel="stylesheet" href="css/animate.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="css/font-awesome.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">


.center-div{
  margin-top:10%;
}

input,select {
  text-transform: uppercase;
}

</style>
</head>


<body class="hold-transition skin-blue sidebar-mini" style = 'background-color: whitesmoke '>   

 <header class="main-header">
  <!-- Logo -->
  <a href="index.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>MUKAZ NIG.</b>LTD.</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <div class="navbar-custom-menu">

    </div>
  </nav>
</header>

<div class= "container-fluid">
  <div class = "row">
    <div class = "col col-md-4 col-xs-12 col-sm-4 col-xs-10 col-xs-offset-1 col-md-offset-4 center-div">




     <div class="box box-primary box-solid no-border">
      <div class="box-header with-border">
        <h3 class="box-title">Login</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start --> 
      <div class="box-body" style="padding: 30px">
        <form class="form-horizontal" method = 'POST' action = '<?php echo $_SERVER['PHP_SELF']?>'>

          <div class="row">

            <!-- check if there is error in the session -->
            <?php if (isset($_SESSION['login_error'])): ?>
              <div class="alert alert-danger">wrong username and password combination </div>
              <?php unset($_SESSION['login_error']) ?>
            <?php endif ?>

            <div class="col col-md-12">
              <div class="form-group holder ">
               <label for="inputEmail3" control-label">Username</label>
               <input autocomplete="off" autofocus="true" type="text" class="form-control  " id="inputEmail3"  placeholder="Username" name = 'username'>
             </div>
           </div>

           <div class="col col-md-12">
             <div class="form-group holder">
              <label for="inputPassword3"  control-label">Password</label>
              <input autocomplete="off" autofocus="true" type="password" class="form-control " id="inputPassword3" placeholder="Password" name = 'password'>
            </div>
          </div>

          <div class="col col-md-12">
            <div class="form-group holder"> 
             <label for="usertype"  control-label">user type</label>  
             <select id = 'usertype' name = 'usertype' style="width: 100%; height: 35px">
               <option>User</option>
               <option>Super User</option>
             </select>
           </div>
         </div>

       </div>


     </div>
     <!-- /.box-body -->
     <div class="box-footer">

      <button type="submit" name = 'submit' class="btn btn-info pull-right input-lg">Sign in</button>

      <button class = 'input-lg btn btn-success pull-left g' >
        <a href="signup.php"  name = 'SignUp' style="color:white" >Register</a>
      </button>
    </div>
  </form>
  <!-- /.box-footer -->

</div>
</div>
</div>
</div>
<script src="js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.min.js"></script>
<script type="text/javascript">

  $('document').ready(function(){

    $('input').click(function(){
        $('.alert').slideUp();
    });

  });
  
</script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>


