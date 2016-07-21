<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $title?></title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/navbar.css" rel="stylesheet">
    
    <link href="/css/offcanvas.css" rel="stylesheet">
    
     <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <div class="container" style="height:10px;">
	    <p style="float:right!important;margin-top:-15px;"><?php echo $_COOKIE['loginname']?></p>
	   </div>
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
    
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">JOYHR</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li <?php if($title=='主页'){ echo ' class="active"';} ?>><a href="/comm/index">Home</a></li>
              <li <?php if($title=='组织结构'){ echo ' class="active"';} ?>><a href="/org/index">组织结构</a></li>
              <li <?php if($title=='员工管理'){ echo ' class="active"';} ?>><a href="/user/index">员工管理</a></li>
              <li <?php if($title=='工资管理'){ echo ' class="active"';} ?>><a href="#">工资管理</a></li>
              <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">员工管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li <?php if($title=='新建员工'){ echo ' class="active"';} ?>><a href="index.php?ctr=user&act=creat">新建员工</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li> -->
              
             
            </ul>
            <!--<ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="../navbar-static-top/">Static top</a></li>
              <li><a href="../navbar-fixed-top/">Fixed top</a></li>
            </ul>
          </div>--><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      

      <div class="container">
