<?php
require "server/server.php";
require "server/loader.php";

// use Applet;
use Applet\Loader;


$app = new Applet\Server();

$app->get("/admin", function (&$writer, $request){
     $writer->set_json_content("$request");
});

$app->get("/home", function (&$writer, $request){
    $writer->set_json_content("$request");
});

$app->get("/", function (&$writer, $request){
    $writer->set_json_content("$request");
});


$app->get("/file", function (&$writer, $request){
    $content = Loader\load_file("D:/oliver/Documents/coding/PHP/netstuff/backend/public/index.html");
    $writer->set_content($content);
});

$app->get("/json", function (&$writer, $request){
    $arr = ["name"=>"john"];
    $content = json_encode($arr);
    $writer->set_json_content($content);
});


$app->start();
// echo __DIR__;
echo Loader\load_file("D:/oliver/Documents/coding/PHP/netstuff/backend/public/index.html");


?>