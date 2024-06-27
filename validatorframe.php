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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8" />
  <style>
    .question { display: none; }
    .question.active { display: block;}
    .btn-new {
        margin: 5px 5px 5px 5px;
        text-align: center;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        color: white;
        background: #0B63F6;
        box-shadow: 0 5px 0 #003CC5;
    }

    .btn-new:hover {
        background: #003CC5;
        box-shadow: none;
        position: relative;
        top: 5px;
    }
  </style>
</head>
<body>
  <div id='survey'>
    <div id="question1" class="question active">
      <p><b>Вопрос 1: Получаете ли Вы какие-либо навыки или знания в данный момент?</b></p>
      <button class="btn-new" onclick="nextQuestion('question1', 'question2')">Да, это непрерывный процесс.</button>
      <button class="btn-new" onclick="nextQuestion('question1', 'question2')">Нет, делаю это по необходимости.</button>
      <button class="btn-new" onclick="nextQuestion('question1', 'question2')">Нет, я обладаю всеми необходимыми навыками.</button>
    </div>
    <div id="question2" class="question">
      <p><b>Вопрос 2: Есть ли у Вас профессиональные достижения, значимые для Вас?</b></p>
      <button class="btn-new" onclick="nextQuestion('question2', 'question3')">Да, в течение последнего года.</button>
      <button class="btn-new" onclick="nextQuestion('question2', 'question3')">Да, это было несколько лет назад.</button>
      <button class="btn-new" onclick="nextQuestion('question2', 'question3')">Личных нет, но я горжусь тем, что участвую в достижении общего результата.</button>
    </div>
    <div id="question3" class="question">
      <p><b>Вопрос 3: Закончите фразу: «Конструктивная критика Вашей работы…»</b></p>
      <button class="btn-new" onclick="nextQuestion('question3', 'question4')">Может снизить мотивацию.</button>
      <button class="btn-new" onclick="nextQuestion('question3', 'question4')">Позволяет сделать выводы и извлечь пользу.</button>
      <button class="btn-new" onclick="nextQuestion('question3', 'question4')">Остаётся для меня незамеченной и никак не отражается на моей работе.</button>
    </div>
    <div id="question4" class="question">
      <p><b>Вопрос 4: Как Вы реагируете на неожиданные изменения в работе?</b></p>
      <button class="btn-new" onclick="nextQuestion('question4', 'question5')">Я подстраиваюсь под ситуацию, перемены не вызывают у меня проблем.</button>
      <button class="btn-new" onclick="nextQuestion('question4', 'question5')">Я подстраиваюсь под ситуацию, но мне нужно время, чтобы адаптироваться и выстроить свою работу по-другому.</button>
      <button class="btn-new" onclick="nextQuestion('question4', 'question5')">Я выполняю эту работу, но считаю это неправильным. Работа должна быть плановой.</button>
    </div>
    <div id="question5" class="question">
      <p><b>Вопрос 5: Имели ли Вы опыт наставничества или обмена опытом с коллегами?</b></p>
      <button class="btn-new" onclick="nextQuestion('question5', 'question6')">Да, мы регулярно обменивались опытом с коллегами.</button>
      <button class="btn-new" onclick="nextQuestion('question5', 'question6')">Да, это происходило при необходимости выполнить какую-либо новую задачу.</button>
      <button class="btn-new" onclick="nextQuestion('question5', 'question6')">Нет, предпочитаю работать самостоятельно.</button>
    </div>
    <div id="question6" class="question">
      <p><b>Вопрос 6: Чувствуете ли Вы свою ответственность за достижение коллективного результата?</b></p>
      <button class="btn-new" onclick="nextQuestion('question6', 'question7')">Да, чувствую.</button>
      <button class="btn-new" onclick="nextQuestion('question6', 'question7')">Да, но с пониманием того, что у каждого своя зона ответственности. Кто-то сработал хуже, кто-то лучше.</button>
      <button class="btn-new" onclick="nextQuestion('question6', 'question7')">Каждый несёт ответственность за свою часть работы.</button>
    </div>
    <div id="question7" class="question">
      <p><b>Вопрос 7: Как Вы относитесь к  временным неудачам, возникшим при достижении целей?</b></p>
      <button class="btn-new" onclick="nextQuestion('question7', 'question8')">Отношусь к неудачам достаточно легко, не придаю им значения.</button>
      <button class="btn-new" onclick="nextQuestion('question7', 'question8')">Считаю, что это возможность получить новый опыт.</button>
      <button class="btn-new" onclick="nextQuestion('question7', 'question8')">Я переживаю по этому поводу. Мне требуется поддержка со стороны коллег.</button>
    </div>
    <div id="question8" class="question">
      <p><b>Вопрос 8: Что Вы можете сказать о своей работе в команде?</b></p>
      <button class="btn-new" onclick="nextQuestion('question8', 'question9')">Мне нравится работать в команде, при этом могу решать какие-то задачи самостоятельно.</button>
      <button class="btn-new" onclick="nextQuestion('question8', 'question9')">Предпочитаю работать один, но для решения каких-то задач готов работать в команде.</button>
      <button class="btn-new" onclick="nextQuestion('question8', 'question9')">Для меня это непринципиально.</button>
    </div>
    <div id="question9" class="question">
      <p><b>Вопрос 9: Как Вы относитесь к своей ответственности за достижение целей?</b></p>
      <button class="btn-new" onclick="nextQuestion('question9', 'question10')">Только от меня зависит, достигну я своей цели или нет.</button>
      <button class="btn-new" onclick="nextQuestion('question9', 'question10')">Делаю всё, что могу, но не всё зависит только от меня.</button>
      <button class="btn-new" onclick="nextQuestion('question9', 'question10')">От меня мало что зависит.</button>
    </div>
    <div id="question10" class="question">
      <p><b>Вопрос 10: Какие действия Вы могли бы предпринять для достижения результата?</b></p>
      <button class="btn-new" onclick="nextQuestion('question10', 'question11')">Я просто делаю свою работу, это и так приводит к достижению результата.</button>
      <button class="btn-new" onclick="nextQuestion('question10', 'question11')">Если необходимо, беру инициативу в свои руки, даже если меня об этом не просят.</button>
      <button class="btn-new" onclick="nextQuestion('question10', 'question11')">Если говорят, что нужно приложить больше усилий, я, как правило, не отказываюсь.</button>
    </div>
    <div id="question11" class="question">
      <p><b>Спасибо за участие в опросе!</b></p>
      <a href="#close" class="btn-new" onclick="frameCommunicationSend({'action': 'close'})">Закрыть окно</a>
    </div>
  </div>
	<script type="text/javascript">
    function nextQuestion(currentId, nextId) {
        var currentQuestion = document.getElementById(currentId);
        var nextQuestion = document.getElementById(nextId);

        if (currentQuestion && nextQuestion) {
          currentQuestion.classList.remove('active');
          nextQuestion.classList.add('active');
        }
    }

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
