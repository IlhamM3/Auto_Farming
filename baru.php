<?php
function _retriever($url, $data = NULL, $header = NULL, $method = 'GET')
{
    $cookie_file_path = dirname(__FILE__) . "/cookie/techinasia.txt";
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

$html = _retriever('https://mercuryfm.id/');
// print_r($html['result']);  

$t_start = strpos($html['result'], '<div class="jeg_heroblock_wrapper"');
// print_r($t_start);
$t_html = substr($html['result'], $t_start);
// print_r($t_html);

// Link
$t_link_start = strpos($t_html,'<a href=')+9;
$t_link_end = strpos($t_html,'992/" >')+5;
$t_link_len = $t_link_end - $t_link_start;
$link = substr($t_html, $t_link_start, $t_link_len);
print_r($link. '<br>');

//Image
$t_img_start = strpos($t_html,'data-src="')+10;
$t_img_end = strpos($t_html,'<div class="lazyloaded"')-28;
$t_img_length = $t_img_end - $t_img_start;
$img = substr($t_html, $t_img_start, $t_img_length);
// print_r($img. '<br>');

//title
$t_title_start = strpos($t_html,'992/">')+6;
$t_title_end = strpos($t_html,'<div class="jeg_post_meta">')-75;
$t_title_length = $t_title_end - $t_title_start;
$title= substr($t_html, $t_title_start, $t_title_length);
// print_r($title. '<br>');

//detail
$h_html = _retriever($link);
print_r($h_html);