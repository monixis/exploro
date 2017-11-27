<!DOCTYPE html>
<html lang="en">
<head>
  <title>eXploro EAD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/bootstrap.css">
  <link rel="stylesheet" href="styles/boxbuilder.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>

   </script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src='http://library.marist.edu/archives/mainpage/images/exploro.jpg'/></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <!--li class="active"><a href="#">Home</a></li-->
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li-->
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <!--p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p-->
    </div>
    <div class="col-sm-8 text-left">
      <?php
      $xml = simplexml_load_file($url);
      echo print_r($xml->archdesc->did->repository->address->addressline);
      ?>
      <!-- Display the name of the collection -->
      <h1 class="heading"> <?php echo $xml->control->filedesc->titlestmt->titleproper; ?></h1>

      <!-- Display the repository details found in index.xml -->
      <h3>
        <b>Repository</b>
      </h3>
      <p><?php echo $xml->archdesc->did->repository->corpname->part ?></p>
      <p><?php echo $xml->archdesc->did->repository->address->addressline; ?></p>
      <p>Phone: <?php echo $xml->archdesc->did->repository->address->addressline[1]; ?></p>
      <p>Fax</p>
      <p>Email</p>

      <h4 class="indHeading"><a href="http://library.marist.edu/archives/<?php echo $cid?>/report/" target="_blank">NHPRC Grant Report</a></h4>

    </div>
  </div>
</div>

<footer class="container-fluid text-center">
	<?php $this->load->view('footer'); ?>
</footer>

</body>
</html>
