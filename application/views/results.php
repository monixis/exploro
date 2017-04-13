<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://library.marist.edu/crrs/js/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
  $(function(){
    $( "#tabs" ).tabs();
  });
</script>	
<style>
	ul.ui-tabs-nav{
		height: 50px;
		background: #ffffff;
		border: none;
	}
	
	div#tabs{
		border-top: none;
		border-left: none;
		border-right: none;
		border-bottom: none;
	}
</style>	

<link rel="stylesheet" type="text/css" href="./styles/main.css" />
	<h2>Results:</h2>
		<div id="facets" style="border-right: 1px solid #ccc; width: auto; height: auto; float: left; margin-left: -200px; padding-right: 20px; ">
			<h4>Filter By:</h4>	
			<p style="font-size: 12pt; margin-bottom: 0px;color: #b31b1b; font-weight: bold;">Collections</p>	
			<?php 
				$i = 0;
				foreach ($results->facet_counts->facet_fields->collection as $row) {
			?>
				<a href="#"><?php echo $row . " "; ?></a>
			<?php			
					$i =  $i + 1;
					if($i % 2 == 0 )
					{
			?><br/>
			<?php	}else{
						echo " - ";		
					}
			}?><br/>
			
			<p style="font-size: 12pt; margin-bottom: 0px;color: #b31b1b; font-weight: bold;">Type</p>	
			<?php 	
				$i = 0;				
				foreach ($results->facet_counts->facet_fields->category as $row) {
			?>
				<a href="#"><?php echo $row . " "; ?></a>
			<?php
					$i =  $i + 1;
					if($i % 2 == 0 )
					{
			?><br/>
			<?php	}else{
						echo " - ";		
					}
			}?><br/>
			
			<p style="font-size: 12pt; margin-bottom: 0px;color: #b31b1b; font-weight: bold;">Format</p>	
			<?php 	
				$i = 0;				
				foreach ($results->facet_counts->facet_fields->format as $row) {
			?>
				<a href="#"><?php echo $row . " "; ?></a>
			<?php
					$i =  $i + 1;
					if($i % 2 == 0 )
					{
			?><br/>
			<?php	}else{
						echo " - ";		
					}
			}?><br/>
			
			<p style="font-size: 12pt; margin-bottom: 0px;color: #b31b1b; font-weight: bold;">Physical Description</p>	
			<?php 	
				$i = 0;				
				foreach ($results->facet_counts->facet_fields->physdesc as $row) {
			?>
				<a href="#"><?php echo $row . " "; ?></a>
			<?php
					$i =  $i + 1;
					if($i % 2 == 0 )
					{
			?><br/>
			<?php	}else{
						echo " - ";		
					}
			}?><br/>
			
			<p style="font-size: 12pt; margin-bottom: 0px;color: #b31b1b; font-weight: bold;">Location</p>	
			<?php 	
				$i = 0;				
				foreach ($results->facet_counts->facet_fields->location as $row) {
			?>
				<a href="#"><?php echo $row . " "; ?></a>
			<?php
					$i =  $i + 1;
					if($i % 2 == 0 )
					{
			?><br/>
			<?php	}else{
						echo " - ";		
					}
			}?><br/>
			
			<p style="font-size: 12pt; margin-bottom: 0px;color: #b31b1b; font-weight: bold;">Subjects</p>
			<?php
				foreach($dplaResults -> facets as $row) {
					for ($i = 0 ; $i< 10; $i++){
						$subject = $row -> terms[$i] -> term;
						$count = $row -> terms[$i] -> count;
						$subjectcombined = $subject ." - " . $count ;
						?>
					<a href="#" id="<?php echo $subject; ?>" class="subjects"><?php echo chunk_split($subjectcombined, 24, "<br/>"); ?></a>
			<?php	
					}
				}
			?>
		</div>
		
		
<div id="tabs">
 <ul>
    <li><a href="#tabs-1">Marist Archives</a></li>
    <li><a href="#tabs-2">Digital Public Library of America</a></li>
  </ul>
  <div id="tabs-1">
  	<h4 style="text-align: left; color: #6592A6; margin-bottom: 3px; margin-top: 0px;">Marist Archives records:</h4>
  	<ol id="list">
			<?php
				foreach ($results->response->docs as $row) {
					$title = (isset($row -> unittitle[0]) ? $row -> unittitle[0] : FALSE);	
					//$title = $row -> title[0];
					$date = (isset($row -> unitdate[0]) ? $row -> unitdate[0] : FALSE) ;
					$level = $row -> category[0];
					if ($level == 'files'){
						$box = $row -> container[0];	
					}
					$collectionLink = (isset($row -> collectionLink[0]) ? $row -> collectionLink[0]: FALSE) ;
					$collection = $row -> collection;
					$id = $row -> unitid;
					$link = $row -> link[0]; 
			?>
				<li class="results" style="height: auto; padding: 10px;">
					<img src="<?php echo $link ?>" style="width: 135px; height: 115px; float: left; margin-right: 10px;"/>
					<div style="margin-left: 120px; padding: 5px; height: auto;">
						<a href="<?php echo base_url("?c=exploro&m=fileInfo&id=".$id)?>" target="_blank"><?php echo $title ?></a></br>
						<p style="font-size: 12pt; margin-top: -10px;">Date: <?php echo $date ?></p>
							<?php if ($level == "files"){ ?>
								<p style="font-size: 12pt; margin-top: -10px;">Box: <?php echo $box ?></p>
							<?php }	?>	
						<p style="font-size: 12pt; margin-top: -10px;">Type: <?php echo $level ?></p>
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
	<ol id="list">
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
  </div>
</div>		
<script type="text/javascript">
		$('a.subjects').click(function(){
			var subject = $(this).attr('id');
			$('input#searchBox').val(subject);
			var searchTerm = $('input#searchBox').val();
			var searchTerm = searchTerm.replace(/ /g,"%20");
			var resultUrl = "<?php echo base_url("?c=exploro&m=searchSubjects&q=")?>"+ searchTerm;
			$('#searchResults').load(resultUrl);
			
		});
</script>
			  