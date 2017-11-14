<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="./js/nprogress.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.pagination.js/0.1.1/list.pagination.min.js"></script>
<script src="./js/jquery.easyPaginate.js"></script>
<link rel="stylesheet" type="text/css" href="./styles/nprogress.css" />

<script>
  $(function(){
    $("#tabs").tabs();

  });

  /*
  // Paginate Marist Library results
  $('#tabs-1').easyPaginate({
       paginateElement: 'li',
       elementsPerPage: 10
 });


// Paginate DPLA results
 $('#tabs-2').easyPaginate({
      paginateElement: 'li',
      elementsPerPage: 10
}); */

</script>
<!-- Inline style is generally not the best practice but I am taking pagination directly from eaditorSearch -->
<style>
  .easyPaginateNav a {
    padding:5px;float: inherit
  }
  .easyPaginateNav a.current {
    font-weight:bold;text-decoration:underline;
  }
</style>
<link rel="stylesheet" type="text/css" href="./styles/main.css" />
	<div id="selectedFacet">
	</div>
	<h2>Total <?php echo $results->response->numFound; ?> Results:</h2>
		<div id="facets" style="width: 240px; height: auto; float: left; margin-left: -240px;">
			<h4>Filter By:</h4>
			<?php
				$facets = (array) $results->facet_counts->facet_fields;
				foreach ($facets as $key => $value){
          if ($key == "datesingle") {
            $key ="Date";
          }
			?>
					<button class="accordion"><?php echo ucfirst($key) ; ?></button>
					<div class="panel" id="<?php echo $key ; ?>">
            <form class="form-horizontal">
								<div class="form-group has-feedback">
                        <input id="searchInput_<?php echo $key;?>" class="form-control hasclear" oninput="sFacet.filterHTML('#<?php echo $key ; ?>', 'li#<?php echo $key;?>', this.value)" type="text" placeholder="Search">
						<span></span>

						</div>
							</form>
					<?php
						$facetList = " ";
						$i = 0;
						foreach ($value as $row) {
							if ($i % 2 == 0){
								$facetList = $row;
							}else{
								$facetList = $facetList . " - " . $row ;
					?><li id="<?php echo $key;?>" style="margin-bottom:5px;"><a href="#" class='tags'><?php echo $facetList ; ?></a></li><?php
							}
							$i += 1;
						}
					?>
					</div>
			<?php
				}
			?>
		</div>

<div id="tabs">
 <ul>
    <li><a href="#tabs-1" id="tab-1-link">Marist Archives</a></li>
    <li><a href="#tabs-2" id="tab-2-link">Digital Public Library of America</a></li>
  </ul>
  <div id="tabs-1">
  	<h4 style="text-align: left; color: #6592A6; margin-bottom: 3px; margin-top: 0px;">Marist Archives records:</h4>
  	<ol id="list-1">
			<?php
				foreach ($results->response->docs as $row) {
					//$title = (isset($row -> unittitle[0]) ? $row -> unittitle[0] : FALSE);
					$title = $row -> unittitle;
					$date = (isset($row -> datesingle) ? $row -> datesingle : FALSE) ;
					$level = $row -> category;
					if ($level == 'files'){
	          $box = $row -> container[0];
					}
					$collectionLink = (isset($row -> collectionLink[0]) ? $row -> collectionLink[0]: FALSE) ;
					$collection = $row -> collection;
					$id = $row -> id;
					$link = $row -> link;

          // Check to see if the file is a .pdf, if so display a placeholder image
          $linkPath = pathinfo($link);
          $fileExtension = $linkPath['extension'];
          if ($fileExtension == "pdf"){
            $link = "http://148.100.181.189:8090/testing/images/folder-icon.png";
          }
			?>
				<li class="results" style="height: auto; padding: 10px;">
					<img src="<?php echo $link ?>" style="width: 135px; height: 115px; float: left; margin-right: 10px;"/>
					<div style="margin-left: 120px; padding: 5px; height: auto;">
						<a href="<?php echo base_url("?c=exploro&m=fileInfo&id=".$id)?>" target="_blank"><?php echo $title ?></a></br>
						<p style="font-size: 12pt; margin-top: -10px;">Date: <?php echo $date ?></p>
							<?php if ($level == "files"){ ?>
								<p style="font-size: 12pt; margin-top: -10px;">Box: <?php echo $box ?></p>
							<?php }	?>
						<p style="font-size: 12pt; margin-top: -10px;">Category: <?php echo $level ?></p>
						<p style="font-size: 12pt; margin-top: -10px;">Collection: <?php echo $collection ?></p>
					</div>
				</li>
			<?php
				}
			?>
		</ol></br>
  </div>
  <div id="tabs-2">
  	<!--img src="https://dp.la/info/wp-content/uploads/2015/02/horizontal_logo_standard_Jan2015.jpg" style="height: 100px;"/-->
  	<h4 style="text-align: left; color: #6592A6; margin-bottom: 3px; margin-top: 0px;">DPLA records:</h4>
	<ol id="list-2">
			<?php
			foreach ($dplaResults -> docs as $row) {
					$title = $row -> sourceResource -> title;
					if (is_array($title)){
						$title = $row -> sourceResource -> title[0];
					}else{
						$title = $row -> sourceResource -> title;
					}

					$object = (isset($row -> object) ? $row -> object : FALSE);
					if (is_array($object)){
						$object = (isset($row -> object[0]) ? $row -> object[0] : FALSE);
					}else{
						$object = (isset($row -> object) ? $row -> object : FALSE);
					}

					$isShownAt = $row -> isShownAt;

					$date = (isset($row -> sourceResource -> date -> displayDate) ? $row -> sourceResource -> date -> displayDate :FALSE);
					if (is_array($date)){
						$date = (isset($row -> sourceResource -> date[0] -> displayDate) ? $row -> sourceResource -> date[0] -> displayDate :FALSE);
					}else{
						$date = (isset($row -> sourceResource -> date -> displayDate) ? $row -> sourceResource -> date -> displayDate :FALSE);
					}

					$dataProvider  = (isset($row -> dataProvider) ? $row -> dataProvider : FALSE);
					if (is_array($dataProvider)){
						$dataProvider  = (isset($row -> dataProvider[0]) ? $row -> dataProvider[0] : FALSE);
					}else{
						$dataProvider  = (isset($row -> dataProvider) ? $row -> dataProvider : FALSE);
					}

					$type = (isset($row -> sourceResource -> type) ? $row -> sourceResource -> type : FALSE);

					$description = (isset($row -> sourceResource -> description) ? $row -> sourceResource -> description : FALSE);
					if (is_array($description)){
						$description = (isset($row -> sourceResource -> description[0]) ? $row -> sourceResource -> description[0] : FALSE);
					}else{
						$description =  (isset($row -> sourceResource -> description) ? $row -> sourceResource -> description : FALSE);
					}

          if ($object == "") {
            $object =  'http://148.100.181.189:8090/testing/images/folder-icon.png';
          }
			?>
				<li class="results" style="height: auto; padding: 10px;">
					<img src="<?php echo $object ?>" style="width: 135px; height: 115px; float: left; "/>
					<div style="margin-left: 150px; padding: 5px; height: auto;">
						<a href="<?php echo $isShownAt ?>" target="_blank"><?php echo $title ?></a></br>
						<p style="font-size: 12pt; margin-top: -10px;">Data Provider: <?php echo $dataProvider ?></p>
						<p style="font-size: 12pt; margin-top: -10px;">Date: <?php echo $date ?></p>
						<p style="font-size: 12pt; margin-top: -10px;">Type: <?php echo $type ?></p>
						<p style="font-size: 12pt; margin-top: -10px;">Description: <?php echo $description ?></p>
						<!--p style="font-size: 12pt; margin-top: -10px;">Date: <?php echo $date ?></p-->
					</div>
				</li>
			<?php
				}
			?>
		</ol></br>
    <div id="pagination"></div>
  </div>
</div>
<script type="text/javascript">
	/*('a.subjects').click(function(){
			var subject = $(this).attr('id');
			$('input#searchBox').val(subject);
			var searchTerm = $('input#searchBox').val();
			var searchTerm = searchTerm.replace(/ /g,"%20");
			var resultUrl = "<!--?php echo base_url("?c=exploro&m=searchSubjects&q=")?>"+ searchTerm;
			$('#searchResults').load(resultUrl);

		});*/

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

		/*
    This is the old results JS... I don't think it does anything
    $('a.tags').click(function(){
			var selectedTag = ($(this).parents('div.panel').attr('id')) + ' > ' + ($(this).text().substr(0, $(this).text().indexOf('-')));
			$('#selectedFacet').append('<button class="taglist" style="border: 1px solid #cccccc; background: #eeeeee; padding: 5px; margin-right: 10px; margin-top: 5px;">'+ selectedTag +'<a href="#" class="remove" style="margin-left:10px;"> X </a></button>');

		});

    $('#selectedFacet').on('click', '.remove', function() {
          $(this).closest('button.taglist').remove();
      });

    */

    $('a.tags').click(function(){
      var searchTerm = $('input#searchBox').val();
      var selectedTag = ($(this).parents('div.panel').attr('id')) + ' : ' + ($(this).text().substr(0, $(this).text().indexOf('-')));
      $('#selectedFacet').append('<button class="taglist" style="border: 1px solid #cccccc; background: #eeeeee; padding: 5px; margin-right: 10px; margin-top: 5px;">'+ selectedTag +'<a href="#" class="remove" id="'+ selectedTag +'" style="margin-left:10px;"> X </a></button>');
      $('input#queryTag').val($('input#queryTag').val() + "fq=" + selectedTag);
      var queryTag = $('input#queryTag').val();
      searchTerm = searchTerm + queryTag;
      searchTerm = searchTerm.replace(/ /g,"%20");
      var resultUrl = "<?php echo base_url("?c=exploro&m=searchKeyWords&q=")?>"+searchTerm;
      NProgress.start();
      NProgress.configure({ showSpinner: true });
      $('#searchResults').load(resultUrl);
      NProgress.done();
    });

    $('#selectedFacet').on('click', '.remove', function() {
        var searchTerm = $('input#searchBox').val();
        var unselectedTag ="fq=" + $(this).attr('id');
        $(this).closest('button.taglist').remove();
        $('input#queryTag').val($('input#queryTag').val().replace(unselectedTag, ' '));
        var queryTag = $('input#queryTag').val();
        searchTerm = searchTerm + queryTag;
        searchTerm = searchTerm.replace(/ /g,"%20");
        NProgress.start();
        NProgress.configure({ showSpinner: true });
        var resultUrl = "<?php echo base_url("?c=exploro&m=searchKeyWords&q=")?>"+searchTerm;
        $('#searchResults').load(resultUrl);
        NProgress.done();
    });

    $('#tabs-1').easyPaginate({
         paginateElement: 'li',
         elementsPerPage: 10
   });

   // Show the pagination for Marist Library Archives when that section is selected
   $("#tab-1-link").click(function(){
     $(".easyPaginateNav").show();
     $("#facets").show();
   });

   // Hide the pagination for Marist Library Archives when the DPLA is selected
   $("#tab-2-link").click(function(){
     $(".easyPaginateNav").hide();
     $("#facets").hide();
   });

   /* Code taken from eaditor... handles the searching inside of facets */
   var sFacet = {};
    sFacet.filterHTML = function(id, sel, filter) {
        var a, b, c, i, ii, iii, hit;
        a = sFacet.getElements(id);
        for (i = 0; i < a.length; i++) {
            b = sFacet.getElements(sel);
            for (ii = 0; ii < b.length; ii++) {
                hit = 0;
                if (b[ii].innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
                    hit = 1;
                }
                c = b[ii].getElementsByTagName("*");
                for (iii = 0; iii < c.length; iii++) {
                    if (c[iii].innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
                        hit = 1;
                    }
                }
                if (hit == 1) {
                    b[ii].style.display = "";
                } else {
                    b[ii].style.display = "none";
                }
            }
        }
    };
    sFacet.getElements = function (id) {
        if (typeof id == "object") {
            return [id];
        } else {
            return document.querySelectorAll(id);
        }
    };
</script>
