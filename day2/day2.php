<?php
function _retriever($url, $data = NULL, $header = NULL, $method = 'GET')
{
    $cookie_file_path = dirname(__FILE__) . "/cookie/farmrpg.txt";
    $datas['http_code'] = 0;
    if ($url == "")
        return $datas;
    $data_string = '';
    if ($data != NULL) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data_string .= $key . '=' . $value . '&';
            }
        } else {
            $data_string = $data;
        }
    }

    $ch = curl_init();
    if ($header != NULL)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt(
        $ch,
        CURLOPT_USERAGENT,
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

    if ($data != NULL) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    }

    $html = curl_exec($ch);
    //echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //echo $html;
    if (!curl_errno($ch)) {
        $datas['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($datas['http_code'] == 200) {
            $datas['result'] = $html;
        }
    }
    curl_close($ch);
    return $datas;
}

function fishing(){
    $header = array(
        'origin: https://farmrpg.com',
        'referer: https://farmrpg.com/index.php',
    );
    $html = _retriever('https://farmrpg.com/worker.php?go=fishcaught&id=1&r=411573',NULL, $header ,'POST');
    return $html;
}

function explore(){
    $header = array(
        'origin: https://farmrpg.com',
        'referer: https://farmrpg.com/index.php',
    );
    $html = _retriever('https://farmrpg.com/worker.php?go=explore&id=1',NULL, $header ,'POST');
    return $html;
}

function auto(){
    $data=array();
    $data['fishing']= fishing();
    $data['explore']= explore();

    return json_encode($data);
}

$result = explore();
print_r($result);