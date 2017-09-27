<?php
  getCollections();

   function getCollections() {

     // Need to directly link to the directory of EADs *Very important
    $folders = scandir("C:/xampp/htdocs/exploro/eads");
    //echo "FLAG " . var_dump($files);

    foreach ($folders as $folder) {
      if (($folder == ".") || ($folder == "..")){
        // We do not want to add . or .. into the drop down
      }
      else{
          echo "<option value = " . $folder . ">$folder</option>";
      }
    }
  }

 ?>
