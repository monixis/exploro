<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="http://library.marist.edu/images/jac-m.png"/>
    <link rel="shortcut icon" href="http://library.marist.edu/images/jac.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Honor's Thesis Repository</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="http://library.marist.edu/css/bootstrap.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://library.marist.edu/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="http://library.marist.edu/css/library.css" rel="stylesheet">
	<link href="http://library.marist.edu/css/menuStyle.css" rel="stylesheet">
	<link href="styles/main.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript" src="http://library.marist.edu/js/libraryMenu.js"></script>
	<script type="text/javascript" src="http://library.marist.edu/crrs/js/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

</head>

  <body>
	<div id="headerContainer">
			<a href="http://library.marist.edu/" target="_self"> <div id="header"></div> </a>
	</div>
	<a class="menu-link" href="#menu"><img src="http://library.marist.edu/images/r-menu.png" style="width: 20px; margin-top: 4px;" /></a>
	<div id="menu">
			<div id="menuItems">
			</div>
	</div>		
 	<div id="miniMenu" style="width: 100%;border: 1px solid black; border-bottom: none;">
		
	</div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
   <div id="main-container" class="container">
   		   	
   		<div class="jumbotron">
     														
    			<div class="container" style="margin-top: -36px;">
     				
     				 <!-- Example row of columns -->
     				
     				 <div class="row">
     				 	<!--div style="border: 1px solid black; height: 40px;">
    						<p class="catalogHeader">
								<img src="http://library.marist.edu/images/foxhunt.png" class = "foxhunt_logo" />Fox Hunt 2.0
							</p>
    					</div-->		
        				<div class="col-md-12">
          				<form class="form-horizontal" >
<fieldset>

<!-- Form Name -->
<h2 style="text-align: center; margin: 30px; font-size: 40px;">Honor's Thesis Repository</h2>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Name</label>  
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">CWID</label>  
  <div class="col-md-4">
  <input id="cwid" name="cwid" type="text" placeholder="Your Marist Campus Wide Number" class="form-control input-md" required="">
  </div>
</div>

<div class="form-group">
   <label class="col-md-4 control-label">Email address</label>
   <div class="col-md-4">
       <input class="form-control" name="email" id="email" type="email" data-fv-emailaddress-message="The value is not a valid email address" />
   </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Title">Title</label>
  <div class="col-md-5">
  <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required="">

  </div>
</div>

<!-- Appended Input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Tag">Add a subject heading</label>
  <div class="col-md-4">
    <div class="input-group">
    	<!--div id="tagList"></div-->
      <input id="subjects" name="tag" class="form-control" placeholder=" " type="text">
     <button id="Add" name="Add" class="btn btn-primary" type="button" style="margin-top: 10px; margin-bottom: -19px; background: #333;">Add</button>
    </div>
    <p class="help-block"> </p>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Associated subject headings</label>
  <div class="col-md-4">
    <!--textarea class="form-control" id="associatedTags" name="textarea" style="height: 100px;"></textarea-->
    <ul class="form-control" id="associatedTags" style="height: 150px; overflow: auto; width: 400px;">

    </ul>
  </div>
</div>

<div class="form-group">
<label class="col-md-4 control-label" for="Tags">Select paper</label>
	<div class="col-md-4">
		<form action="" id='complete' enctype="multipart/form-data" method="post">
   			<div>
       			<input name='fileToUpload' id='fileToUpload' class='btn' type="file" /><br/>
       			<!--div id="fileList"></div-->
      		</div>
		</form>
	</div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="upload"></label>
  <div class="col-md-4">
    <button id="upload" name="upload" class="btn btn-primary" type="submit" style="background: #333;">Upload</button>
  </div>
</div>

</fieldset>
</form>
						</div>
                								
					</div><!-- row -->
					
    			</div><!-- container -->
   		</div> <!-- jumbotron -->
   		
   		<br>
     
    </div> <!-- main-container -->
    	<div  class="bottom_container">
        	<p class = "foot">
				James A. Cannavino Library, 3399 North Road, Poughkeepsie, NY 12601; 845.575.3106		
				<br />
				&#169; Copyright 2007-2016 Marist College. All Rights Reserved.

				<a href="http://www.marist.edu/disclaimers.html" target="_blank" >Disclaimers</a> | <a href="http://www.marist.edu/privacy.html" target="_blank" >Privacy Policy</a> | <a href="http://library.marist.edu/ack.html?iframe=true&width=50%&height=62%" rel="prettyphoto[iframes]">Acknowledgements</a>
			</p>


        </div>
	<script type="text/javascript">

           var tagList = new Array();
$('button#upload').click(function(e) {

    if($('input#fileToUpload')[0].files[0]) {
        var filesize = $('input#fileToUpload')[0].files[0].size/1024/1024;
        if (filesize <= 2.0) {


            //var name = $('input#name').val();
            //var title = $('input#title').val();
            //var cwid = $('input#cwid').val();
            var taglist = JSON.stringify(tagList);
            var form_data = new FormData();
            form_data.append('name', $('input#name').val());
            form_data.append('title', $('input#title').val());
            form_data.append('cwid', $('input#cwid').val());
            form_data.append('email', $('input#email').val());
            form_data.append('tags', taglist);
            if ($('input#fileToUpload')[0].files[0]) {
                form_data.append('file_attach', $('input#fileToUpload')[0].files[0]);
            }
            /*
             form_data.append('file_attach' , $('input#file_attach')[0].files[0]);
             */

            $.ajax({

                type: "POST",
                url: "<?php echo base_url("?c=repository&m=insertDetails");?>",
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function (data) {
                    if (data > 0) {

                        alert("PaperId#" + data + ": Paper has been uploaded successfully");
                        //  $('#requestStatus').show().css('background', '#66cc00').append("#" + data + ": File has been uploaded successfully");

                    } else {

                        alert("Failure: Something went wrong. Please contact administrator");

                        // $('#requestStatus').show().css('background', '#b31b1b').append("Something went wrong.Please contact adminstrator");

                    }


                    //load json data from server and output message
                   // if (response.type == 'error') { //load json data from server and output message
                     //   output = '<div class="error">' + response.text + '</div>';
                    //} else {
                        // $('.progress').addClass('hide');
                        // $("#progressstatus").html("<p color='black'></p>");
                      //  $('#requestStatus').show().css('background', '#66cc00').append("#" + userId + ": A User Agreement Form has been sent to " + userName);
                        //      alert("success");
                        //    alert('Paper uploaded successfully. You should receive a confirmation email shortly.');
                        // output = '<div class="success">' + response.text + '</div>';
                   // }
                    // $("#contact_form #contact_results").hide().html(output).slideDown();
                }

            });
        }

        else {
            e.preventDefault();
            alert("uploaded file size should be less than 2MB");
        }
    }else{
        e.preventDefault();
        alert("Please select the paper to upload into repository");
    }

});
		$("#Add").click(function(){

			var newtag = $('input#subjects').val();

            tagList.push(newtag);
			if ($('input#subjects').val() == ""){
				alert('Please select or enter a new tag to add.');
			}else{
				$.post("<?php echo base_url("?c=repository&m=addATag"); ?>",{tagname: newtag}).done(function(data){
					//alert(data);
					if(data > 0)
					{
						//alert('Tag added successfully');
						$('#associatedTags').append('<span class="taglist" style="border: 1px solid #cccccc; background: #eeeeee; padding: 5px; margin-right: 5px; margin-bottom: 5px;">'+ newtag +'<a href="#" class="remove"> X </a></span><br/><br/>');
						$('input#subjects').val('');	
						//$("#tagList").load("<!--?php echo base_url("?c=repository&m=loadTags");?>");						
					}
					else
					{
						alert('Something went wrong. Please contact site administrator.');
					}
				});
			}
			
		});
		
	$('#associatedTags').on('click', '.remove', function() {
        $(this).closest('span.taglist').remove();
    });
    
    $('#subjects').keypress(function(e){
    	var subject = $(this).val() + e.key;
    	var availableTags = [];
 		$.getJSON("http://fast.oclc.org/searchfast/fastsuggest?&query=" + subject + "&callback=?", function (data) {
    	//console.log(data);
		$.each(data.response.docs, function(k,v){
			//console.log(v.suggestall);
			availableTags.push(v.suggestall);
		});
   		});
   		$( "#subjects" ).autocomplete({
    	source: availableTags
	    });
	});	
      
	</script>
  </body>
</html>
