<?php 

const RECORD_PER_PAGE = 10;

function saveUploadedFile($file, $folder = "images")
{
    $fileName = rand() . '_' . time() . '.' . $file->getClientOriginalExtension();
    Storage::disk($folder)->putFileAs('/', $file, $fileName);
    return Storage::disk($folder)->url($fileName);
}


if (! function_exists('returnNotFoundResponse')) {

    function returnNotFoundResponse($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 404,
            'status' => 'not found',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr, 404);
    }
}

if (! function_exists('returnValidationErrorResponse')) {

    function returnValidationErrorResponse($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 422,
            'status' => 'vaidation error',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr, 422);
    }
}

if (! function_exists('returnSuccessResponse')) {

    function returnSuccessResponse($message = '', $data = array(), $is_array = false)
    {
        $is_array = !empty($is_array)?[]:(object)[];
        $returnArr = [
            'statusCode' => 200,
            'status' => 'success',
            'message' => $message,
            'data' => ($data) ? ($data) : $is_array
        ];
        return response()->json($returnArr, 200);
    }
}

if (! function_exists('returnErrorResponse')) {

    function returnErrorResponse($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 500,
            'status' => 'error',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr, 500);
    }
}

if (! function_exists('returnCustomErrorResponse')) {

    function returnCustomErrorResponse($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 404,
            'status' => 'error',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr, 200);
    }
}

if (! function_exists('returnError301Response')) {

    function returnError301Response($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 301,
            'status' => 'error',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr, 301);
    }
}

if (! function_exists('notAuthorizedResponse')) {

    function notAuthorizedResponse($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 401,
            'status' => 'error',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr);
    }
}

if (! function_exists('forbiddenResponse')) {

    function forbiddenResponse($message = '', $data = array())
    {
        $returnArr = [
            'statusCode' => 403,
            'status' => 'error',
            'message' => $message,
            'data' => ($data) ? ($data) : ((object) $data)
        ];
        return response()->json($returnArr, 403);
    }
}