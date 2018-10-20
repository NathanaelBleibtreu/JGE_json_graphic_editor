<?php
    // On appelle la session
    session_start();



/* sorting by order function
*
*/

// recup du json copié

$jsonCopyFile = file_get_contents('jsonCopyFile.json');
$parsejson = json_decode($jsonCopyFile, true);

$targetName = array_keys($_POST)[0];
$oldkey = substr($targetName, 17);
$newkey = $_POST[$targetName];

//on splice pour enlever l'elem du tableau
$elem = array($parsejson[$oldkey-1]); // decrement to match
$debut = array_splice($parsejson, 0, $oldkey-1);

//on refait la récup car on dirait splice detruit le $parsejson
$jsonCopyFile = file_get_contents('jsonCopyFile.json');
$parsejson = json_decode($jsonCopyFile, true);

$fin = array_splice($parsejson, $oldkey, count($parsejson)-$oldkey); //dec to match car on a incrementé dans les id du formulaire qu'on compte de 0 et qu un elem manque donc -3

//on splice debut ou fin selon le nouvel emplacement

if($oldkey>$newkey){ // si le nouvel emplacement est avant l ancien

    $newdebut = array_splice($debut, 0, $newkey-1);
    //$newfin = array_splice($debut, $newkey-count($fin)-3);
    //$newdebutWithElem = array_merge($newdebut, $elem, $newfin);
    $newarr = array_merge($newdebut, $elem, $debut, $fin);

    echo '<br><br>old plus grand que new';

} elseif($oldkey<$newkey){  // si le nouvel emplacement est apres l ancien
  
    $newdebut = array_splice($fin, 0, $newkey-$oldkey);
    $newarr = array_merge($debut, $newdebut, $elem, $fin);
    
    echo '<br><br>old plus petit que new';
}



// on ecrit les nouvelle valeur dans le jsoncopy
$newjsoncopyarr = array();
foreach($newarr as $i => $value){
    array_push($newjsoncopyarr, json_encode($newarr[$i]));
}
echo "<pre>";


// on remet a blanc le jsoncopy
$jsonCopyFile = fopen('jsonCopyFile.json', 'w+');
fwrite($jsonCopyFile, "");
fclose($jsonCopyFile);

$jsoncopyfilepath = 'jsonCopyFile.json';

// caractere interdit dans les value <",">, <}>
foreach($newjsoncopyarr as $i => $value){
    if($i==0){
        $line = "[" .PHP_EOL ."\t" . substr_replace($value, PHP_EOL . "\t\t", 1, 0) . PHP_EOL;
        $line = str_replace(",\"", "," . PHP_EOL . "\t\t\"", $line);
        $line = str_replace("}", PHP_EOL . "\t},", $line);
        file_put_contents($jsoncopyfilepath, $line, FILE_APPEND | LOCK_EX);

    } elseif ($i==count($newjsoncopyarr)-1) {
        $line = substr_replace($value, "\t{" . PHP_EOL . "\t\t", 0, 1) . PHP_EOL . "]";
        $line = str_replace("\",", "\"," . PHP_EOL . "\t\t", $line);
        $line = str_replace("}", PHP_EOL . "\t}", $line);
        file_put_contents($jsoncopyfilepath, $line, FILE_APPEND | LOCK_EX);

    } else {
        $line = substr_replace($value, "\t{" . PHP_EOL . "\t\t", 0, 1);
        $line = str_replace('","', '",' . PHP_EOL . "\t\t\"", $line);
        $line = substr_replace($line, PHP_EOL . "\t}," . PHP_EOL, -1, 1);
        file_put_contents($jsoncopyfilepath, $line, FILE_APPEND | LOCK_EX);
    }  
}

var_dump($newjsoncopyarr);


/*
$jsonCopyFile = fopen('jsonCopyFile.json', 'w+');
fwrite($jsonCopyFile, "");
fclose($jsonCopyFile);

$jsoncopyfilepath = 'jsonCopyFile.json';


foreach($newjsoncopyarr as $i => $value){
    if($i==0){
        $line = "[\r\n\t" . $value;
        file_put_contents($jsoncopyfilepath, $line, FILE_APPEND | LOCK_EX);
    } elseif ($i==count($newjsoncopyarr)) {
        $line = $value . "\r\n]";
        file_put_contents($jsoncopyfilepath, $line, FILE_APPEND | LOCK_EX);
    } else {
        file_put_contents($jsoncopyfilepath, $value, FILE_APPEND | LOCK_EX);
    }  
}
*/


/* test avec split et regex
// on chercher à couper la partie qui nous interesse cad copier et supprimer puis insérer à la nouvelle place
// on sait que chaque partie du json est délimitée par "{" et "}", on cherche dont la nème occurence :
// NOTE ! sauf en cas de tableau dans les valeur ! AMELIRATION future

// en gros on splice et on rearrange puis on remet les "}"
$jsonCopyTmp = fopen('jsonCopyFile.json', "r+");
$strJsonCopyTmp = fread ($jsonCopyTmp, filesize ('jsonCopyFile.json'));
$tableau = preg_split("#\}#", $strJsonCopyTmp);
var_dump($tableau);
*/


// infos dev
/*
echo '<br /><br /> nombre total d\'élément à ordonner  <br /><pre>'. $totalNumberOfId . '</pre>';
echo '<br /> clé de l\'élément modifié <br /><pre>'. $targetName . '</pre>';
echo '<br /> la clé seule <br /><pre>'. $oldkey . '</pre>';
echo '<br /> la nouvelle clé  <br /><pre>'. $newkey . '</pre>';

echo "infos for dev";
echo '<br /> CONTENU DE $parsejson <br /><pre>'; 
var_dump($parsejson); 
echo '</pre><br /> CONTENU DE SESSION <br /><pre>'; 
var_dump($_SESSION); 
echo '</pre><br /> CONTENU DE POST <br /><pre>'; 
var_dump($_POST); 
echo '</pre><br /> CONTENU DE FILES : TYPE <br /><pre>';
var_dump($_FILES); 
echo '</pre><br><a href="logout.php">DETRUIRE SESSION</a>';
*/   

     
// On redirige le visiteur vers la page d'accueil
header ('Location: /JGE/');


?>