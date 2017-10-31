<?php
class explr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
// Transform XML into other XML format using XSLT
    public function index()
    {
         $this ->load ->view("dashboard");
    }

    /* Currently not converting in batches but this code is useful
    // Transform EAD3 XML into SOLR XML format using XSLT
    public function convertEADs()
    {
        // echo "FLAG " . print_r($_POST);
        $folderLocation = $_POST["folderLocation"];
        $collection = $_POST["collection"];
        $subCollection = $_POST["subCollection"];
        $filenameList = array();

        $dir = "$folderLocation/eads/$collection/$subCollection";
        // OK echo "FLAG DIR " . $dir . "<br>";
        $files = array_diff(scandir($dir), array('..', '.'));

        $numFiles = 0;

        if (is_array($files)) {
            foreach ($files as $filename) {
                $file = basename($filename);

                $filepath = "$folderLocation/eads/$collection/$subCollection/$file";

                if($file !="index.xml") {
                  // Add each filename to the list of filenames to be sent in the log email to Monish
                  $filenameList[] = $filename;

                  $new_ead_doc = new DOMDocument();

                  $new_ead_doc->load($filepath);

                  // Creates an array of all elements called recordid ... in the EAD we know it is only one
                  $rawRecordIDArray = $new_ead_doc->getElementsByTagName('recordid');
                  // Selects the first element of the array
                  $recordID = $rawRecordIDArray[0];
                  // Create id attribute to be placed in unittitle of ocllection
                  $collectionUnittitle = $new_ead_doc->createAttribute('id');
                  // Assigns the value of the collection as the value of the attribute
                  $collectionUnittitle->value = $collection;
                  // Add attribute to the element
                  $recordID->appendChild($collectionUnittitle);

                  $xsl_doc = new DOMDocument();
                  $xsl_doc->load("$folderLocation/application/xslt/ead_3_solr.xsl");

                  // echo "Hello";
                  $proc = new XSLTProcessor();
                  // echo "Goodbye";
                  $proc->importStylesheet($xsl_doc);

                  $newdom = $proc->transformToDoc($new_ead_doc);

                  $newdom->save("$folderLocation/solr_xmls/$collection/$subCollection/$file") or die("Flag: Error");

                  $numFiles ++;
                  // echo "FLAG NUM FILES " . $numFiles;
                }
            }
        }


        $convertedFiles = glob("$folderLocation/solr_xmls/$collection/$subCollection/*.xml");
        $convertedFileCount = sizeof($convertedFiles);
        // echo "FLAG CONVERTED FILES COUNT " . $convertedFileCount;
        if($convertedFileCount == $numFiles) {
            echo $convertedFileCount;

            // Success! send an email to Monish loggin what folders have been updated
            $this->load->library('email');
    				$config['protocol'] = "smtp";
                      $config['smtp_host'] = "tls://smtp.googlemail.com";
                      $config['smtp_port'] = "465";
                      $config['smtp_user'] = "cannavinolibrary@gmail.com";
                      $config['smtp_pass'] = "845@jac3419";
                      $config['charset'] = "utf-8";
                      $config['mailtype'] = "html";
                      $config['newline'] = "\r\n";
                      $this->email->initialize($config);
    			$this->email->from('cannavinolibrary@gmail.com', 'James A. Cannavino Library (Collaboration Room Reservation System)');

    			$this->email->to("danmopsick@gmail.com");
    			$this->email->subject('EAD3 files uploaded to Exploro');
    			$message = "</br><p>Hi Monish, <br/>The following EAD3 file(s) were converted into SOLR XML and are ready to be uploaded to Explro.</p>
                      <p>Collection: $collection</p>
                      <p>Subcollection: $subCollection</p><ul>";
                      foreach($filenameList as $file){
                        $message .= "<li>$file</li>";
                      }

          $message .= "</ul>";

    			$this->email->message($message);
    			// $this->email->send();
        }
        else {
            echo 0;
        }
    } */

    public function convertSingleEAD()
    {
      $numFiles = 0;
      $folderLocation = $_POST["folderLocation"];
      $urlLocation = $_POST["urlLocation"];
      $collection = $_POST["collection"];
      // $subCollection = $_POST["subCollection"];
      $fileName = $_POST["fileName"];

      $filepath = "$urlLocation/eads/$collection/$fileName";

      $new_ead_doc = new DOMDocument();

      $new_ead_doc->load($filepath);

      // Creates an array of all elements called recordid ... in the EAD we know it is only one
      // $rawRecordIDArray = $new_ead_doc->getElementsByTagName('recordid');

      // echo "FLAG " . var_dump($rawRecordIDArray);

      // Selects the first element of the array
      // $recordID = $rawRecordIDArray[0];

      // Create id attribute to be placed in unittitle of ocllection
      // $collectionUnittitle = $new_ead_doc->createAttribute('id');

      // Assigns the value of the collection as the value of the attribute
      // $collectionUnittitle->value = $collection;

      // Add attribute to the element
      // $recordID->appendChild($collectionUnittitle);

      $xsl_doc = new DOMDocument();
      $xsl_doc->load("$folderLocation/application/xslt/ead_3_solr.xsl");
      $proc = new XSLTProcessor();
      $proc->importStylesheet($xsl_doc);

      $newdom = $proc->transformToDoc($new_ead_doc);

      $newdom->save("$folderLocation/solr_xmls/$collection/$fileName") or die("Flag: Error");

      $numFiles ++;

      if($numFiles == 1) {
          echo 1;

          // Success! send an email to Monish loggin what folders have been updated
          $this->load->library('email');
          $config['protocol'] = "smtp";
                    $config['smtp_host'] = "tls://smtp.googlemail.com";
                    $config['smtp_port'] = "465";
                    $config['smtp_user'] = "cannavinolibrary@gmail.com";
                    $config['smtp_pass'] = "845@jac3419";
                    $config['charset'] = "utf-8";
                    $config['mailtype'] = "html";
                    $config['newline'] = "\r\n";
                    $this->email->initialize($config);
        $this->email->from('cannavinolibrary@gmail.com', 'James A. Cannavino Library (Collaboration Room Reservation System)');

        $this->email->to("danmopsick@gmail.com");
        $this->email->subject('EAD3 files uploaded to Exploro');
        $message = "<br/><p>Hi Monish, <br/>The following EAD3 file(s) were converted into SOLR XML and are ready to be uploaded to Explro.</p>
                    <p>Collection: $collection</p>
                    <ul><li>$fileName</li>";
        $message .= "</ul>";

        $this->email->message($message);
        // $this->email->send();
      }
      else {
          echo 0;
      }
    }

    public function publishToSolr()
    {
      $numFiles = 0;

      // Parse POST variables
      $folderLocation = $_POST["folderLocation"];
      $collection = $_POST["collection"];
      // $subCollection = $_POST["subCollection"];
      $fileName = $_POST["fileName"];

      $filePath = "$folderLocation/eads/$collection/$fileName";

      $post = [
        'command' => 'full-import',
        'clean' => 'false',
        'commit' => 'true',
        'collection' => "$collection",
        'fileName'   => "$fileName"
      ];

      $ch = curl_init('http://35.162.165.138:8983/solr/exploro/dataimport');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

      $response = curl_exec($ch);

      curl_close($ch);

      $xmlResponse = simplexml_load_string($response);

      // echo "FLAG " . print_r($xmlResponse);

      $timeTaken = $xmlResponse->lst[2]->str[7];

      $explodedTime = explode(":", $timeTaken);

      // echo "FLAG" . print_r($explodedTime);

      // Right now just accounting for minutes because I don't think it will take hours
      $minutesToSeconds = $explodedTime[1] * 60;
      // Adding .5 to make sure the seconds round up
      $seconds = round($explodedTime[2] + .5);

      $timeToWait = $minutesToSeconds + $seconds;

      echo $timeToWait;
    }

    public function publishBulkToSolr()
    {
      // Parse POST variables
      $folderLocation = $_POST["folderLocation"];
      $collection = $_POST["collection"];
      $subCollection = $_POST["subCollection"];

      // Create a variable to hold the list of filenames outside of any loop or conditional
      $filenameList = array();
      $numFiles = 0;

      // Get list of files to publish to SOLR
      $dir = "$folderLocation/eads/$collection/$subCollection";

      $files = array_diff(scandir($dir), array('..', '.', 'index.xml'));

      // Publish each of the files one at a time using a for each
      if (is_array($files)) {
        foreach ($files as $filename) {

          $post = [
            'command' => 'full-import',
            'clean' => 'false',
            'commit' => 'true',
            'fileName'   => $filename
          ];

          $ch = curl_init('http://35.162.165.138:8983/solr/exploro/dataimport');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

          $response = curl_exec($ch);

          $xmlResponse = simplexml_load_string($response);

          echo "</br></br>FLAG " . print_r($xmlResponse);
          $timeTaken = $xmlResponse->lst[2]->str[7];

          $explodedTime = explode(":", $timeTaken);

          // Right now just accounting for minutes because I don't think it will take hours
          $minutesToSeconds = $explodedTime[1] * 60;
          // Adding .5 to make sure the seconds round up
          $seconds = round($explodedTime[2] + .5);

          $timeToWait = $minutesToSeconds + $seconds;

          // echo "FLAG seconds passed $timeToWait"; */

          /*$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
          $json = json_encode($xml);
          $array = json_decode($json,TRUE);
          echo "FLAG " . print_r($array); */

          curl_close($ch);
          $numFiles ++;
          // Darn the next request cannot start until the previous request has finished...
          sleep($timeToWait);
        }

        $convertedFiles = glob("$folderLocation/solr_xmls/$collection/$subCollection/*xml");
        $convertedFileCount = sizeof($convertedFiles);

        if($convertedFileCount == $numFiles){
          echo $convertedFileCount;
        }
        else{
          echo 0;
        }

      }
    }

    /* Returns a list of all of the collections in the /eads folder as a series of options elements for a dropdown */
    public function getCollections()
    {
      // Need to directly link to the directory of EADs *Very important
     // $folders = scandir("C:/xampp/htdocs/exploro/eads");
     $folderLocation = $_GET["folderLocation"];

     $folders = scandir("$folderLocation/eads");

     //echo "FLAG " . var_dump($files);

     foreach ($folders as $folder) {
       if (($folder == ".") || ($folder == "..")){
         // We do not want to add . or .. into the drop down
         continue;
       }
       else {
           echo "<option value = '" . $folder . "'>$folder</option>";
       }
     }
    }

    /* Returns a list of subcollections for a given collection in the form of option elements for dropdown
    Returns the subfolders for a user specified collection*/
    public function getSubCollections()
    {
      $folderLocation = $_POST["folderLocation"];
      $collection = $_POST["collection"];

      // Directly link to the subcollections that we want to fetch
      $subcollections =  scandir("$folderLocation/eads/$collection");

      foreach ($subcollections as $subcollection) {
        if (($subcollection == ".") || ($subcollection == "..") || ($subcollection == "index.xml")) {
          // We do not want to add . or .. into the drop down.. should probably just remove them from array
          continue;
        }
        else {
          echo "<option value = '" . $subcollection . "'>$subcollection</option>";
        }
      }
    }

    /* Returns a list of files in the specified subcollection */
    public function getFileNames()
    {
      $folderLocation = $_POST["folderLocation"];
      $collection = $_POST["collection"];
      // $subCollection = $_POST["subCollection"];

      $rawFiles = scandir("$folderLocation/eads/$collection");

      $files = array_diff($rawFiles, array('index.xml', '..', '.'));

      echo "FLAG " . print_r($files);

      foreach ($files as $file) {
        echo "<option value = '" . $file . "'>$file</option>";
      }
    }

    public function formatEads()
    {
        $dir =  "eads";

//for ($i=1; $i<sizeof($files);$i++){
        $folders = array_diff(scandir($dir), array('..', '.'));
        scandir($dir);
        $i   = 0;
        foreach($folders as $folder){
            // print_r($folder);
            if($folder !=".DS_Store" && $folder !="stylesheets" ) {
                $newDir = $dir."/".$folder;
                $files = array_diff(scandir($newDir), array('..', '.'));
                //scandir($newDir);
                foreach ($files as $file) {
                    if($file != ".DS_Store") {
                        $filepath = $newDir . "/" . $file;
                        if($file == "index.xml"){
                            $ead_doc = new DOMDocument();
                            $ead_doc->load($filepath);
                            $ead_doc->preserveWhiteSpace = false;
                            $ead_doc->formatOutput = true;
                            // $xslt = $ead_doc->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="../stylesheets/collection.xsl"');
                            //$ead_doc->appendChild($xslt);
                            // $ead_doc->getElementsByTagName("recordid")-> setAttribute("instanceurl", $url);
                            //    $ead_doc.getElementsByTagName("recordid").getAttributeNode("instanceurl").nodeValue($url) ;
                            // $file = basename($filepath);
                            $collectionurl = base_url().$filepath;
                            $newString = str_replace("<ead xmlns=\"http://ead3.archivists.org/schema/\" audience=\"external\">","<?xml-stylesheet type=\"text/xsl\" href=\"../stylesheets/collection.xsl\"?><ead audience=\"external\">", $ead_doc->saveXML());


                            if (file_put_contents($filepath, $newString)) {
                                $ead_doc = new DOMDocument();
                                $ead_doc->load($filepath);
                                $ead_doc->preserveWhiteSpace = false;
                                $ead_doc->formatOutput = true;
                                $newString1 = str_replace("<recordid instanceurl=\"\">","<recordid instanceurl='".$collectionurl."'>", $ead_doc->saveXML());
                                if(file_put_contents($filepath, $newString1)) {
                                    //   print_r($filepath . "\n");
                                    $i++;
                                }
                            }

                        }else{
                            $ead_doc = new DOMDocument();
                            $ead_doc->load($filepath);
                            $ead_doc->preserveWhiteSpace = false;
                            $ead_doc->formatOutput = true;
                            $compenenturl = base_url().$filepath;
                            $collectionurl =base_url().$newDir."/index.xml";
                            //$ead_doc->getElementsByTagName("recordid")-> setAttribute("instanceurl", $url);
                            $newString = str_replace("<ead xmlns=\"http://ead3.archivists.org/schema/\" audience=\"external\">","<?xml-stylesheet type=\"text/xsl\" href=\"../stylesheets/boxbuilder.xsl\"?><ead audience=\"external\">", $ead_doc->saveXML());

                            if (file_put_contents($filepath, $newString)) {

                                $ead_doc = new DOMDocument();
                                $ead_doc->load($filepath);
                                $ead_doc->preserveWhiteSpace = false;
                                $ead_doc->formatOutput = true;
                                $newString1 = str_replace("<ptr href=\"\"/>","<ptr href='".$collectionurl."'/>", $ead_doc->saveXML());
                                file_put_contents($filepath, $newString1);
                                $ead_doc = new DOMDocument();
                                $ead_doc->load($filepath);
                                $ead_doc->preserveWhiteSpace = false;
                                $ead_doc->formatOutput = true;
                                $newString2 = str_replace("<recordid instanceurl=\"\">","<recordid instanceurl='".$compenenturl."'>", $ead_doc->saveXML());
                                if(file_put_contents($filepath, $newString2)){
                                    $i++;
                                }
                                // print_r($filepath . "\n");

                            }

                        }
                    }
                }
            }


        }
        echo $i;
    }



    /*public function upload(){


        $this -> load -> view('upload');
    }

    public function uploadFiles(){

        $count = 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            foreach ($_FILES['files']['name'] as $i => $name) {
                if (strlen($_FILES['files']['name'][$i]) > 1) {
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], '/ead_uploads/'.$name)) {
                        $count++;
                    }
                }
            }
        }


    }*/

}
?>
