<?php
   include "./test.php";

	$host = "localhost";
	// $host = "192.168.99.1";
	$port = 8000;
	
	// No Timeout 
	set_time_limit(0);

	//Create Socket
	$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

	//Bind the socket to port and host
	$result = socket_bind($sock, $host, $port) or die("Could not bind to socket\n");

	while(true) {
        break;
		//Start listening to the port
		$result = socket_listen($sock, 3) or die("Could not set up socket listener\n");

		//Make it to accept incoming connection
		$spawn = socket_accept($sock) or die("Could not accept incoming connection\n");

		//Read the message from the client socket
		$input = socket_read($spawn, 1024) or die("Could not read input\n");

		$output ="HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n\r\n<html><head><title>Example</title></head><body><p>Worked!!!</p></body></html>";;

		//Send message back to client socket
		socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");

	socket_close($spawn);
}
socket_close($sock);

?>
