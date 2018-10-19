<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">JGE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarColor01">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
              </ul>

              <form class="form-inline my-2 my-lg-0" method="post" action="/JGE/index.php" enctype="multipart/form-data">
                <input class="form-control mr-sm-2" placeholder="Ajouter un fichier JSON" type="file" name="fichier">
                <input class="btn btn-secondary my-2 my-sm-0" type="submit" name="upload" value="Envoyer" />
                <input type="hidden" name="MAX_FILE_SIZE" value="12345" />

              </form>
            
            </div>

          </nav>

              <?php

              if(isset($_FILES['fichier'])){

                // verification of file type uploaded
                $allowed_types = array("application/json");
                if(!in_array($_FILES['fichier']['type'], $allowed_types)){
                  die ('type mime incorrect'); 

                } else {

                //creation of table

                  $json = file_get_contents($_FILES['fichier']['tmp_name']);
                  $parsejson = json_decode($json, true);
                  
                  echo '<table class="table table-stripes"><thead><tr><th schope="col"></th>'; 

                  $headerList = array_keys($parsejson[1]);

                  foreach($headerList as $i => $value){
                      echo '<th schope="col">' . $value . '</th>';
                  }

                  echo '</tr></thead><tbody>';

                  foreach($parsejson as $i => $value){
                    
                    echo '<tr><th scope="row">';
                    echo '<form method="POST" action="/">';
                    
                    //NEXT DEV STEP = a function to sort the element triggered by a change on the order of one element of the list

                    echo '<select name="orderValueForElem"' . $i . '" id="orderValueForElem"' . $i . '" onchange="console.log(\'coucou maman\');">';
                    //select the actual order of the element in the input

                    foreach($parsejson as $k => $value){
                    
                      if($i==$k){
                        echo '<option value="' . $k . '" "selected">' . $k;
                      } else {
                        echo '<option value="' . $k . '">' . $k;
                      }
                      
                    } 

                    echo '</select></form></th>';
                    
                    foreach($parsejson[$i] as $j => $value){
                      echo '<td>' . $parsejson[$i][$j] . '</td>';
                    }
                  }

                  echo '</tr></tbody></table>';
                }
              }
              ?>
              
              <?php


              /* infos for dev
              echo '<br /> CONTENU DE POST <br />'; 
              var_dump($_POST); 
              echo '<br /> CONTENU DE FILES : TYPE <br />';
              var_dump($_FILES['fichier']['type']); 
              */

              ?>
    </body>
</html>