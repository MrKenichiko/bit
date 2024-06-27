<?
/*
$_GET
(
    [BOT_ID] => 17
    [BOT_CODE] => echoBot
    [APP_ID] => 11
    [APP_CODE] => echoFrame
    [DOMAIN] => https://test.bitrix24.ru
    [DOMAIN_HASH] => d1ab17949a572b0979d8db0d5b349cd2
    [USER_ID] => 2
    [USER_HASH] => 7e23ac8b6f6c7044076301c7f81cd745
    [DIALOG_ID] => 950
    [CONTEXT] => textarea
    [LANG] => ru
    [IS_CHROME] => Y
    [MESSAGE_ID] => 12333
    [BUTTON_PARAMS] => test

)
 */

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

securityCheck($_GET);

//writeToLog(json_encode($_GET));
?>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=IFRAME_WIDTH, height=IFRAME_HEIGHT initial-scale=1.0">
	<meta charset="utf-8" />
  <title>Опрос сотрудников</title>
</head>
<body style="height: 100%;margin: 0;padding: 0; background: #fff">
  <h3>Заголовок</h3>
    <p>Первый абзац.</p>
    <p>Второй абзац.</p>
	<a href="#send" onclick="frameCommunicationSend({'action': 'send', 'message': 'Send message'})">Send message</a><br><br>
	<a href="#put" onclick="frameCommunicationSend({'action': 'put', 'message': 'Put message'})">Put message</a><br><br>
	<a href="#call" onclick="frameCommunicationSend({'action': 'call', 'number': '123456'})">Call to number</a><br><br>
	<a href="#support" onclick="frameCommunicationSend({'action': 'support', 'code': '6a4cdbcf753addac1a573ea64be826ca'})">Open support bot</a><br><br>
	<a href="#close" onclick="frameCommunicationSend({'action': 'close'})">Close this window</a>

	<script type="text/javascript">
		function frameCommunicationInit()
		{
			if (!window.frameCommunication)
			{
				window.frameCommunication = {timeout: {}};
			}
			if(typeof window.postMessage === 'function')
			{
				window.addEventListener('message', function(event){
					var data = {};
					try { data = JSON.parse(event.data); } catch (err){}

					if (data.action == 'init')
					{
						frameCommunication.uniqueLoadId = data.uniqueLoadId;
						frameCommunication.postMessageSource = event.source;
						frameCommunication.postMessageOrigin = event.origin;
					}
				});
			}
		}
		function frameCommunicationSend(data)
		{
			data['uniqueLoadId'] = frameCommunication.uniqueLoadId;
			var encodedData = JSON.stringify(data);
			if (!frameCommunication.postMessageOrigin)
			{
				clearTimeout(frameCommunication.timeout[encodedData]);
				frameCommunication.timeout[encodedData] = setTimeout(function(){
					frameCommunicationSend(data);
				}, 10);
				return true;
			}

			if(typeof window.postMessage === 'function')
			{
				if(frameCommunication.postMessageSource)
				{
					frameCommunication.postMessageSource.postMessage(
						encodedData,
						frameCommunication.postMessageOrigin
					);
				}
			}
		}
		frameCommunicationInit();
	</script>


</body>
</html>

<?
function securityCheck($params)
{
	// this hash you setted in register rest command
	$appHash = 'd1ab17949a572b0979d8db0d5b349cd2';

	$check = parse_url($params['DOMAIN']);
	if (!in_array($check['scheme'], Array('http', 'https')) || empty($check['host']))
	{
		die("BC_IFRAME_ERROR_ADDRESS");
	}
	$params['DOMAIN'] = $check['scheme'].'://'.$check['host'];
	$params['SERVER_NAME'] = $check['host'];

	if (strpos($_SERVER['HTTP_REFERER'], $params['DOMAIN']) !== 0)
	{
		die("BC_IFRAME_ERROR_SECURITY");
	}

	// get from config
	if ($appHash)
	{
		if ($params['DOMAIN_HASH'] != md5($params['SERVER_NAME'].$appHash))
		{
			die("BC_IFRAME_ERROR_AUTH");
		}
	}
	else
	{
		die("BC_IFRAME_ERROR_AUTH_2");
	}

	return $params;
}
