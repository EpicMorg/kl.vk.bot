<?php

define('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation');
define('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new');
define('CALLBACK_API_EVENT_TEST', 'test');

require_once 'config.php';
require_once 'global.php';

require_once 'api/vk_api.php';
require_once 'bot/bot.php';

if (!isset($_REQUEST)) {
    exit;
}

callback_handleEvent();

function callback_handleEvent()
{
    $event = _callback_getEvent();

    //
    if ($event['secret'] != VK_API_GROUP_SECRET) {
        log_msg('Unauthorized access from ' . $_SERVER['REMOTE_ADDR']);
        exit;
    }

    try {
        switch ($event['type']) {
            //Подтверждение сервера
            case CALLBACK_API_EVENT_CONFIRMATION:
                _callback_handleConfirmation();
                break;

            //Получение нового сообщения
            case CALLBACK_API_EVENT_MESSAGE_NEW:

                _callback_handleMessageNew($event['object'], $event['group_id']);
                break;
            case CALLBACK_API_EVENT_TEST:
                _callback_response('Test');
                break;

            default:
                _callback_response('Unsupported event');
                break;
        }
    } catch (Exception $e) {
        log_error($e);
    }

    _callback_okResponse();
}

function _callback_getEvent()
{
    return json_decode(file_get_contents('php://input'), true);
}

function _callback_handleConfirmation()
{
    _callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
}

function _callback_handleMessageNew($data, $group_id)
{
    $user_id = $data['user_id'];
    /**
     *  Если пользователь произнес стоп-слово или фразу, то отрабатывает блокировка
     */
    if (preg_match(BAN_REGEXP_PATTERN, $data['body']) === 1) {
        $owner_id = $user_id;
        $end_date = time() + 604800;
        $comment = BAN_REASON;
        bot_banUser($group_id, $owner_id, $end_date, $comment);
        bot_sendMessage($user_id, BAN_MESSAGE);
    } else {
        //bot_sendMessage($user_id, 'Ты лол');
    }

    _callback_okResponse();
}

function _callback_okResponse()
{
    _callback_response('ok');
}

function _callback_response($data)
{
    echo $data;
    exit();
}


