<?php
$json = file_get_contents('file.json');
  
// Decode the JSON file
$json_data = json_decode($json,true);
  
// Display data

foreach($json_data as $data){
    echo '<img src="'.$data['image'].'" />';
    echo '<p>'.$data['title'].'</p>';
    echo '<p>'.$data['price'].'</p>';
}