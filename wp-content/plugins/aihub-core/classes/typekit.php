<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( function_exists('liquid_helper') && !empty( liquid_helper()->get_kit_option( 'liquid_typekit_id' ) ) ) :

/*
 * Typekit PHP API Client.
 * Kindly thanks to bramstein
 * https://github.com/bramstein/php-typekit
 */

class Typekit {
   private $timeout = 30;
   private $api = "/api/v1/json/kits/";
   private $debug = false;

   /**
	* Create a new instance of the client
	* @param {number=} timeout Connection timeout in seconds (default is 30 seconds.)
	* @param {boolean=} debug Print debug information (default is false.)
	*/
   function __construct($timeout = 30, $debug = false) {
	   $this->timeout = $timeout;
	   $this->debug = $debug;
   }

   /**
	* Create a socket.
	*
	* @return {number|boolean} Returns a socket or false if creating
	* a socket failed.
	*/
   private function create_socket () {
	   try {
		   $socket = pfsockopen("ssl://typekit.com", 443, $errno, $errstr, $this->timeout);

		   if ($errno != 0) {
			   return false;
		   }
		   return $socket;
	   } catch (Exception $e) {
		   return false;
	   }
   }

   /**
	* Make a request and read the response. If succesful,
	* a tuple of HTTP status code and response data is
	* returned. If an error occurs NULL is returned.
	*
	* @param {number} socket
	* @param {string} request
	* @return {(number, string)|null}
	*/
   private function make_request($socket, $request) {
	   $bytes_total = strlen($request);

	   if ($this->debug) {
		   echo $request;
		   echo "\r\n\r\n-----------------\r\n\r\n";
	   }

	   for ($bytes_written = 0; $bytes_written < $bytes_total; $bytes_written += $fwrite) {
		   $fwrite = fwrite($socket, substr($request, $bytes_written));

		   if ($fwrite === false) {
			   return NULL;
		   }
	   }

	   if ($bytes_written === $bytes_total) {
		   $status = 500;
		   $data = NULL;

		   $buffer = "";

		   while (!feof($socket)) {
			   $buffer .= fread($socket, 1024);
			   if (preg_match("/\r\n\r\n/", $buffer)) {
				   list($headers, $body) = preg_split("/\r\n\r\n/", $buffer);

				   if ($this->debug) {
					   echo $headers . "\r\n\r\n";
				   }

				   preg_match("/HTTP\/1\.1 (\d+)/", $headers, $matches);

				   $status = $matches[1];
				   if (preg_match("/Content-Length: (\d+)/", $headers, $matches)) {

					   $size = $matches[1];

					   if (strlen($body) < $size) {
						   $data = $body . fread($socket, $size - strlen($body));
					   } else {
						   $data = $body;
					   }

					   if ($this->debug) {
						   echo $data;
					   }
				   }
				   break;
			   }
		   }
		   if ($this->debug) {
			   echo "\n\r\r\n-----------------\r\n\r\n";
		   }
		   return array($status, $data);
	   } else {
		   return NULL;
	   }
   }

   /**
	* Creates a POST request.
	*
	* @param {string} path Request path.
	* @param {string} token Typekit API token.
	* @param {Object=} content Request body.
	* @return {string} The formatted request.
	*/
   private function create_post_request($path, $token, $content = NULL) {
	   $request =  "POST " . $path . " HTTP/1.1\r\n";
	   $request .= "Host: typekit.com\r\n";
	   $request .= "Accept: application/json\r\n";
	   $request .= "X-Typekit-Token: " . $token . "\r\n";

	   if (!is_null($content)) {
		   $data = http_build_query($content);

		   $request .= "Content-Type: application/x-www-form-urlencoded\r\n";
		   $request .= "Content-length: " . strlen($data) . "\r\n";
		   $request .= "\r\n";
		   $request .= $data;
	   } else {
		   $request .= "\r\n";
	   }
	   return $request;
   }

   /**
	* Creates a GET request.
	*
	* @param {string} path Request path.
	* @param {string=} token Typekit API token.
	* @return {string} The formatted request.
	*/
   private function create_get_request($path, $token = NULL) {
	   $request =  "GET " . $path . " HTTP/1.1\r\n";
	   $request .= "Host: typekit.com\r\n";
	   $request .= "Accept: application/json\r\n";

	   if (!is_null($token)) {
		   $request .= "X-Typekit-Token: " . $token . "\r\n";
	   }
	   $request .= "\r\n";

	   return $request;
   }

   /**
	* Creates a DELETE request.
	*
	* @param {string} path Request path.
	* @param {string} token Typekit API token.
	* @return {string} The formatted request.
	*/
   private function create_delete_request($path, $token) {
	   $request =  "DELETE " . $path . " HTTP/1.1\r\n";
	   $request .= "Host: typekit.com\r\n";
	   $request .= "X-Typekit-Token: " . $token . "\r\n";
	   $request .= "\r\n";

	   return $request;
   }

   /**
	* Get one or more kits. If kit identifier is not given
	* all kits are returned.
	*
	* @param {string=} id The kit identifier (optional)
	* @param {string=} token Your Typekit API token (optional)
	* @return {string|null} NULL if retrieving the kit(s) failed, otherwise it return the data
	*/
   function get($id = NULL, $token = NULL) {
	   $socket = $this->create_socket();

	   if ($socket) {
		   if (!is_null($id)) {
			   if (!is_null($token)) {
				   $request = $this->create_get_request($this->api . $id . "/", $token);
			   } else {
				   $request = $this->create_get_request($this->api . $id . "/published", $token);
			   }
		   } else {
			   $request = $this->create_get_request($this->api, $token);
		   }

		   $result = $this->make_request($socket, $request);

		   if (!is_null($result)) {
			   list($status, $data) = $result;

			   if ($status == "200") {
				   return json_decode($data, true);
			   }
		   }
	   }
	   return NULL;
   }

   /**
	* Remove a kit.
	*
	* @param {string} id Kit identifier.
	* @param {string} token Typekit API token.
	* @return {boolean} True if the kit was removed, false otherwise.
	*/
   function remove($id, $token) {
	   $socket = $this->create_socket();

	   if ($socket) {
		   $request = $this->create_delete_request($this->api . $id . "/", $token);

		   $result = $this->make_request($socket, $request);

		   if (!is_null($result)) {
			   list($status, ) = $result;

			   return $status == "200";
		   }
	   }
	   return false;
   }

   /**
	* Publish the kit with the given identifier.
	*
	* @param {string} id Kit identifier.
	* @param {string} token Typekit API token.
	* @return {boolean} True if this kit was published, false otherwise.
	*/
   function publish($id, $token) {
	   $socket = $this->create_socket();

	   if ($socket) {
		   $request = $this->create_post_request($this->api . $id . "/publish", $token);

		   $result = $this->make_request($socket, $request);

		   if (!is_null($result)) {
			   list($status, ) = $result;
			   return $status == "200";
		   }
	   }
	   return false;
   }

   /**
	* Update an existing kit.
	*
	* @param {string} id Kit identifier.
	* @param {Object} data The kit data.
	* @param {string} token Typekit API token.
	* @return {Object?} Returns an object or null if the update failed.
	*/
   function update($id, $data, $token) {
	   $socket = $this->create_socket();

	   if ($socket) {
		   $request = $this->create_post_request($this->api . $id, $token, $data);

		   $result = $this->make_request($socket, $request);

		   if (!is_null($result)) {
			   list($status, $data) = $result;

			   if ($status == "200") {
				   return json_decode($data, true);
			   }
		   }
	   }
	   return NULL;
   }

   /**
	* Create a new kit.
	*
	* @param {Object} data The kit data.
	* @param {string} token Typekit API token.
	* @return {Object?} The kit data or null on failure.
	*/
   function create($data, $token) {
	   $socket = $this->create_socket();

	   if ($socket) {
		   $request = $this->create_post_request($this->api, $token, $data);

		   $result = $this->make_request($socket, $request);

		   if (!is_null($result)) {
			   list($status, $data) = $result;

			   if ($status == "200") {
				   return json_decode($data, true);
			   }
		   }
	   }
	   return NULL;
   }
}

if( class_exists( 'Typekit' ) ) {
	
	class Liquid_Elementor_Typekit extends Typekit {

		private $typekit_id = null;
	
		private $typekit_fonts = null;
	
		function __construct() {

			$this->typekit_id = liquid_helper()->get_kit_option( 'liquid_typekit_id' );
			$this->typekit_fonts = $this->get_typekit_fonts_array( $this->typekit_id );
			
            // Add Group Fonts
			add_filter( 'elementor/fonts/additional_fonts', [ $this, 'get_typekit_fonts_array' ] );

			// Print Fonts CSS
			add_action( 'wp_enqueue_scripts', [ $this, 'print_fonts_css'] );
	
		}
		
		function get_typekit_fonts_array( $kit_id = false ) {

			$force 	= $kit_id !== false ? true : false;
			$kit_id = $kit_id ? $kit_id : $this->typekit_id;

			if ( !$kit_id ) {
				return array();
			}
			
			if ( $force ) {
				$kit = $this->get( $kit_id );			
			}
			
			$ret = array();

			if ( isset( $kit['kit']['families'] ) ) {
                // Add Fonts Group
                add_filter( 'elementor/fonts/groups', function( $font_groups ) {
                    $font_groups['liquid_typekit_fonts'] = __( 'Typekit Fonts' );
                    return $font_groups;
                } );

                
				foreach ( $kit['kit']['families'] as $family ) {
					
					if( isset( $family['css_names'][0] ) ) {
						$slug = $family['css_names'][0];	
					} else {
						$slug = $family['slug'];
					}

                    $ret[$family['slug']] = 'liquid_typekit_fonts';
				}

                //print_r($ret);
				
				return $ret;
			} else {
				return false;
			}
		}

		function print_fonts_css() {

			$css = get_option( 'liquid_typekit_css', '' );

			if ( empty( $css ) ) {
				$url = "https://use.typekit.net/{$this->typekit_id}.css";
				$response = wp_remote_get( esc_url_raw( $url ) );
				if ( ! is_wp_error( $response ) ) {
					if ( isset( $response['body'] ) ) {
						$css = $response['body'];
						update_option( 'liquid_typekit_css', $response['body'] );
					}
				}
			}

			if ( !empty($css) ) {
				wp_add_inline_style( 'liquid-wp-style', $css );
			}

		}
	
	}

	new Liquid_Elementor_Typekit;

}

endif;