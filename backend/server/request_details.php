<?php namespace Applet;


class Request {
    
    public $method;
    public $partial_url;
    public $protocol;
    public $headers;
    function __construct($req_str){
        $this->__parseRequest($req_str);
        // print_r($this->headers);
    }
    private function __parseRequest($req_str){
        $parsed = explode("\n", $req_str);
        $this->__parse_array($parsed[0]);
        $this->__parse_to_dict(array_slice($parsed, 1));

    }
    private function __parse_array($array){
        $array_split = explode(" ", $array);
        $this->method = $array_split[0];
        $this->partial_url = $array_split[1];
        $this->protocol = $array_split[2];
    }

    public function __toString(){    
        return  $this->__toJson();
      }

      public function __toJson(){    
        $details = ["method"=>$this->method,  "partial_url"=>$this->partial_url, "protocol"=>$this->protocol];
        $details["header"] = $this->headers;
        return  str_replace(["\n", "\r", "\t"], "", stripcslashes(json_encode($details))) ;
      }
    
    private function __parse_to_dict($array){

        $this->headers = array();
        foreach ($array as $_ => $value){
            
            if (strlen($value) < 2) continue;

            $key_val = explode(":", $value);
            
            if(count($key_val)==2){
                $this->headers[$key_val[0]] = $key_val[1];
            } else {
                $temp = [];
                $count = count($key_val);
                for ($i = 1; $i < $count; $i++){
                    $temp[] =$key_val[$i]; 
                }
                $this->headers[$key_val[0]] = implode(":", $temp);
            }
        }

    }
}

?>