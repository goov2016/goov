<?php

echo <<<END

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>JOYHR Login</title>

    <!-- Bootstrap core CSS -->
    <link href="/lisphp/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/lisphp/css/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/lisphp/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">JOYHR</a>
          </div>
        </div><!--/.container-fluid -->
      </nav>

	
	<div class="row">
        <div class="col-md-8">
          <h2>Welcom JOYHR</h2>
          <p>This is beatiful website!</p>
        </div>
        <div class="col-md-3">
          <form class="form-signin" action="index.php?ctr=comm&act=index" method="post">
	        <h2 class="form-signin-heading">登录</h2>
	        <label for="inputEmail" class="sr-only">Email address</label>
	        <input type="email" name="name" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		    <br/>
	        <label for="inputPassword" class="sr-only">Password</label>
	        <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="Password" required>
	        <div class="checkbox">
	          <label>
	            <input type="checkbox" value="remember-me"> Remember me
	          </label>
	        </div>
	        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
	      </form>
       </div>
       
      </div>
		
		


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/lisphp/js/jquery-1.11.2.js"></script>
    <script src="/lisphp/bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/lisphp/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

END;

?>
