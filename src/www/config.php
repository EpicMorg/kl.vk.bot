<?php

define('BOT_LOGS_DIRECTORY', dirname(__FILE__) . '/logs');

define('CALLBACK_API_CONFIRMATION_TOKEN', ''); //Строка для подтверждения адреса сервера из настроек Callback API
define('VK_API_GROUP_ACCESS_TOKEN', ''); //Ключ доступа сообщества
define('VK_API_USER_ACCESS_TOKEN', ''); //Ключ пользователя (для Standalone App, https://vk.com/dev/implicit_flow_user)
define('VK_API_GROUP_SECRET', '');

/**
 * Регулярное выражение, по которому будет баниться пользователь
 */
define('BAN_REGEXP_PATTERN', '/\s?\S*(кач|установ|запус)\S*/i');

/**
 * Причина бана, отображается в группе
 */
define('BAN_REASON', 'Вы были забанены');

/**
 * Сообщение в личку после бана
 */
define('BAN_MESSAGE', 'Вы были забанены');