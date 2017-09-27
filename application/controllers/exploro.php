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
		$resultsLink = "http://35.162.165.138:8983/solr/exploro-test/query?q=" . $q."&facet=true&facet.field=collection&facet.field=unitdate&facet.field=category&facet.field=format&facet.field=physdesc&facet.field=location";
 		$json = file_get_contents($resultsLink);
     	$data['results'] = json_decode($json);

		$dplaResultsLink = "http://api.dp.la/v2/items?q=" . $q ."&page_size=13&facets=sourceResource.subject.name&api_key=96410fe9eab08488c9a3da4e9641669f";
	 	$json1 = file_get_contents($dplaResultsLink);
     	$data['dplaResults'] = json_decode($json1);

	 	$this->load->view('results', $data);
     }

	 public function searchSubjects()
	 {
      	$q = $this -> input -> get('q');
		$q = str_replace(" ","%20", $q);
		$resultsLink = "http://35.162.165.138:8983/solr/exploro-test/query?q=" . $q."&facet=true&facet.field=collection&facet.field=date&facet.field=category&facet.field=format&facet.field=physdesc&facet.field=location";
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
		$resultsLink = "http://35.162.165.138:8983/solr/exploro-test/query?q=unitid:" . $id ;
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

	  public function ack(){
	 	$this->load->view('ack');
	 }
}
?>
