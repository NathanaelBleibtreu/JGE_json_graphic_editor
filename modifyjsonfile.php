<?php
    // On appelle la session
    session_start();
    
    // sorting by keys

    /*
    $order = array(3452342, 5867867, 7867867, 1231233);
$array = array(
    array('id' => 7867867, 'title' => 'Some Title'),
    array('id' => 3452342, 'title' => 'Some Title'),
    array('id' => 1231233, 'title' => 'Some Title'),
    array('id' => 5867867, 'title' => 'Some Title'),
);

usort($array, function ($a, $b) use ($order) {
    $pos_a = array_search($a['id'], $order);
    $pos_b = array_search($b['id'], $order);
    return $pos_a - $pos_b;
});
*/
$targetName = array_keys($_POST)[0];
$oldkey = substr($targetName, 17);
$newkey = $_POST[$targetName];
echo '<br /> clé de l\'élément <br /><pre>'. $targetName . '</pre>';
echo '<br /> la clé seule <br /><pre>'. $oldkey . '</pre>';
echo '<br /> la nouvelle clé  <br /><pre>'. $newkey . '</pre>';

echo "infos for dev";
echo '<br /> CONTENU DE SESSION <br /><pre>'; 
var_dump($_SESSION); 
echo '</pre><br /> CONTENU DE POST <br /><pre>'; 
var_dump($_POST); 
echo '</pre><br /> CONTENU DE FILES : TYPE <br /><pre>';
var_dump($_FILES); 
echo '</pre><br><a href="logout.php">DETRUIRE SESSION</a>';
    
     
    // On redirige le visiteur vers la page d'accueil
    //header ('Location: /JGE/');
    ?>