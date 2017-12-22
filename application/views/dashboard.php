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
          // This is the folderlocation for testing on localhost
          // var folderLocation = "C:/xampp/htdocs/exploro";

          // This is the folder location for testing on the dev server..
          // var folderLocation = "/data/dev.library/htdocs/exploro";
          // var urlLocation = "http://dev.library.marist.edu/exploro";

          // folder and url locations for prod environment
          var folderLocation = "/data/library/htdocs/exploro";
          var urlLocation = "http://library.marist.edu/exploro";

          $(document).ready(function() {
            // Dynamically creates a drop down consisting of folders of EAD collections that can be converted into SOLR XML
            $.get("<?php echo base_url("?c=explr&m=getCollections&folderLocation=")?>" + folderLocation, function(response) {
              //alert("FLAG " + response);
              $("#selectCollection").append(response);
            });

            $("#selectCollection").change(function() {
              $("#selectFileName").html('<option selected value="0">Please select a file to upload</option>');
              var collection = $("#selectCollection").val();
              // var subCollection = $("#selectSubCollection").val();

              var postData = {
                folderLocation: folderLocation,
                collection: collection
                // subCollection: subCollection
              };

              $.ajax({
                type: "POST",
                url: "<?php echo base_url("?c=explr&m=getFileNames") ?>",
                data: postData,
                dataType: "text",
                success: function (message) {
                  if (message == 0) {
                    // There are no files
                    $("#error-panel").show();
                    $("#error-message").html("This collection does not have any valid subcollections.");
                  }
                  else {
                    // $("#selectFileName").html('<option selected value="all">Convert all files in SubCollection</option>');
                    $("#selectFileName").html('<option selected value="0">Choose a file to upload</option>');
                    $("#selectFileName").append(message);
                  }
                },
              });
            });

            /* This is the code that dynamically finds subcollection based on collection -- currently not being used but kept in
            Dynamically load subcollections based on the collection selected by the user
            $("#selectCollection").change(function() {
              // Resets the sub collection dropdown
              // $("#selectSubCollection").html('<option selected value="0">Please select a subcollection to upload</option>');
              $("#selectFileName").html('<option selected value="0">You must select a subcollection before a file</option>');

              var collection = $("#selectCollection").val();
              if (collection == 0) {
                return 0; // There are no sub collections of the default please select message
              }

              var postData = {
                folderLocation: folderLocation,
                collection: collection
              };

              $.ajax({
                type: "POST",
                url: "<?php // echo base_url("?c=explr&m=getSubCollections") ?>",
                data: postData,
                dataType: "text",
                success: function (message) {
                    // alert('Flag 1 ' + message.toString());
                    if (message == 0) {
                      // There are no subCollections
                      $("#error-panel").show();
                      $("#error-message").html("This collection does not have any valid subcollections.");
                    }
                    else {
                      $("#selectSubCollection").append(message);
                      // $("#selectFileName").html('<option selected value="0">Please select a file to </option>');
                      lookForSubCollectionChanges = true;
                    }
                },
              });
            }); */


            /* This gets a list of filenames based on chosen subcollection... not currently in use
            $("#selectSubCollection").change(function() {
              $("#selectFileName").html('<option selected value="0">Please select a file to upload</option>');
              var collection = $("#selectCollection").val();
              // var subCollection = $("#selectSubCollection").val();

              var postData = {
                folderLocation: folderLocation,
                collection: collection
                // subCollection: subCollection
              };

              $.ajax({
                type: "POST",
                url: "<?php //echo base_url("?c=explr&m=getFileNames") ?>",
                data: postData,
                dataType: "text",
                success: function (message) {
                  if (message == 0) {
                    // There are no files
                    $("#error-panel").show();
                    $("#error-message").html("This collection does not have any valid subcollections.");
                  }
                  else {
                    // $("#selectFileName").html('<option selected value="all">Convert all files in SubCollection</option>');
                    $("#selectFileName").html('<option selected value="0">Choose a file to upload</option>');
                    $("#selectFileName").append(message);
                  }
                },
              });
            });  */

            $("#collectionForm").submit(function(event) {
              event.preventDefault();

              // Get the specific directory to be converted
              var collection = $("#selectCollection").val();
              // var subCollection = $("#selectSubCollection").val();
              var fileName = $("#selectFileName").val();
              // var uploadType = $("input[name=uploadType]:checked").val();

              // Validate the collection dropdown
              if (collection == 0) {
                $("#error-panel").show();
                $("#error-message").html("You must select a valid collection.");
                return 0;
              }

              // Validate the subcollection dropdown
              /* if (subCollection == 0) {
                $("#error-panel").show();
                $("#error-message").html("You must select a valid subcollection.");
                return 0;
              } */

              // Validate the filename dropdown
              if (fileName == 0) {
                $("#error-panel").show();
                $("#error-message").html("You must select a valid file name.");
                return 0;
              }

              if(!confirm("Are you sure you would like to upload this collection to Exploro?")){
                return 0;
              }

              $("#error-panel").hide();
              $("#error-message").hide();
              // alert("Flag! Successful form submit");

              var postData = {
                folderLocation: folderLocation,
                urlLocation: urlLocation,
                collection: collection,
                // subCollection: subCollection,
                fileName: fileName
              };

              /* Uploads entire batch */
              if (fileName == "all") {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("?c=explr&m=convertEADs")?>",
                    data: postData,
                    dataType: "text",
                    success: function (message) {
                        if (message > 0) {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#66cc00').append("Successfully converted - " + message + " file(s). Please remain on this page until the next message appears.").delay(5000).fadeOut();
                            publishBulkToSolr();
                            // $('#requestStatus').empty();
                            //var convertedFileCount = '<!--?php echo $convertedFileCount;?>'';
                            //   alert("Success:Total number of documents converted :" message);
                        } else {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#b31b1b').append("Failed to convert EAD to Solr XML").delay(3000).fadeOut();
                            // $('#requestStatus').empty();
                        }
                    }
                });
              }
              else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("?c=explr&m=convertSingleEAD")?>",
                    data: postData,
                    dataType: "text",
                    success: function (message) {
                        if (message > 0) {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#66cc00').append("Successfully converted - " + message + " file(s). Now indexing. Please remain on this page until the next message appears.");
                            publishToSolr();
                            // $('#requestStatus').empty();
                            //var convertedFileCount = '<!--?php echo $convertedFileCount;?>'';
                            //   alert("Success:Total number of documents converted :" message);
                        } else {
                            $('#requestStatus').empty();
                            $('#requestStatus').show().css('background', '#b31b1b').append("Failed to convert EAD to Solr XML").delay(3000).fadeOut();
                            // $('#requestStatus').empty();
                        }
                    }
                });
              }
            });

          });

          function publishToSolr() {
            // Get the specific file to be converted
            var collection = $("#selectCollection").val();
            // var subCollection = $("#selectSubCollection").val();
            var fileName = $("#selectFileName").val();

            var postData = {
              folderLocation: folderLocation,
              collection: collection,
              //subCollection: subCollection,
              fileName: fileName
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("?c=explr&m=publishToSolr")?>",
                data: postData,
                dataType: "text",
                success: function (timeToWait) {
                    if (timeToWait > 0) {
                      $('#requestStatus').empty();
                      $('#requestStatus').show().css('background', '#66cc00').append("eXploro will need about " + timeToWait + " seconds to index the chosen file.");

                      $("#upload").prop("disabled", true);

                      setTimeout(function() {
                        $("#upload").prop("disabled", false);
                        $('#requestStatus').empty();
                        $('#requestStatus').show().css('background', '#66cc00').append("eXploro is ready to index another file.");
                      }, (timeToWait * 1000));

                    } else {
                        $('#requestStatus').empty();
                        $('#requestStatus').show().css('background', '#b31b1b').append("Failed to upload files. The previous upload may have taken longer than expected! Try again.").delay(3000).fadeOut();
                    }

                }
            });
          }

          function publishBulkToSolr() {
            // Disable update button
            $("#upload").prop("disabled", true);

            // Get the specific directory to be converted
            var collection = $("#selectCollection").val();
            // var subCollection = $("#selectSubCollection").val();

            var postData = {
              folderLocation: folderLocation,
              collection: collection
              // subCollection: subCollection
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("?c=explr&m=publishBulkToSolr")?>",
                data: postData,
                dataType: "text",
                success: function (message) {
                    if (message > 0) {
                      $('#requestStatus').empty();
                      $("#upload").prop("disabled", false);
                      $('#requestStatus').show().css('background', '#66cc00').append("eXploro succesfully indexed " + message + " files.");
                    } else {
                        $('#requestStatus').empty();
                        $("#upload").prop("disabled", false);
                        $('#requestStatus').show().css('background', '#b31b1b').append("Failed to upload files.").delay(3000).fadeOut();
                    }

                }
            });
          }


    </script>

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
                    <h3>Convert EAD to Solr XML and upload to Exploro.</h3>
                </div>
                <div class="panel-body">
                    <p>
                        This process will convert EAD3 files of the specified collection into Solr XML.
                        Upon succesful conversion the EAD3 files will be indexed into Exploro.
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

                      <!-- <div class="form-spacing">
                        <select id="selectSubCollection">
                          <option selected value="0">You must select a collection before a subcollection</option>
                        </select>
                      </div> -->

                      <div class="form-spacing">
                        <select id="selectFileName">
                          <option selected value="0">You must select a collection before a file</option>
                        </select>
                      </div>

                      <div class="form-spacing">
                        <input id="upload" name="update" class="btn btn-primary" type="submit" style="background:#333;" value="Convert" />
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
