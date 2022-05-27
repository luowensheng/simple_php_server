<?php
$key_val = [1,2,4,5,6,7,8,9,10,11,12];
$temp = [];
$count = count($key_val);
echo $count;
for ($i = 1; $i < $count; $i++){
    $temp[] = $key_val[$i]; //array_push($temp, 3);
}

print_r($temp);

?>