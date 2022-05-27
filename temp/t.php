<?php
require "request_details.php";
require "response_writer.php";


class Server {

    public $MAX_READ_SIZE;
    function __construct(){
        $this->MAX_READ_SIZE  = 1024;
        echo $this->MAX_READ_SIZE;
    }

    function start($host="localhost", $port=8000){
        
        set_time_limit(0); // No Timeout 
        $sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n"); //Create Socket
        socket_bind($sock, $host, $port) or die("Could not bind to socket\n"); //Bind the socket to port and host

        echo "server started at http://$host:$port \n";
    
        while(true) {
            socket_listen($sock, 3) or die("Could not set up socket listener\n");
            $spawn = socket_accept($sock) or die("Could not accept incoming connection\n");
            $input = socket_read($spawn, 1024) or die("Could not read input\n");
            $writer = $this->handle_request($input);
            socket_write($spawn, $writer->get_response(), $writer->get_content_length()) or die("Could not write output\n");
            socket_close($spawn);        
        }

        socket_close($sock);

    }
    function handle_request($input){

        
        $request = new Request($input);
        $writer = new ResponseWriter();

        $this->handle_request($writer, $request);
        return $writer;

    }

    function process_request(&$writer, $request){
        $content ="<html><head><title>Example</title></head><body><p>Worked!!!</p></body></html>";
        $writer->set_content($content);
    }
}


// class RequestIn extends Thread {
//     private $response;

//     public function run()
//     {
//         $content = file_get_contents("http://google.com");
//         preg_match("~<title>(.+)</title>~", $content, $matches);
//         $this->response = $matches[1];
//     }
// };

?>