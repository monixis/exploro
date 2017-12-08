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
       					<td class="tableFont"><a title="<?php echo $item -> did -> unittitle; ?>" name="<?php echo $item -> dao['href']; ?>" class="modal_link"><?php echo $item -> did -> unittitle; ?></a></td>
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

<!-- Create the image for the modal ... based on https://stackoverflow.com/questions/25023199/bootstrap-open-image-in-modal#25023822 -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="display: block; margin:auto;" >
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

  @media(max-width: 1023px) {
    .modal-content {
      text-align: center;
      vertical-align: middle;
    }
    #imagepreview {
      max-height: 525px;
      width: 450px;
    }
  }

  @media(min-width: 1024px) {
    .modal-content {
      position: absolute;
      right: -14%;
      text-align: center;
      vertical-align: middle;
      width: 800px !important;
    }
    #imagepreview {
      max-height: 750px;
      width: 750px;
    }
  }
</style>
<script>
   // Script for the modal image preview
   $(".modal_link").on("click", function() {
   // Clear any previously active resources
   $(".active").removeClass("active");

   // Give the selected photo link's row the `active` class to keep track of what link is active..   used for next/previous
   $(this).parent().parent().addClass("active");

   $('#imagepreview').attr('src', $(this).attr('name')); // here asign the image to the modal when the user click the enlarge link
   $(".active").prev(".Box").addClass("tempBox");
   $("#myModalLabel").html($(this).attr("title") + " - Box Number: " +  $(".active").prevAll(".Box").attr('name')  + " Item Number: " + $(".active .itemNum").text());
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
   previous();
 });

 // Script for next button on modal image preview
 $("#nextBtn").on("click", function() {
   next();
 });

 $(".modal").keydown(function(e) {
   // Left key press
   if(e.keyCode == 37) {
     if ( $("#prevBtn").is(':visible') ) {
      previous();
     }
   }
   // Right key press
   else if(e.keyCode == 39) {
     if ( $("#nextBtn").is(':visible') ) {
       next();
     }
   }
 });

 function next() {
   // Add the next class to the next row temporarily to access it in below lines
   $(".active").next().addClass("next");

   // Change the text and picture of modal
   $('#imagepreview').attr('src', $(".next td a").attr('name')); // here asign the image to the modal when the user click the enlarge link
   $("#myModalLabel").html($(".next td a").attr("title"));

   // Remove active from old resource and make new resource active
   $(".active").removeClass("active");
   $(".next").addClass("active");
   $(".next").removeClass("next");

   // Handle buttons for new resource
   $("#prevBtn").css("visibility", "hidden");
   $("#nextBtn").css("visibility", "hidden");
   if ( $(".active").prev().hasClass('record') ) {
     $("#prevBtn").css("visibility", "visible");
   }
   if ( $(".active").next().hasClass('record') ) {
     $("#nextBtn").css("visibility", "visible");
   }
 }

 function previous(){
   // Add the previous class to the previous row temporarily to access it in the below lines
   $(".active").prev().addClass('previous');

   // Change the text and picture of modal
   $('#imagepreview').attr('src', $(".previous td a").attr('name')); // here asign the image to the modal when the user click the enlarge link
   $("#myModalLabel").html($(".previous td a").attr("name") + " - Box Number: <?php echo $box ?> Item Number: " + $(".previous .itemNum").val());

   // Remove active from old resource and make new resource active
   $(".active").removeClass("active");
   $(".previous").addClass("active");
   $(".previous").removeClass("previous");

   // Handle buttons for new resource
   $("#prevBtn").css("visibility", "hidden");
   $("#nextBtn").css("visibility", "hidden");
   if ( $(".active").prev().hasClass('record') ) {
     $("#prevBtn").css("visibility", "visible");
   }
   if ( $(".active").next().hasClass('record') ) {
     $("#nextBtn").css("visibility", "visible");
   }
 }

</script>

<footer class="container-fluid text-center">
	<?php $this->load->view('footer'); ?>
</footer>

</body>
</html>
