
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="./js/nprogress.js?r=123"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.pagination.js/0.1.1/list.pagination.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="./js/jquery.easyPaginate.js"></script>
<link rel="stylesheet" type="text/css" href="./styles/nprogress.css" />
<link rel="stylesheet" type="text/css" href="./styles/results.css" />
<link rel="stylesheet" type="text/css" href="./styles/main.css" />
<style>
	p.labelInfo {font-size: 10pt; margin-top: -10px;}
	span.labelName {color: #b31b1b;font-weight:bold; }
	.easyPaginateNav a {padding:5px;float: inherit}
	.easyPaginateNav a.current {font-weight:bold;text-decoration:underline;}
    .element-item {
        position: relative;
        float: left;
        width: 200px;
        height: 200px;
        margin: 15px;
        padding: 10px;
        background: #ddd;
        color: #262524;
    }
	/*@media all and (min-width:992px) {
		#facets {
			width: 240px;
			height: auto;
			margin-left: -240px;
		}
	}
/*
	@media all and (max-width:950px) {

		#facets {

			width: 100%;
			float: left
			height: 400px;
		}
	}
*/


</style>
	<div id="collectionList" class="">
    <?php //echo $results->facet_counts->facet_fields->collection[2]; ?>
			<!--h4>Filter By:</h4-->
            <br /><br />
            <div id="browseList" class="grid" style="position: relative; height: auto;">
			<?php
                $i=0;//to only print the list of collections
				$facets = (array) $results->facet_counts->facet_fields->collection;//returns collection name, 0
				foreach ($facets as $key => $value){
                    if($i%2 == 0){
                        $words = explode(" ", $value);
                        $acronym = "";
                        
                        foreach ($words as $w) {
                          $acronym .= $w[0];
                        }   
			?>
					
                        <div class="element-item"><a id="collections" value="<?php echo ucfirst($value) ; ?>" href="javascript:showCollections('<?php echo ucfirst($value) ; ?>')"><?php echo ucfirst($value) ; ?></a><br />
                        </div>
                    

			<?php
                    }
                    $i++;
                }
                
			?>
            </div>
		</div>
<script>
$body =  $("body");
$body.removeClass("loading");
  $(function(){
    //document.getElementById("ma-link").click();
  });
	var acc = document.getElementsByClassName("accordion");
	var i;
	for (i = 0; i < acc.length; i++)
	{
    	acc[i].onclick = function()
    	{
        	this.classList.toggle("active");
        	var panel = this.nextElementSibling;
        	if (panel.style.display === "block") {
        		panel.style.display = "none";
    		} else {
          		panel.style.display = "block";
       		}
 	    }
	}

   function showCollections(cname){
       var batchcount = 0;//the result index starts from 0 and shows result upto 99. 
       var searchterm = document.getElementById("collections").getAttribute("value");
       if(cname.includes('-')){
        colName =  '"' + (cname.substr(0,cname.lastIndexOf('-'))).trim() + '"';
           //cname = cname.split(/\s+/).slice(0,3).join(" ");
           //cname = cname.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "");
        }
      //colName =  '"' + (cname.substr(0,cname.lastIndexOf('-'))).trim() + '"';
      
      colName = cname.replace(/ /g,"%20");
      colName = '"'+colName+'"';
      alert((colName));
      var resultUrl = "<?php echo base_url("exploro/searchCollectionKeyWords")?>" + "/" + colName + "/" + batchcount;
      NProgress.start();
      NProgress.configure({ showSpinner: true });
      $('#collectionList').empty();
      $('#searchResults').load(resultUrl);
      NProgress.done();
    }
</script>
