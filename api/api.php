<?php

require_once 'HTTP/Request2.php'; // 确保这个路径与你的环境相匹配

// 判断是否有文件上传
if (!isset($_FILES["file"])) {
    outputResult(array(
        "code" => 201,
        "msg" => "没有上传文件！"
    ));
    exit;
}

$file = $_FILES["file"]["name"];
$fileType = $_FILES["file"]["type"];
$filepath = $_FILES["file"]["tmp_name"];

// 调用upload_image函数上传图片
$imgUrl = upload_image($filepath, $fileType, $file);
if ($imgUrl) {
    $result = array(
        "code" => 200,
        "msg" => "上传成功",
        "url" => $imgUrl
    );
} else {
    $result = array(
        "code" => 201,
        "msg" => "图片上传失败！请检查接口可用性！"
    );
}

// 输出结果
outputResult($result);

function upload_image($filepath, $fileType, $fileName) {
    $request = new HTTP_Request2();
    $request->setUrl('https://upload-forum.idmzj.com/php/controller?action=uploadimage');
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setConfig(array(
        'follow_redirects' => TRUE
    ));
    $request->addPostParameter('action', 'uploadimage');
    $request->addUpload('upfile', $filepath, $fileName, $fileType);

    try {
        $response = $request->send();
        if ($response->getStatus() == 200) {
            $body = $response->getBody();
            $data = json_decode($body, true);
            if ($data && $data['state'] == "SUCCESS") {
                return $data['url'];
            } else {
                return false;
            }
        } else {
            echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
            $response->getReasonPhrase();
            return false;
        }
    } catch (HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function outputResult($result) {
    header("Content-type: application/json");
    echo json_encode($result);
}
?>
