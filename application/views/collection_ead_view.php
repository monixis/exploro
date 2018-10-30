<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>eXploro EAD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("/styles/bootstrap.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("/styles/boxbuilder.css"); ?>">
  
    <link rel="stylesheet" href="<?php echo base_url("/styles/collection_ead.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("styles/quickTree.css"); ?>">
    <!-- Using a different library stylesheet to make collection info consistent with the old info formatting -->
    <link rel="stylesheet" href="http://library.marist.edu/archives/researchcart/styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="<?php echo base_url('/js/jquery.quickTree.js') ?>"></script>
    <style>
    li.heading
    {
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: inherit;
      line-height: 1.42857143;
      color: #333;
    }
    a{
      font-size: x-small;
    }
    </style>

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
        
          <a class="expand1" style="cursor : pointer;">Expand All</a>
          <a class="collapse1" style="cursor : pointer;">Collapse All</a>
          <?php 
            $parent = $xml->archdesc->dsc->c01;
            global $subtags;
            
            foreach($parent as $node)
            {
              echo "<div class='makeTree'>";
              echo "<ul class='quickTree' style='display:block;'>";      
              getNodes($node);
              echo "</ul></div>";
            }
            
            function getNodes($node){
              
              $tagName =  $node->getName();
              //echo $tagName."<br />";
              global $cId;
              $count=0;
              $subtags = array();
              foreach($node->children() as $n){
                $checktagc = $n->getName();
                //echo $checktagc."<br />";
                if($checktagc[0] === "c"){
                  $count++;
                }
              }              
              if(isset($node->did->unittitle) || isset($node->did->extref->unittitle)){
                // if($count!=0){echo $count;}
                // if(($node['level']=="series") && (isset($node->did->unittitle)) && ($tagName == 'c01')){
                if($tagName == 'c01'){  
                  echo "<li class='heading'>";
                  if(isset($node->did->unittitle)){
                    echo $node->did->unittitle;
                  } else if(isset($node->did->extref->unittitle)){
                    //echo "<li>", $node->did->extref->unittitle;
                    $attributes = $node->did->extref->attributes('xlink',true);
                    echo "<a href=".base_url("exploro/viewEAD") ."/". $cId ."/". $node->did->unitid." target=_blank>".$node->did->extref->unittitle ."</a>";
                  }
                } else {
                  echo "<ul><li class='list'>";
                  if(isset($node->did->unittitle)){
                    echo $node->did->unittitle;
                  } else if(isset($node->did->extref->unittitle)){
                    //echo "<li>", $node->did->extref->unittitle;
                    $attributes = $node->did->extref->attributes('xlink',true);
                    echo "<a href=".base_url("exploro/viewEAD") ."/". $cId ."/". $node->did->unitid." target=_blank>".$node->did->extref->unittitle ."</a>";
                  }
                }
              }
              if($count>0){
                // echo "<ul>";
                $parentname = $node->getName();
                foreach ($node->children() as $child) {
                  $checkc = $child->getName();
                  if(substr($checkc, 0, 1) === 'c'){
                    getNodes($child);
                  } 
                }
                // echo "</ul>";
              }
              echo "</li></ul>";
              // if($tagName == 'c01'){
              //   echo "</li>";
              // }
              //if($count!=0){echo $count;}
            }
            
          ?>
      </div>
      <div class="col-md-2 col-xs-2"></div>

      <div class="col-md-12 col-xs-12">
        <footer class="container-fluid text-center">
           <?php $this->load->view('footer'); ?>
        </footer>
      </div>
    </div>
  <script>
    $(document).ready(function() {
      $('.quickTree').quickTree();
      
      //alert("chekc");
      $('.expand1').click(function() {
        // $('span.expand').click();
        
        $('span.expand').addClass('contract').nextAll('ul').slideDown();
      });
      $('.collapse1').click(function() {
        // $('span.expand').click();
        $('span.expand').removeClass('contract').nextAll('ul').slideUp();
      });
      // $('span.expand').toggle(
      //         //if it's clicked once, find all child lists and expand
      //         function () {
      //             $(this).toggleClass('contract').nextAll('ul').slideDown();
      //         },
      //         //if it's clicked again, find all child lists and contract
      //         function () {
      //             $(this).toggleClass('contract').nextAll('ul').slideUp();
      //         }
      //     );
    });
  </script>
  </body>
</html>