<?php

define('VK_API_VERSION', '5.67'); //Используемая версия API
define('VK_API_ENDPOINT', 'https://api.vk.com/method/');

function vkApi_messagesSend($peer_id, $message)
{
    return _vkApi_call('messages.send', array(
        'peer_id' => $peer_id,
        'message' => $message,
    ));
}

function vkApi_usersGet($user_id)
{

    return _vkApi_call('users.get', array(
        'user_id' => $user_id,
    ));

}

function vkApi_groupsBan($group_id, $owner_id, $end_date, $comment)
{
    return _vkApi_call('groups.ban', array(
        'group_id' => $group_id,
        'owner_id' => $owner_id,
        'end_date' => $end_date,
        'reason' => 0,
        'comment' => $comment,
        'comment_visible' => 1
    ), 'user');
}

function _vkApi_call($method, $params = array(), $token_type = 'group')
{
    $params['access_token'] = $token_type === 'group' ? VK_API_GROUP_ACCESS_TOKEN : VK_API_USER_ACCESS_TOKEN;
    $params['v'] = VK_API_VERSION;

    $query = http_build_query($params);
    $url = VK_API_ENDPOINT . $method . '?' . $query;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $json = curl_exec($curl);
    $error = curl_error($curl);
    if ($error) {
        log_error($error);
        throw new Exception("Failed {$method} request");
    }

    curl_close($curl);

    $response = json_decode($json, true);
    if (!$response || !isset($response['response'])) {
        log_error($json);
        throw new Exception("Invalid response for {$method} request");
    }

    return $response['response'];
}
