<?php

/**
 * @param int $user_id - id пользователя, которому нужно отправить сообщение
 * @param string $message - тело сообщения
 */
function bot_sendMessage($user_id, $message)
{
    $user = vkApi_usersGet($user_id)[0];
    //log_msg($user['first_name']);
    return vkApi_messagesSend($user_id, $message);


}

/**
 * @param int $group_id - id группы, в которой нужно заблокировать пользователя/группу
 * @param int $owner_id - id пользователя или группы для блокировки (в случае с группой перед id нужно поставить знак минус)
 * @param int $end_date - время бана, в секундах
 * @param string $comment - причина блокировки, показывается пользователю в группе
 */
function bot_banUser($group_id, $owner_id, $end_date, $comment)
{
    $user = vkApi_usersGet($owner_id)[0];
    log_msg($user['first_name'].' '.$user['last_name'] . ' забанен на 7 дней за глупые вопросы');
    return vkApi_groupsBan($group_id, $owner_id, $end_date, $comment);

}
