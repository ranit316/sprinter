<?php
use App\Models\Cms_pages;

function responseData($data, $message = "",$status=true)
{
    return [
        "success" => $status,
        "message" => $message,
        "data" => $data
    ];
}
function footer_content()
{
    $data = Cms_pages::all();
    return  $data;
}
?>