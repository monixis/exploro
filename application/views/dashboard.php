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

    <script>
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

        function updateEads() {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("?c=explr&m=formatEads")?>",
                data: "",
                contentType: false,
                processData: false,
                success: function (message) {
                    if (message > 0) {
                        $('#requestStatus').empty();
                        $('#requestStatus').show().css('background', '#66cc00').append("Successfully updated - " + message + " files").delay(3000).fadeOut();


                    } else {
                        $('#requestStatus').empty();
                        $('#requestStatus').show().css('background', '#b31b1b').append("Failed to update").delay(3000).fadeOut().empty().delay(4000);
                        // $('#requestStatus').empty();

                    }
                }
            });


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
<div id="miniMenu" style="width: 100%;border: 1px solid black; border-bottom: none;">

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
                <!--                <i class="fa fa-updating  fa-5x"></i>
                -->
                <div class="panel-heading">
                    <h3>1. Update EADs</h3>
                </div>
                <div class="panel-body">

                    <li>
                        This update will add the collection url and component url for each of the collection EAD files
                        in the directory.
                    </li>
                    <p>
                    <h4>Note:</h4>
                    <li>
                        Before clicking update: Please make sure that you copied EAD3 folder generated from
                        boxbuilder into "ead_uploads" directory.
                    </li>

                    </p>
                    <button id="update" name="update" class="btn btn-primary" type="button" onclick="updateEads()"
                            style="background:#333;">Update
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div align="center" class="col-md-12">
        <div class="panel-group">

            <!--                <i class="fa fa-converting fa-5x"></i>
            -->
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h3>2. Convert Updated EAD3s into Solr XMLs</h3>
                </div>

                <div class="panel-body">

                    <li>
                        A process to transform EAD3s into Solr formatted XMLs.
                    </li>
                    <p>
                     <li>
                        Convered Files will be saved into "solr_xmls" directory.
                    </li>
                    </p>
                    </br>
                    <button id="convert" name="convert" class="btn btn-primary" type="button" onclick="convertEads()"
                            style="background:#333;">Convert
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div align="center" class="col-md-12">
        <!--                <i class="fa fa-publish fa-5x"></i>
        -->
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">


                    <h3>3. Publish To Solr</h3>
                </div>
                <div class="panel-body">

                    <li>A process to ingest the converted SOLR xmls into solr core to index and search purposes.
                    </li>
                    <p>
                    <h4>Note:</h4>
                    <li>
                     Before clicking publish: Please make sure that converted SOLR xmls are copied into solr directory (apache_solr/files/solrdocs) in AWS EC2.
                    </li>
                    </p>
                    <button id="publish" name="publish" class="btn btn-primary" type="button" onclick="publishToSolr()"
                            style="background:#333;">Publish
                    </button>
                </div>
            </div>
        </div>

    </div>

    </br></br>

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

