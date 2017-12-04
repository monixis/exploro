<!DOCTYPE html>
<html lang="en">
<head>
  <title>eXploro Digital File</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/bootstrap.css">
  <link rel="stylesheet" href="styles/boxbuilder.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
		table {.table-file-information > tbody > tr {
			border-top: 1px solid rgb(221, 221, 221);
		}

		.table-file-information > tbody > tr:first-child {
			border-top: 0;
		}

		.table-file-information > tbody > tr > td {
			border-top: 0;
		}

		}
  </style>
    <?php
	foreach ($results->response->docs as $row) {
		$id = $row -> id;
		$title = (isset($row -> unittitle) ? $row -> unittitle : FALSE);
		$box = (isset($row -> container[0]) ? $row -> container[0] : FALSE);
		$date = (isset($row -> datesingle) ? $row -> datesingle : FALSE);
		$collection = (isset($row -> collection) ? $row -> collection : FALSE);
		$category = (isset($row -> category) ? $row -> category : FALSE);
		$url = (isset($row -> link) ? $row -> link : FALSE);
		$findingaid = (isset($row -> collectionLink) ? $row -> collectionLink : FALSE);
		$rightsstatement = (isset($row -> userestrict[0]) ? $row -> userestrict[0] : FALSE);
		$format = (isset($row -> format[0]) ? $row -> format[0] : FALSE);
		$physdesc = (isset($row -> physdesc) ? $row -> physdesc : FALSE);
		}
    ?>
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
<div class="col-md-2"></div>
<div class="container-fluid text-center col-md-8">
  <div class="row content">

    <div class="col-md-12 text-left">
									 <table class="table table-file-information">
            							<thead>
            								<tr><h4>Details:</h4></tr>
            							</thead>
            							<tbody>
            								<tr>
                								<td class ="col-md-2">Id:</td><td> <?php echo $id ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2">Title:</td><td> <?php echo $title ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2">Box:</td><td> <?php echo $box ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Date:</td> <td><?php echo $date ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Format:</td> <td><?php echo $format ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Physical Description:</td> <td><?php echo $physdesc ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Collection:</td> <td><?php echo $collection ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Category:</td> <td><?php echo $category ?></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Finding aid:</td> <td><a href='<?php echo $findingaid ?>'><?php echo $findingaid ?></a></td>
            								</tr>
            								<tr>
                								<td class ="col-md-2" >Rights Statement:</td> <td><?php echo $rightsstatement ?></td>
            								</tr>
            								<!--tr>
                								<td class ="col-md-2"> Associated Tags:</td>
                								<td>
                    								<?php
                    									foreach ($associatedTags as $associatedTag){?><a href="<?php echo base_url("?c=repository&m=searchResultsByTag&q=" . $associatedTag['tag']); ?>"> <?php echo $associatedTag['tag'] . " , "; ?> </a><?php  } ?>
                    							</td>
                    						</tr-->
            							</tbody>
            						</table>
            						<div style="width: 100%; height: auto; margin-top: 50px;">
            							<img src="<?php echo $url ?>" style="margin-left: auto; margin-right: auto; display: block;"/>
            						</div>
            							<!--iframe src="<?php echo $url ?>" style="width:100%; height:400px;"></iframe-->

								</div>
						</div>
					</div><!-- row -->
          <div class="col-md-12"></div>
  </div>
</div>

<footer class="container-fluid text-center col-md-12">
	<?php $this->load->view('footer'); ?>
</footer>

</body>
</html>
