<?php
/**
 * Валидатор БОТ
 */
// require "extranet.php";

$appsConfig = array();
$configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';
if (file_exists(__DIR__ . $configFileName)) {
    include_once __DIR__ . $configFileName;
}
// receive event "new message for bot"
if ($_REQUEST['event'] == 'ONIMBOTMESSAGEADD') {

    if (!isset($_REQUEST['auth']['application_token'])) {
        return false;
    }

    $msg = strtolower($_REQUEST['data']['PARAMS']['MESSAGE']);

    main_menu($_REQUEST['data']['PARAMS']['FROM_USER_ID']);
} elseif ($_REQUEST['event'] == 'ONIMCOMMANDADD') {
    if (!isset($_REQUEST['auth']['application_token'])) {
        return false;
    }

    foreach ($_REQUEST['data']['COMMAND'] as $command) {
        switch ($command['COMMAND']) {
            default:
                break;
        }
    }
} elseif ($_REQUEST['event'] == 'ONIMBOTJOINCHAT') {
    // check the event - register this application or not
    if (!isset($appsConfig[$_REQUEST['auth']['application_token']])) {
        return false;
    }
    // send help message how to use chat-bot. For private chat and for group chat need send different instructions.
    welcom_menu($_REQUEST['data']['PARAMS']['FROM_USER_ID']);
} // receive event "delete chat-bot"
elseif ($_REQUEST['event'] == 'ONIMBOTDELETE') {
    // check the event - register this application or not
    if (!isset($appsConfig[$_REQUEST['auth']['application_token']])) {
        return false;
    }
    // unset application variables
    unset($appsConfig[$_REQUEST['auth']['application_token']]);
    // save params
    saveParams($appsConfig);
} // receive event "Application install"
else if ($_REQUEST['event'] == 'ONAPPINSTALL') {
    // handler for events
    $handlerBackUrl = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . (in_array($_SERVER['SERVER_PORT'],
        array(80, 443)) ? '' : ':' . $_SERVER['SERVER_PORT']) . $_SERVER['SCRIPT_NAME'];
    $result = restCommand('imbot.register', array(
        'CODE' => 'ValidatorBot',
        // строковой идентификатор бота, уникальный в рамках вашего приложения (обяз.)
        'TYPE' => 'B',
        // Тип бота, B - бот, ответы  поступают сразу, H - человек, ответы поступаю с задержкой от 2х до 10 секунд
        'EVENT_MESSAGE_ADD' => $handlerBackUrl,
        'EVENT_JOIN_CHAT' => $handlerBackUrl,
        // Ссылка на обработчик события отправки сообщения боту (обяз.)
        'EVENT_WELCOME_MESSAGE' => $handlerBackUrl,
        // Ссылка на обработчик события открытия диалога с ботом или приглашения его в групповой чат (обяз.)
        'EVENT_BOT_DELETE' => $handlerBackUrl,
        // Ссылка на обработчик события удаление бота со стороны клиента (обяз.)
        'PROPERTIES' => array( // Личные данные чат-бота (обяз.)
            'NAME' => 'Валидатор БОТ',
            // Имя бота (обязательное одно из полей NAME или LAST_NAME)
            'LAST_NAME' => '',
            // Фамилия бота (обязательное одно из полей NAME или LAST_NAME)
            'COLOR' => 'AQUA',
            // Цвет бота для мобильного приложения RED,  GREEN, MINT, LIGHT_BLUE, DARK_BLUE, PURPLE, AQUA, PINK, LIME, BROWN,  AZURE, KHAKI, SAND, MARENGO, GRAY, GRAPHITE
            'EMAIL' => 'validatorno@mail.com',
            // Емейл для связи
            'PERSONAL_BIRTHDAY' => '2016-03-23',
            // День рождения в формате YYYY-mm-dd
            'WORK_POSITION' => 'Бот',
            // Занимаемая должность, используется как описание бота
            'PERSONAL_WWW' => '',
            // Ссылка на сайт
            'PERSONAL_GENDER' => 'M',
            // Пол бота, допустимые значения M -  мужской, F - женский, пусто если не требуется указывать
        ),
    ), $_REQUEST["auth"]);
    $botId = $result['result'];

    $result = restCommand('imbot.app.register', array(
         'BOT_ID' => $botId, // Идентификатор бота владельца приложения для чата
         'CODE' => 'validator', // Код приложения для чата
         'IFRAME' => 'https://bitrix24.iss-reshetnev.ru/bots/validatorbot/validatorframe.php',
         'IFRAME_WIDTH' => '600', // Желаемая ширина фрейма. Минимальное значение - 250px
         'IFRAME_HEIGHT' => '600', // Желаемая высота фрейма. Минимальное значение - 50px
         'HASH' => 'd1ab17949a572b0979d8db0d5b349cd2', // Токен для доступа к вашему фрейму для проверки подписи, 32 символа.
         'ICON_FILE' => 'iVBORw0KGgoAAAANSUhEUgAAADoAAAA6CAYAAADhu0ooAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89', // Иконка в base64
         'CONTEXT' => 'BOT', // Контекст
         'HIDDEN' => 'Y', // Скрытое приложение или нет
         'EXTRANET_SUPPORT' => 'N', // Доступна ли команда пользователям экстранет, по умолчанию N
         'LIVECHAT_SUPPORT' => 'N', // Поддержка онлайн-чата
         'IFRAME_POPUP' => 'Y', // iframe будет открыт с возможностью перемещения внутри мессенджера, переход между диалогами не будет закрывать такое окно.
         'LANG' => array( // Массив переводов, желательно указывать как минимум для RU и EN
             array('LANGUAGE_ID' => 'en', 'TITLE' => 'Validator', 'DESCRIPTION' => 'Open Validator', 'COPYRIGHT' => 'Bitrix24'),
             array('LANGUAGE_ID' => 'ru', 'TITLE' => 'Валидатор', 'DESCRIPTION' => 'Открыть Валидатор', 'COPYRIGHT' => 'Bitrix24'),
         ),
    ), $_REQUEST["auth"]);

    $result = restCommand('imbot.app.update', array(

        'APP_ID' => 4,
        'FIELDS' => array(
             'LANG' => array(
			 	          array('LANGUAGE_ID' => 'en', 'TITLE' => 'Validator', 'DESCRIPTION' => 'Open Validator', 'COPYRIGHT' => 'Bitrix24'),
			 	          array('LANGUAGE_ID' => 'ru', 'TITLE' => 'Валидатор', 'DESCRIPTION' => 'Открыть Валидатор', 'COPYRIGHT' => 'Bitrix24'),
			       ),
			       'IFRAME' => 'https://bitrix24.iss-reshetnev.ru/bots/validatorbot/validatorframe.php'
        ),
   ), $_REQUEST["auth"]);
}

function saveParams($params)
{
    $config = "<?php\n";
    $config .= "\$appsConfig = " . var_export($params, true) . ";\n";
    $config .= "?>";
    $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';
    file_put_contents(__DIR__ . $configFileName, $config);
    return true;
}

function restCommand($method, array $params = array(), array $auth = array())
{
    $queryUrl = 'https://' . $auth['domain'] . '/rest/' . $method;
    $queryData = http_build_query(array_merge($params, array('auth' => $auth['access_token'])));
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    return $result;
}

function writeToLog($data, $title = '')
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents(__DIR__ . '/iframe.log', $log, FILE_APPEND);
    return true;
}
function welcom_menu($user, $bot_id = 17, $message_id = 0, $app_id = 4)
{
    $arKeyboard = array();
    $arKeyboard[] = array(
        "TEXT" => "Начать опрос",
        "BLOCK" => "Y",
        "APP_ID" => $app_id,
        "BG_COLOR" => "#D7FAF9",
        "TEXT_COLOR" => "#000000",
    );

    $message = "[B]Уважаемый коллега! Мы очень рады, что Вы становитесь частью большого коллектива АО «РЕШЕТНЁВ»![/B][BR]Предлагаем Вам ответить на несколько вопросов анкеты. Это поможет нам улучшить обстановку в коллективе, сделать её комфортнее и благоприятнее. Ваше мнение очень важно для нас!";

    $result = restCommand('imbot.message.add', array(
        "DIALOG_ID" => $_REQUEST['data']['PARAMS']['DIALOG_ID'],
        'MESSAGE' => $message, // Тест сообщения
        'ATTACH' => '', // Вложение, необязательное поле
        "KEYBOARD" => $arKeyboard, // Клавиатура, необязательное поле
    ), $_REQUEST["auth"]);
}

function main_menu($user, $bot_id = 17, $message_id = 0, $app_id = 4)
{
    $arKeyboard = array();
    $arKeyboard[] = array(
        "TEXT" => "Начать опрос",
        "BLOCK" => "Y",
        "APP_ID" => $app_id,
        "BG_COLOR" => "#D7FAF9",
        "TEXT_COLOR" => "#000000",
    );

    $message = "[B]Уважаемый коллега! Мы очень рады, что Вы становитесь частью большого коллектива АО «РЕШЕТНЁВ»![/B][BR]Предлагаем Вам ответить на несколько вопросов анкеты. Это поможет нам улучшить обстановку в коллективе, сделать её комфортнее и благоприятнее. Ваше мнение очень важно для нас!";

    $result = restCommand('imbot.message.add', array(
        "DIALOG_ID" => $_REQUEST['data']['PARAMS']['DIALOG_ID'],
        "MESSAGE" => $message,
        "KEYBOARD" => $arKeyboard,
    ), $_REQUEST["auth"]);
    return $result;
}

 

function back($user, $bot_id, $message_id, $params)
{
    include 'db.php';
    switch ($params) {
        default:
            //главное меню
            $arResult = main_menu($user, $bot_id, $message_id);
            $arResult1 = welcom_menu($user, $bot_id, $message_id);
            break;
    }
}
