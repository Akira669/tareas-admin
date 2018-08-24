<?php 

	function verifyRequiredParams($required_fields) {
	    $error = false;
	    $error_fields = "";
	    $request_params = array();
	    $request_params = $_REQUEST;

	    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	        $app = \Slim\App::getInstance();
	        parse_str($app->request()->getBody(), $request_params);
	    }

	    foreach ($required_fields as $field) {
	        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
	            $error = true;
	            $error_fields .= $field . ', ';
	        }
	    }
	 
	    if ($error) {
	        $response = array();
	        $app = \Slim\App::getInstance();
	        $response["error"] = true;
	        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
	        echoResponse(400, $response);
	        
	        $app->stop();
	    }
	}
	 

	function validateEmail($email) {
	    $app = \Slim\App::getInstance();
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        $response["error"] = true;
	        $response["message"] = 'Email address is not valid';
	        echoResponse(400, $response);
	        
	        $app->stop();
	    }
	}
	 

	function echoResponse($status_code, $response) {
	   $app = \Slim\App::getInstance();
	    $app->status($status_code);
	    $app->contentType('application/json');
	    echo json_encode($response);
	}

	function authenticate(\Slim\Route $route) {

	    $headers = apache_request_headers();
	    $response = array();
	    $app = \Slim\Slim::getInstance();
	 

	    if (isset($headers['Authorization'])) {

	        $token = $headers['Authorization'];
	        
	        if (!($token == API_KEY)) { 
	            $response["error"] = true;
	            $response["message"] = "Acceso denegado. Token inválido";
	            echoResponse(401, $response);
	            $app->stop(); 
	        }
	    } else {
	        $response["error"] = true;
	        $response["message"] = "Falta token de autorización";
	        echoResponse(400, $response);
	        $app->stop();
	    }
	}

?>