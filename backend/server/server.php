<?php namespace Applet;

require "request_details.php";
require "response_writer.php";

class Server {
    
    private $handlers;
    function __construct(){
        $this->MAX_READ_SIZE  = 1024;
        $this->handlers = ["GET"=>[], "PUT"=>[], "POST"=>[], "DELETE"=>[]];
    }

    function get($pattern, $handle){
        $this->handlers["GET"][$pattern] = $handle;
    }
    function post($pattern, $handle){
        $this->handlers["POST"][$pattern] = $handle;
    }
    function put($pattern, $handle){
        $this->handlers["PUT"][$pattern] = $handle;
    }
    function delete($pattern, $handle){
        $this->handlers["DELETE"][$pattern] = $handle;
    }

    function start($host="localhost", $port=8000){
        
        set_time_limit(0); // No Timeout 
        $sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n"); //Create Socket
        socket_bind($sock, $host, $port) or die("Could not bind to socket\n"); //Bind the socket to port and host
        echo "server started at http://$host:$port \n";
    
        while(true) {
            socket_listen($sock, 3) or die("Could not set up socket listener\n"); //Start listening to the port
            $spawn = socket_accept($sock) or die("Could not accept incoming connection\n");
            $this->handle_client($spawn);
            socket_close($spawn);

        }
        socket_close($sock);

    }

    function handle_client($spawn){

        $input = socket_read($spawn, $this->MAX_READ_SIZE);
        if ($input === false) return false;
        $request = new Request($input);
        $writer = new ResponseWriter();
        $this->handle_request($writer, $request);
        socket_write($spawn, $writer->get_response(), $writer->get_content_length()) or $this->handle_empty($writer, $request);
    }

    function handle_request(&$writer, $request){
        if ($request->partial_url == "favicon.ico") return $this->handle_favicon($writer, $request);
        foreach($this->handlers[$request->method] as $pattern => $function){
               if ($pattern == $request->partial_url){
                         $function($writer, $request);
                        return;
               }
        }
        $this->handle_empty($writer, $request);

    }

    function handle_favicon(&$writer, $request){
        $content ="<html><head><link rel=\"icon\" href=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVQI12P4//8/AAX+Av7czFnnAAAAAElFTkSuQmCC\"></head>";
        $writer->set_content($content);
    }

    function handle_empty(&$writer, $request){
        // $content ="<html><head><title>Example</title></head><body><p>No URL MATCH</p></body></html>";
        // $writer->set_content($content);
        $writer->set_json_content("$request");
    }
}


?>