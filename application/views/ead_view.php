<!DOCTYPE html>
<html lang="en">
<head>
  <title>eXploro EAD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url("/styles/bootstrap.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("/styles/boxbuilder.css"); ?>">
  
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url("styles/prettyPhoto.css"); ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript" type="text/javascript"></script>
  <script src="<?php echo base_url("js/jquery.prettyPhoto.js"); ?>" type="text/javascript" charset="utf-8"></script>
  <script>
	$(document).ready(function() {
		var isOpen = false;
		var $tdata = $('table.tbl');
		$tdata.find('tr.tbldata').hide();
		$('tr.Box').click(function() {
			$(this).parent().find('tr.tbldata').toggle();
    });
    $("a[rel^='prettyPhoto']").prettyPhoto({
      overlay_gallery: true,
      theme: 'facebook',
      social_tools: '',
      opacity: 0.20,
      deeplinking: false
    });
	});
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
$collectionId = $cid;
$collectionUrl = base_url('eads/'.$collectionId.'/index.xml');
$xml = simplexml_load_file($url);
?>

<div id="descSummary">
	<?php foreach ($xml->xpath("//archdesc") as $info) { ?>
		<h1 class="heading"><?php echo $info -> dsc -> c01 -> did -> unittitle; ?></h1>
		<h2 class="heading"><?php echo $info -> did -> unitid; ?> - <?php echo $info -> did -> unittitle; ?></h2>
		<p><label>Repository: </label><a href='http://library.marist.edu/archives' target='_blank'><?php echo $info -> did -> repository -> corpname -> part; ?></a></p>
		<p><label>Creator: </label><?php echo $info -> did -> origination -> persname -> part; ?></p>
		<button type="button" class="btn btn-primary"><a href='<?php echo base_url("exploro/viewCollectionEAD"). "/".$cid ;?>' target='_blank' style='text-decoration: none; color: #ffffff;'>Collection Page</a></button>
	<?php } ?>

	<?php foreach ($xml->xpath("//filedesc") as $seriesInfo) { ?>
		<div id="breadcrumb"><p><?php echo $seriesInfo -> notestmt -> controlnote -> p; ?></p></div>
	<?php } ?>
</div>

<div id="componentList">
<?php foreach ($xml->xpath("//*[@level='recordgrp']") as $box) { ?>

 	 <table class="tbl" align="center" style="margin-bottom: 15px; width: 60%;" >
		 	<tr class="Box" name="<?php echo $box -> did -> container ?>">
 				<td class="caption" colspan="8"><?php echo $box -> did -> container; ?></td>
 			</tr>
 			<tr class="tbldata">
      			<th style="width:50px">Item</th>
      			<th style="width:600px">Title</th>
	  			<th style="width:100px">Date</th>
	  			<th style="width:75px">Size (inches)</th>
 			</tr>

 			<?php foreach ($box->did->children() as $item) {
 				if($item->getname() != 'container'){
 			?>
 				<tr class="tbldata record">
 					<td class="tableFont itemNum"><?php echo $item -> did -> unitid; ?></td>
 					<?php if (isset($item->dao)) { ?>
            <?php // Need to check to see if the DAO is a pdf
              $linkInfo = pathinfo($item->dao['href']);
              $fileExtension = $linkInfo['extension'];

              // Handle pdfs different than JPG and PNG
              if ($fileExtension == "pdf") {?>
                <td class="tableFont"><a title="<?php echo $item -> did -> unittitle; ?>" href="<?php echo $item -> dao['href']; ?>" target="_blank"><?php echo $item -> did -> unittitle; ?></a></td>
            <?php }
              else {?>
       					<!--td class="tableFont"><a title="<//?php echo $item -> did -> unittitle; ?>" name="<//?php echo $item -> dao['href']; ?>" class="modal_link"><//?php echo $item -> did -> unittitle; ?></a></td-->
                 <td class="tableFont"><a title="<?php echo $item -> did -> unittitle; ?>" name="<?php echo $item -> dao['href']; ?>" href="<?php echo $item -> dao['href']; ?>" rel="prettyPhoto[gallery]"><?php echo $item -> did -> unittitle; ?></a></td>
            <?php }
          } else{ ?>
 						<td class="tableFont"><?php echo $item -> did -> unittitle; ?></td>
 					<?php } ?>
 					<?php if (isset($item->did->unitdatestructured->datesingle)) { ?>
	 					<td class="tableFont"><?php echo $item -> did -> unitdatestructured -> datesingle; ?></td>
 					<?php }elseif (isset($item->did->unitdatestructured->daterange)){ ?>
 						<td class="tableFont"><?php echo $item -> did -> unitdatestructured -> fromdate; ?> - <?php echo $item -> did -> unitdatestructured -> todate; ?></td>
 					<?php } ?>
 					<td class="tableFont"><?php echo $item -> physdescstructured -> dimensions; ?></td>
 				</tr>
 			<?php }} ?>
 	</table>
<?php } ?>

		</div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
	<?php $this->load->view('footer'); ?>
</footer>
</body>
</html>
