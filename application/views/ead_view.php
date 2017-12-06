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
	$(document).ready(function() {
		var isOpen = false;
		var $tdata = $('table.tbl');
		$tdata.find('tr.tbldata').hide();
		$('tr.Box').click(function() {
			$(this).parent().find('tr.tbldata').toggle();
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
		<button type="button" class="btn btn-primary"><a href='<?php echo base_url("?c=exploro&m=viewCollectionEAD&cid=$cid");?>' target='_blank' style='text-decoration: none; color: #ffffff;'>Collection Page</a></button>
	<?php } ?>

	<?php foreach ($xml->xpath("//filedesc") as $seriesInfo) { ?>
		<div id="breadcrumb"><p><?php echo $seriesInfo -> notestmt -> controlnote -> p; ?></p></div>
	<?php } ?>
</div>

<div id="componentList">
<?php foreach ($xml->xpath("//*[@level='recordgrp']") as $box) { ?>

 	 <table class="tbl" align="center" style="margin-bottom: 15px; width: 60%;" >
		 	<tr class="Box">
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
 					<td class="tableFont"><?php echo $item -> did -> unitid; ?></td>
 					<?php if (isset($item->dao)) { ?>
	 					<td class="tableFont"><a title="<?php echo $item -> did -> unittitle; ?>" name="<?php echo $item -> dao['href']; ?>" class="modal_link"><?php echo $item -> did -> unittitle; ?></a></td>
 					<?php }else{ ?>
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

<!-- Create the image for the modal ... based on https://stackoverflow.com/questions/25023199/bootstrap-open-image-in-modal#25023822 -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="width: 385px; max-height: 525px; display: block; margin:auto;" >
      </div>
      <div class="modal-footer">
        <button id="prevBtn" style="float:left;" type="button" class="btn btn-default">Previous</button>
        <button id="nextBtn" style="float:right;" type="button" class="btn btn-default">Next</button>
      </div>
    </div>
  </div>
</div>
<style>
  .modal_link {
    cursor: pointer;
  }
</style>
<script>
  // Script for the modal image preview
  $(".modal_link").on("click", function() {
   $('#imagepreview').attr('src', $(this).attr('name')); // here asign the image to the modal when the user click the enlarge link
   $("#myModalLabel").html($(this).attr("title"));
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function


   // Hide both buttons by default... then check what buttons should be shown
   $("#prevBtn").css("visibility", "hidden");
   $("#nextBtn").css("visibility", "hidden");
   if ( $(this).parent().parent().prev().hasClass('record') ) {
     $("#prevBtn").css("visibility", "visible");
   }
   if ( $(this).parent().parent().next().hasClass('record') ) {
     $("#nextBtn").css("visibility", "visible");
   }

  });

 // Script for previous button on modal image preview
 $("#prevBtn").on("click", function() {
   alert("Previous button clicked");
 });

 // Script for next button on modal image preview
 $("#nextBtn").on("click", function() {
   // alert("Next button clicked");
 });

</script>

<footer class="container-fluid text-center">
	<?php $this->load->view('footer'); ?>
</footer>

</body>
</html>
