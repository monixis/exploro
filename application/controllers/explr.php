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

    // Transform EAD3 XML into SOLR XML format using XSLT
    public function converteads()
    {
        $collection = $_POST["collection"];
        $subCollection = $_POST["subCollection"];

        $dir = "eads/" . $collection . "/" . $subCollection;
        $files = array_diff(scandir($dir), array('..', '.'));

        $numFiles = 0;

        if (is_array($files)) {

            foreach ($files as $filename) {
                $file = basename($filename);
                $filepath = "eads/$collection/$subCollection/$file";
                // echo "FLAG " . $filepath;

                if($file !="index.xml") {

                    $new_ead_doc = new DOMDocument();
                    $new_ead_doc->load($filepath);
                    $xsl_doc = new DOMDocument();
                    $xsl_doc->load("application/xslt/ead_3_solr.xsl");
                    $proc = new XSLTProcessor();
                    $proc->importStylesheet($xsl_doc);
                    $newdom = $proc->transformToDoc($new_ead_doc);
                    $newdom->save("solr_xmls/$collection/$subCollection/" . $file) or die("Error");
                    $numFiles ++;
                    // echo "FLAG NUM FILES " . $numFiles;
                }
            }
        }

        $convertedFiles = glob("solr_xmls/$collection/$subCollection/*xml");
        $convertedFileCount = sizeof($convertedFiles);
        // echo "FLAG CONVERTED FILES COUNT " . $convertedFileCount;
        if($convertedFileCount == $numFiles){

            echo $convertedFileCount;
        }else{
            echo 0;
        }
    }

    /*public function publishToSolr(){

        $dir =  "application/ceads";
        //$files = glob("application/eads/*xml");
        $files = scandir($dir);

        //$files2 = scandir($dir, 1);
        if(in_array("index.xml", $files)){
                $filename = "application/ceads/index.xml";
                $ead_doc = new DOMDocument();
                $ead_doc->load($filename);
                $file = basename($filename);
                $newString = str_replace("<?xml version='1.0' encoding='UTF-8'?><?xml-model href='schema/ead3.rng' type='application/xml' schematypens='http://relaxng.org/ns/structure/1.0'?>", "<?xml version='1.0' encoding='UTF-8'?><?xml-model href='schema/ead3.rng' type='application/xml' schematypens='http://relaxng.org/ns/structure/1.0'?><?xml-stylesheet type=\"text/xsl\" href=\"boxbuilder.xsl\"?>", $ead_doc->saveXML());

              $newString1 = str_replace("<?xml version='1.0' encoding='UTF-8'?><?xml-model href='schema/ead3.rng' type='application/xml' schematypens='http://relaxng.org/ns/structure/1.0'?>", "<?xml version='1.0' encoding='UTF-8'?><?xml-model href='schema/ead3.rng' type='application/xml' schematypens='http://relaxng.org/ns/structure/1.0'?><?xml-stylesheet type=\"text/xsl\" href=\"boxbuilder.xsl\"?>", $ead_doc->saveXML());

            if (file_put_contents("application/ceads/$file", $newString)) {

                    echo 1;
                }

        }else{

            echo 0;
        }

        //print_r($files1);
       // print_r($files2);



    }*/

    /* Returns a list of all of the collections in the /eads folder as a series of options elements for a dropdown */
    public function getCollections()
    {
      // Need to directly link to the directory of EADs *Very important
     $folders = scandir("C:/xampp/htdocs/exploro/eads");
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
      $collection = $_POST["collection"];

      // Directly link to the subcollections that we want to fetch
      $subcollections =  scandir("C:/xampp/htdocs/exploro/eads/$collection");

      foreach ($subcollections as $subcollection) {
        if (($subcollection == ".") || ($subcollection == "..")){
          // We do not want to add . or .. into the drop down.. should probably just remove them from array
          continue;
        }
        else {
          echo "<option value = '" . $subcollection . "'>$subcollection</option>";
        }
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
