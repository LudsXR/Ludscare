<?php


function generateResponse($arr, $success, $message, $errors, $type = 'paginated')
{
    // $logs_name = 'generateResponse';
    // if(!$success){
    //     $logs_name = 'errorResponse';
    // }
    // Log::channel($logs_name)->info("$logs_name => ", [ $success, $message,$errors,$type,$_SERVER['REQUEST_URI']]);

    if ($type == 'paginated') {
        if (!isset($arr['data'])) {
            $arr['data'] = [];
        }
        $arr['success'] = $success;
        $arr['message'] = $message;
        $arr['errors'] = $errors;
        return $arr;
    } else {
        $response = [];
        $response['data'] = $arr;
        $response['success'] = $success;
        $response['message'] = $message;
        $response['errors'] = $errors;
        return $response;
    }
}

?>
