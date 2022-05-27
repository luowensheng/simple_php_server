<?php

class Server {
  function __construct(){

   }
}
$p  = 0;
function handle_index($method){
    echo $GLOBALS['p'] . "welcome". $method;
}
function handle_home($method){
    echo $GLOBALS['p'] . "home". $method;
}
function handle_about($method){
    echo $GLOBALS['p'] . "about". $method;
}
function handle_help($method){
    echo $GLOBALS['p'] . "help". $method;
}
function handle_default($method){
    echo $GLOBALS['p'] . "Error". $method;
}

function main(){
    $GLOBALS['p']+= 1;
   $method = $_SERVER["REQUEST_METHOD"]; 
   switch ($_SERVER["SCRIPT_NAME"]) {
       case '/':
           handle_index($method);
           break;
       case '/home':
            handle_home($method);
            break;
        case '/about':
            handle_about($method);
            break;
        case '/help':
            handle_help($method);
            break;
        default:
           handle_default($method);
           break;
   } 
}

main()

?>