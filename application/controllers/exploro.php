<?php
class exploro extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

   public function index()
   {
     $date = date_default_timezone_set('US/Eastern');
     $this->load->view('search');
   }

	public function searchKeyWords()
  {
  	$q = $this -> input -> get('q');
		$q = str_replace(" ","%20", $q);
    // Taken from repository search keywords
    $solrQ = str_replace("fq","&fq", $q);
    $solrQ = str_replace("Date", "datesingle", $solrQ);
    // rows=2147483647 is the max value of an int... this returns all rows so that way they can all be viewed with pagination... will get a lot of uneeded data which is expensive..
		$resultsLink = "http://35.162.165.138:8983/solr/exploro/query?q=" . $solrQ."&facet=true&facet.field=collection&facet.field=datesingle&facet.field=category&facet.field=format&rows=100";
 		$json = file_get_contents($resultsLink);
   	$data['results'] = json_decode($json);

    // Code to query the Digital Public Library of America
		$dplaResultsLink = "http://api.dp.la/v2/items?q=" . $q ."&page_size=13&facets=sourceResource.subject.name&api_key=96410fe9eab08488c9a3da4e9641669f";
	 	$json1 = file_get_contents($dplaResultsLink);
   	$data['dplaResults'] = json_decode($json1);

	 	$this->load->view('results', $data);
  }

	 public function searchSubjects()
	 {
  	$q = $this -> input -> get('q');
		$q = str_replace(" ","%20", $q);
		$resultsLink = "http://35.162.165.138:8983/solr/exploro/query?q=" . $q."&facet=true&facet.field=collection&facet.field=datesingle&facet.field=category&facet.field=format&facet.field=physdesc&facet.field=location";
 		$json = file_get_contents($resultsLink);
     	$data['results'] = json_decode($json);

		$dplaResultsLink = "http://api.dp.la/v2/items?q=" . $q ."&page_size=13&facets=sourceResource.subject.name&api_key=96410fe9eab08488c9a3da4e9641669f";
	 	$json1 = file_get_contents($dplaResultsLink);
     	$data['dplaResults'] = json_decode($json1);

	 	$this->load->view('results', $data);
     }

	  public function fileInfo()
	  {
    	$id = $this -> input -> get('id');
  		$resultsLink = "http://35.162.165.138:8983/solr/exploro/query?q=id:" . $id ;
   		$json = file_get_contents($resultsLink);
     	$data['results'] = json_decode($json);
  	 	$this->load->view('file_view', $data);
    }

	  public function viewEAD()
	  {
  		$cid = $this -> input -> get('cid');
  		$id = $this -> input -> get('id');
  		$data['url'] = base_url('eads/'.$cid.'/'.$id.'.xml');
      $data['cid'] = $cid;
      $this->load->view('ead_view', $data);
    }

    public function viewCollectionEAD(){
      $cid = $this -> input -> get('cid');
      $data['url'] = base_url('eads/'.$cid.'/index.xml');
      $data['cid'] = $cid;
      $this->load->view('collection_ead_view', $data);
    }

	   public function ack(){
	 	   $this->load->view('ack');
	   }
   }


?>
