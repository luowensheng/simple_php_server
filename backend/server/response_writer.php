<?php namespace Applet;


class ResponseWriter {
    
    private $protocol; 
    private $status_code; 
    private $status; 
    private $content_type; 
    private $content; 

    function __construct() {
        $this->protocol = "HTTP/1.1"; 
        $this->status_code = 200; 
        $this->status = "OK"; 
        $this->content_type = "text/html";  
        $this->content="";
    }

    function set_protocol($value) {
        $this->protocol = $value;
    }
    function set_status_code($value) {
        $this->status_code = $value;
    }
    function set_status($value) {
        $this->status = $value;
    }
    function set_content_type($value) {
        $this->content_type = $value;
    }
    function set_content($value) {
        $this->content = $value;
    }

    function set_json_content($value) {
        $this->content_type = "application/json";
        $this->content = "<pre>$value</pre>";
    }

    function get_content_length(){
        return strlen("$this");
    }
    function get_response(){
        return "$this";
    }

    function __toString() {
        return "$this->protocol $this->status_code $this->status\r\nContent-Type: $this->content_type\r\n\r\n\r\n$this->content";
    }
}

?>