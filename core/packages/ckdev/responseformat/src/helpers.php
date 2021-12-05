<?php

if (!function_exists("jsend_format")) {
    /**
     * @param string $message Error message
     * @param string $code Optional custom error code
     * @param string | array $data Optional data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_format($responsedata = [])
    {
		$data = array();
		foreach($responsedata as $row=>$value){
			$data[$row] = $value[0];				
		}
		return $data;
    }
}


if (!function_exists("jsend_error")) {
    /**
     * @param string $message Error message
     * @param string $code Optional custom error code
     * @param string | array $data Optional data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_error($message, $code = null, $data = null, $status = 401, $extraHeaders = [])
    {
        $response = [
            "status" => "0",
            "message" => $message
        ];
        !is_null($code) && $response['code'] = $code;
        !is_null($data) && $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists("jsend_fail")) {
    /**
     * @param array $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_fail($data, $status = 401, $extraHeaders = [])
    {
        $response = [
            "status" => "0",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists("jsend_success")) {
    /**
     * @param array | Illuminate\Database\Eloquent\Model $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function jsend_success($data, $status = 200, $extraHeaders = [])
    {
		$response = [
            "status" => "1",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }
}
