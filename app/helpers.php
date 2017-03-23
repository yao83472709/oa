<?php

/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * 删除数组指定元素
 */
function array_remove(&$arr, $offset)
{
	array_splice($arr, $offset, 1);
}

function sentTo($email, $subject, $view, $data = [])
{
    $result = \Mail::send($view, $data, function ($message) use ($email,$subject) {
        $message->to($email)->subject($subject);
    });
    return $result;die;
}
