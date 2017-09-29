<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="http://library.marist.edu/images/box.png"/>
		<link rel="shortcut icon" href="http://library.marist.edu/images/box.png" />
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<title>eXploro</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<!-- Bootstrap core CSS -->
		<link href="http://library.marist.edu/css/bootstrap.css" rel="stylesheet">
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="http://library.marist.edu/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
		<link href="http://library.marist.edu/css/library.css" rel="stylesheet">
		<link href="http://library.marist.edu/css/menuStyle.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript" src="http://library.marist.edu/js/libraryMenu.js"></script>
		<script type="text/javascript" src="http://library.marist.edu/crrs/js/jquery-ui.js"></script>
		<link rel="stylesheet" href="http://library.marist.edu/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="../styles/dashboard.css" />

    <script>
          $(document).ready(function(){
            // Dynamically creates a drop down consisting of folders of collections
            $.get("<?php echo base_url("?c=explr&m=getCollections")?>", function(response){
              //alert("FLAG " + response);
              $("#selectCollection").append(response);
            });

            $("#collectionForm").submit(function(event){
              event.preventDefault();
              if(!confirm("Are you sure you would like to upload this collection to Exploro?")){
                return 0;
              }

              if ($("#selectCollection").val() == 0){
                $("#error-panel").show();
                $("#error-message").html("You must select a valid collection.");
                return 0;
              }
              $("#error-panel").hide();
              $("#error-message").hide();
              // alert("Flag! Successful form submit");

              // Get the specific directory to be converted
              var collection = $("#selectCollection").val();

              var postData = {
                collection: collection
              };

              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url("?c=explr&m=converteads")?>",
                  data: postData,
                  dataType: "json",
                  success: function (message) {
                      if (message > 0) {
                          $('#requestStatus').empty();
                          $('#requestStatus').show().css('background', '#66cc00').append("Successfully converted - " + message + " file(s)").delay(3000).fadeOut();
                          // $('#requestStatus').empty();
                          //var convertedFileCount = '<!--?php echo $convertedFileCount;?>'';
                          //   alert("Success:Total number of documents converted :" message);
                      } else {
                          $('#requestStatus').empty();
                          $('#requestStatus').show().css('background', '#b31b1b').append("Failed to convert").delay(3000).fadeOut();
                          // $('#requestStatus').empty();
                      }
                  }
              });
            });

          });


          function convertEads() {
            var r = confirm("Are you sure you want to convert?");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("?c=explr&m=converteads")?>",
                    data: "",
                    contentType: false,
                    processData: false,
                    success: function (message) {
                        if (message > 0) {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#66cc00').append("Successfully converted - " + message + " file(s)").delay(3000).fadeOut();
                            // $('#requestStatus').empty();
                            //var convertedFileCount = '<!--?php echo $convertedFileCount;?>'';
                            //   alert("Success:Total number of documents converted :" message);
                        } else {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#b31b1b').append("Failed to convert").delay(3000).fadeOut();
                            // $('#requestStatus').empty();
                        }
                    }
                });
            }
        }

          function publishToSolr() {

            var r = confirm("Are you sure you want to publish?");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: "http://35.162.165.138:8983/solr/explor/dataimport?command=full-import&indent=on&wt=json",
                    data: "",
                    contentType: false,
                    processData: false,
                    success: function (message) {
                        if (message) {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#66cc00').append("Successfully published to solr core").delay(3000).fadeOut();

                           // alert("Published Successfully");

                        }else{

                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#b31b1b').append("Failed to publish: Please contact administrator or check error logs in solr server").delay(3000).fadeOut();
                        }
                    },
                    async: false

                });
            }
        }
    </script>
    <style>
		button:hover{
			opacity:0.5;
			cursor: pointer;
		}

		.panel-heading{
			height: 55px;
		}
    </style>

</head>
<body style="background: #ffffff;">
<div id="headerContainer">
    <a href="http://library.marist.edu/" target="_self">
        <div id="header"></div>
    </a>
</div>
<a class="menu-link" href="#menu"><img src="http://library.marist.edu/images/r-menu.png"
                                       style="width: 20px; margin-top: 4px;"/></a>
<div id="menu">
    <div id="menuItems"></div>
</div>
<div id="miniMenu" style="width: 75%;border: 1px solid black; border-bottom: none;">

</div>
<div class="container">

    <div class="col-md-12">
        <h2 style="text-align: center; margin: 30px; font-size: 40px;">EXPLORO - DASHBOARD</h2>
        <div id="requestStatus"
             style="width: auto; height:40px; margin-bottom: 7px; margin-top: -15px; color:#000000; font-size: 12pt; text-align: center; padding-top: 10px; display: none;"></div>
    </div>
    </br>

    <div align="center" class="col-md-12">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Upload EAD Collection into Solr</h3>
                </div>
                <div class="panel-body">
                    <p>
                        This process will convert EAD3 files of the specified collection into Solr XML. The Solr XML files will then be indexed into Exploro.
                    </p>
                    <h4>Note:</h4>
                    <p>
                        Before clicking update: Please make sure that you copied EAD3 folder generated from
                        boxbuilder into "ead_uploads" directory.
                    </p>
                    <div class="center-textbox">

                    <form id="collectionForm">
                      <div class="form-spacing">
                        <select id="selectCollection">
                          <option selected value="0">Please select a collection</option>
                        </select>
                      </div>

                      <div class="form-spacing">
                        <select id="selectSubCollection">
                          <option selected value="0">Please select a subcollection to upload</option>
                        </select>
                      </div>

                      <div class="form-spacing">
                        <input type="radio" name="uploadType" value="1" required> EAD XML</input>
                      </div>

                      <div class="form-spacing">
                        <input type="radio" class="form-spacing" name="uploadType" value="2" required> EAD XML with PDFs</input>
                      </div>

                      <div class="form-spacing">
                        <input id="upload" name="update" class="btn btn-primary" type="submit" style="background:#333;" value="Upload" />
                      </div>
                    </form>
                  </div>
                </div>
            </div>
            <div id="error-panel" class="panel panel-default error-message">
              <div class="panel-body">
                <div class="center-textbox">
                  <div id="error-message">

                  </div>
                </div>
              </div>
            </div>

        </div>
    </div>


</div>
</br>
<div class="col-md-12">
    <footer>
        <p class="foot">
            James A. Cannavino Library, 3399 North Road, Poughkeepsie, NY 12601; 845.575.3106
            <br/>
            &#169; Copyright 2007-2016 Marist College. All Rights Reserved.

            <a href="http://www.marist.edu/disclaimers.html" target="_blank">Disclaimers</a> | <a
                href="http://www.marist.edu/privacy.html" target="_blank">Privacy Policy</a> | <a
                href="http://library.marist.edu/exploro-dashboard/ack?iframe=true&width=50%&height=62%" rel="prettyphoto[iframes]">Acknowledgements</a>
        </p>
    </footer>
</div>
</div>

</body>

</html>
