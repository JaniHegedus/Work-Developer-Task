<?php
function console_log($output, $with_script_tags = true): void//Console logging PHP
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .');';//JSON Encoding
    if ($with_script_tags)
    {
        $js_code = '<script>' . $js_code . '</script>';//Adding to script
    }
    echo $js_code; //Sending Script
}
?>