<!DOCTYPE html>
<html lang="en">
  <head>
    <title>eXploro EAD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="styles/boxbuilder.css">
    <link rel="stylesheet" href="styles/collection_ead.css">
    <!-- Using a different library stylesheet to make collection info consistent with the old info formatting -->
    <link rel="stylesheet" href="http://library.marist.edu/archives/researchcart/styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>

     </script>
  <body>
    <?php
      // load the index.xml file to get all collection info
      $xml = simplexml_load_file($url);
      // echo print_r($xml->archdesc->did->langmaterial);
    ?>
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

    <div class="col-md-12 section-sizing" style="background-image:url('http://148.100.181.189:8090/digitizedContents/LTP/1269/1269.26.jpg'); background-repeat: no-repeat; background-size: cover;"></div>

    <div class="container-wrapper">
      <div class="col-md-2"></div>
      <div class="col-md-8 text-left div-container-body">
        <!-- Display the name of the collection -->
        <h1 class="heading"> <?php echo $xml->control->filedesc->titlestmt->titleproper; ?></h1>

        <!-- Display the repository details found in index.xml -->
        <h2 class="indHeading">Repository</h2>

        <p><?php echo $xml->archdesc->did->repository->corpname->part ?></p>
        <p><?php echo $xml->archdesc->did->repository->address->addressline; ?></p>
        <p>Phone: <?php echo $xml->archdesc->did->repository->address->addressline[1]; ?></p>
        <p>Fax</p>
        <p>Email</p>

        <h4 class="indHeading"><a href="http://library.marist.edu/archives/<?php echo $cid?>/report/" target="_blank">NHPRC Grant Report</a></h4>

        <h2 class="indHeading">Project Director</h2>
        <p></p>

        <h2 class="indHeading">Project Archivist</h2>
        <p></p>

        <h2 class="indHeading">Date Completed</h2>
        <p><?php echo $xml->control->filedesc->publicationstmt->date; ?></p>

        <h2 class="indHeading">Encoded By</h2>
        <p></p>

        <h2 class="indHeading">Creator</h2>
        <p><?php echo $xml->archdesc->did->origination->persname->part; ?></p>

        <h2 class="indHeading">Extent</h2>
        <p><?php echo $xml->archdesc->did->physdescstructured->quantity . " " . $xml->archdesc->did->physdescstructured->unittype; ?></p>

        <h2 class="indHeading">Conditions Governing Access</h2>
        <p><?php echo $xml->archdesc->accessrestrict->p ?></p>

        <h2 class="indHeading">Languages</h2>
        <p><?php
        // Display each of the languages included in the specified collection
         $languages = $xml->archdesc->did->langmaterial->language;
         foreach($languages as $language) {
           echo $language . " ";
         }
        ?></p>

        <h2 class="indHeading">Scope and Content</h2>
        <p><?php echo $xml->archdesc->scopecontent->p; ?></p>

        <h2 class="indHeading">Historical Note</h2>
        <p><?php echo $xml->archdesc->bioghist->p; ?></p>

        <h2 class="indHeading">Provence</h2>
        <p></p>

        <h2 class="indHeading">Copyright Notice</h2>
        <p><?php echo $xml->archdesc->userestrict->p ?></p>

        <h2 class="indHeading">Acknowledgements</h2>
        <p></p>

      </div>
      <div class="col-md-2"></div>

      <div class="col-md-12">
        <footer class="container-fluid text-center">
           <?php $this->load->view('footer'); ?>
        </footer>
      </div>
    </div>
  </body>
</html>
