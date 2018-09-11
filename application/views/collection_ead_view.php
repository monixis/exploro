<!DOCTYPE html>
<html lang="en">
  <head>
    <title>eXploro EAD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("/styles/bootstrap.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("/styles/boxbuilder.css"); ?>">
  
    <link rel="stylesheet" href="<?php echo base_url("/styles/collection_ead.css"); ?>">
    <!-- Using a different library stylesheet to make collection info consistent with the old info formatting -->
    <link rel="stylesheet" href="http://library.marist.edu/archives/researchcart/styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>

     </script>
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
    <?php
      // load the index.xml file to get all collection info
      $xml = simplexml_load_file($url);
      // echo print_r($xml->archdesc->did->langmaterial);
      global $list;
      $list = array();     
      global $cId;
      $cId = $cid;
    ?>
    <div class="col-md-12 col-xs-12 section-sizing"></div>

    <div class="container-wrapper">
      <div class="col-md-2 col-xs-2"></div>
      <div class="col-md-8 col-xs-8 text-left div-container-body">
        <!-- Display the name of the collection -->
        <h1 class="heading"> <?php echo $xml->eadheader->filedesc->titlestmt->titleproper; ?></h1>

        <!-- Display the repository details found in index.xml -->
        <h2 class="indHeading">Repository</h2>

        <p><?php echo $xml->eadheader->filedesc->publicationstmt->publisher; ?></p>
        <?php 
          foreach ($xml->eadheader->filedesc->publicationstmt->address->addressline as $addline) {
            echo $addline.'<br />';
          }
        ?>

        <h2 class="indHeading">Processed By</h2>
        <p><?php echo $xml->eadheader->filedesc->titlestmt->author; ?></p>

        <h2 class="indHeading">Date Completed</h2>
        <p><?php echo $xml->eadheader->filedesc->publicationstmt->date; ?></p>

        <h2 class="indHeading">Encoded By</h2>
        <p><?php echo $xml->eadheader->profiledesc->creation; ?></p>

        <h2 class="indHeading">Creator</h2>
        <p><?php echo $xml->archdesc->did->origination; ?></p>

        <h2 class="indHeading">Extent</h2>
        <p><?php echo $xml->archdesc->did->physdesc->extent; ?></p>

        <h2 class="indHeading">Dates</h2>
        <p>
        <?php 
          foreach ($xml->archdesc->did->unitdate as $date){ 
            echo ucfirst($date->attributes()->type)," : ";
            echo $date; 
            echo "<br />";
          }
        ?>
        </p>

        <h2 class="indHeading">Conditions Governing Access</h2>
        <p><?php echo $xml->archdesc->accessrestrict->p; ?></p>

        <h2 class="indHeading">Languages</h2>
        <p><?php echo $xml->archdesc->did->langmaterial; ?></p>

        <h2 class="indHeading">Scope and Content</h2>
        <p><?php echo $xml->archdesc->scopecontent->p; ?></p>

        <h2 class="indHeading">Historical Note</h2>
        <p><?php echo $xml->archdesc->bioghist->p; ?></p>

        <h2 class="indHeading">Provence</h2>
        <p><?php echo $xml->archdesc->acqinfo->p; ?></p>

        <h2 class="indHeading">Copyright Notice</h2>
        <p><?php echo $xml->archdesc->userestrict->p ?></p>

        <h2 class="indHeading"></h2>
        <p>
          <?php 
          $parent = $xml->archdesc->dsc->c01;
          echo "<ul>";
          foreach($parent as $node)
          {
            getNodes($node);
          }
          echo "</ul>";

          function getNodes($node){
            global $cId;
            if(isset($node->did->unittitle)){
              echo "<li>", $node->did->unittitle;
            } else if(isset($node->did->extref->unittitle)){
              //echo "<li>", $node->did->extref->unittitle;
              $attributes = $node->did->extref->attributes('xlink',true);
              echo "<li><a href=".base_url("exploro/viewEAD") ."/". $cId ."/". $node->did->unitid." target=_blank>".$node->did->extref->unittitle ."</a>";
            }
            if ($node->children()) {
              echo "<ul>";
              foreach ($node->children() as $child) {
                  getNodes($child);
              }
              echo "</ul>";
            }
          echo "</li>";
          }
          ?>
        </p>

        <h2 class="indHeading">Acknowledgements</h2>
        <p></p>

      </div>
      <div class="col-md-2 col-xs-2"></div>

      <div class="col-md-12 col-xs-12">
        <footer class="container-fluid text-center">
           <?php $this->load->view('footer'); ?>
        </footer>
      </div>
    </div>
  </body>
</html>