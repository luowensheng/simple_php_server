<?php namespace Applet\Loader;

function load_file($filename){
     $f = fopen($filename, 'r');
     if ($f == false) return "";
       
     $content = fread($f, filesize($filename)) or "";
     fclose($f);
     return $content;
}

?>