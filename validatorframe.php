<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
/*var_dump($_REQUEST);
exit;*/

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

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8" />
  <style>
    .answerh2 {
      margin-left: 5px;
    }
    h1,h2,h3,p {
      display: inline-block;
      text-shadow:
        1px 1px 1px white,
        1px -1px 1px white,
        -1px 1px 1px white,
        -1px -1px 1px white;
      color: #black;
      transition: all 1s;
    }

    h1,h2,h3,p:after {
      content: "";
      display: block;
      position: relative;
      z-index: -1;
      width: 100%;
      margin: auto;
      border-bottom: 3px solid #black;
      bottom: .15em;
      transition: all 1s;
    }
    .question {
      display: none;
    }
    .question.active { display: block;}
    .btn-new {
      width: 225px;
      background-color: #D7FAF9;
      color: #000000;
      font: 13px/20px var(--ui-font-family-primary,var(--ui-font-family-helvetica));
      padding: 4px 10px;
      display: inline-block;
      text-decoration: none;
      border: none;
      text-align: center;
      min-width: 24px;
      cursor: pointer;
      margin-bottom: 5px;
      transition: opacity .5s;
      opacity: 1;
      box-shadow: none;
    }
    }
    .rating {
      max-width: 33rem;
      background: #fff;
      margin: 0 1rem;
      padding: 1rem;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
      width: 100%;
      border-radius: 0.5rem;
    }

    .star {
      font-size: 10vh;
      cursor: pointer;
    }

    .one {
      color: rgb(255, 0, 0);
    }

    .two {
      color: rgb(255, 106, 0);
    }

    .three {
      color: rgb(251, 255, 120);
    }

    .four {
      color: rgb(255, 255, 0);
    }

    .five {
      color: rgb(24, 159, 14);
    }
  </style>
</head>
<body>
  <div id='survey'>
    <div id="question1" class="question active">
      <p><b>Вопрос 1: Получаете ли Вы какие-либо навыки или знания в данный момент?</b></p>
      <button class="btn-new" onclick="nextQuestion('question1', 'question2', 'Да, это непрерывный процесс.')">Да, это непрерывный процесс.</button>
      <button class="btn-new" onclick="nextQuestion('question1', 'question2', 'Нет, делаю это по необходимости.')">Нет, делаю это по необходимости.</button>
      <button class="btn-new" onclick="nextQuestion('question1', 'question2', 'Нет, я обладаю всеми необходимыми навыками.')">Нет, я обладаю всеми необходимыми навыками.</button>
    </div>
    <div id="question2" class="question">
      <p><b>Вопрос 2: Есть ли у Вас профессиональные достижения, значимые для Вас?</b></p>
      <button class="btn-new" onclick="nextQuestion('question2', 'question3', 'Да, в течение последнего года.')">Да, в течение последнего года.</button>
      <button class="btn-new" onclick="nextQuestion('question2', 'question3', 'Да, это было несколько лет назад.')">Да, это было несколько лет назад.</button>
      <button class="btn-new" onclick="nextQuestion('question2', 'question3', 'Личных нет, но я горжусь тем, что участвую в достижении общего результата.')">Личных нет, но я горжусь тем, что участвую в достижении общего результата.</button>
    </div>
    <div id="question3" class="question">
      <p><b>Вопрос 3: Закончите фразу: «Конструктивная критика Вашей работы…»</b></p>
      <button class="btn-new" onclick="nextQuestion('question3', 'question4', 'Может снизить мотивацию.')">Может снизить мотивацию.</button>
      <button class="btn-new" onclick="nextQuestion('question3', 'question4', 'Позволяет сделать выводы и извлечь пользу.')">Позволяет сделать выводы и извлечь пользу.</button>
      <button class="btn-new" onclick="nextQuestion('question3', 'question4', 'Остаётся для меня незамеченной и никак не отражается на моей работе.')">Остаётся для меня незамеченной и никак не отражается на моей работе.</button>
    </div>
    <div id="question4" class="question">
      <p><b>Вопрос 4: Как Вы реагируете на неожиданные изменения в работе?</b></p>
      <button class="btn-new" onclick="nextQuestion('question4', 'question5', 'Я подстраиваюсь под ситуацию, перемены не вызывают у меня проблем.')">Я подстраиваюсь под ситуацию, перемены не вызывают у меня проблем.</button>
      <button class="btn-new" onclick="nextQuestion('question4', 'question5', 'Я подстраиваюсь под ситуацию, но мне нужно время, чтобы адаптироваться и выстроить свою работу по-другому.')">Я подстраиваюсь под ситуацию, но мне нужно время, чтобы адаптироваться и выстроить свою работу по-другому.</button>
      <button class="btn-new" onclick="nextQuestion('question4', 'question5', 'Я выполняю эту работу, но считаю это неправильным. Работа должна быть плановой.')">Я выполняю эту работу, но считаю это неправильным. Работа должна быть плановой.</button>
    </div>
    <div id="question5" class="question">
      <p><b>Вопрос 5: Имели ли Вы опыт наставничества или обмена опытом с коллегами?</b></p>
      <button class="btn-new" onclick="nextQuestion('question5', 'question6', 'Да, мы регулярно обменивались опытом с коллегами.')">Да, мы регулярно обменивались опытом с коллегами.</button>
      <button class="btn-new" onclick="nextQuestion('question5', 'question6', 'Да, это происходило при необходимости выполнить какую-либо новую задачу.')">Да, это происходило при необходимости выполнить какую-либо новую задачу.</button>
      <button class="btn-new" onclick="nextQuestion('question5', 'question6', 'Нет, предпочитаю работать самостоятельно.')">Нет, предпочитаю работать самостоятельно.</button>
    </div>
    <div id="question6" class="question">
      <p><b>Вопрос 6: Чувствуете ли Вы свою ответственность за достижение коллективного результата?</b></p>
      <button class="btn-new" onclick="nextQuestion('question6', 'question7', 'Да, чувствую.')">Да, чувствую.</button>
      <button class="btn-new" onclick="nextQuestion('question6', 'question7', 'Да, но с пониманием того, что у каждого своя зона ответственности. Кто-то сработал хуже, кто-то лучше.')">Да, но с пониманием того, что у каждого своя зона ответственности. Кто-то сработал хуже, кто-то лучше.</button>
      <button class="btn-new" onclick="nextQuestion('question6', 'question7', 'Каждый несёт ответственность за свою часть работы.')">Каждый несёт ответственность за свою часть работы.</button>
    </div>
    <div id="question7" class="question">
      <p><b>Вопрос 7: Как Вы относитесь к временным неудачам, возникшим при достижении целей?</b></p>
      <button class="btn-new" onclick="nextQuestion('question7', 'question8', 'Отношусь к неудачам достаточно легко, не придаю им значения.')">Отношусь к неудачам достаточно легко, не придаю им значения.</button>
      <button class="btn-new" onclick="nextQuestion('question7', 'question8', 'Считаю, что это возможность получить новый опыт.')">Считаю, что это возможность получить новый опыт.</button>
      <button class="btn-new" onclick="nextQuestion('question7', 'question8', 'Я переживаю по этому поводу. Мне требуется поддержка со стороны коллег.')">Я переживаю по этому поводу. Мне требуется поддержка со стороны коллег.</button>
    </div>
    <div id="question8" class="question">
      <p><b>Вопрос 8: Что Вы можете сказать о своей работе в команде?</b></p>
      <button class="btn-new" onclick="nextQuestion('question8', 'question9', 'Мне нравится работать в команде, при этом могу решать какие-то задачи самостоятельно.')">Мне нравится работать в команде, при этом могу решать какие-то задачи самостоятельно.</button>
      <button class="btn-new" onclick="nextQuestion('question8', 'question9', 'Предпочитаю работать один, но для решения каких-то задач готов работать в команде.')">Предпочитаю работать один, но для решения каких-то задач готов работать в команде.</button>
      <button class="btn-new" onclick="nextQuestion('question8', 'question9', 'Для меня это непринципиально.')">Для меня это непринципиально.</button>
    </div>
    <div id="question9" class="question">
      <p><b>Вопрос 9: Как Вы относитесь к своей ответственности за достижение целей?</b></p>
      <button class="btn-new" onclick="nextQuestion('question9', 'question10', 'Только от меня зависит, достигну я своей цели или нет.')">Только от меня зависит, достигну я своей цели или нет.</button>
      <button class="btn-new" onclick="nextQuestion('question9', 'question10', 'От того, как я буду выстраивать свою работу, зависит, достигну я цели или нет.')">От того, как я буду выстраивать свою работу, зависит, достигну я цели или нет.</button>
      <button class="btn-new" onclick="nextQuestion('question9', 'question10', 'Всё зависит от стечения обстоятельств.')">Всё зависит от стечения обстоятельств.</button>
    </div>
    <div id="question10" class="question">
      <p><b>Вопрос 10: Можете ли Вы самостоятельно принять решение в стрессовой ситуации?</b></p>
      <button class="btn-new" onclick="nextQuestion('question10', 'end', 'Да, могу.')">Да, могу.</button>
      <button class="btn-new" onclick="nextQuestion('question10', 'end', 'Могу, но потом очень долго переживаю.')">Могу, но потом очень долго переживаю.</button>
      <button class="btn-new" onclick="nextQuestion('question10', 'end', 'Нет, мне нужно посоветоваться.')">Нет, мне нужно посоветоваться.</button>
    </div>
    <div id="end" class="question">
      <p>Спасибо за прохождение опроса!</p>
      <a href="#close" class="btn-new" onclick="sendAnswers()">Завершить опрос</a>
      <button class="btn-new" onclick="nextQuestion('end', 'surveyResult', 'NULL')">Посмотреть ответы</button>
    </div>
    <div id="surveyResult" class="question">
      <h2 class="answerh2"><b>Ответы:</b></h2>
      <div id="answers">
      </div>
      <a href="#close" class="btn-new" onclick="sendAnswers()">Завершить опрос</a>
      <a href="#close" class="btn-new" onclick="nextQuestion('surveyResult', 'rating', 'NULL')">Оценить</a>
    </div>
    <div id="rating" class="question">
      <span onclick="gfg(1)"
            class="star">★
      </span>
      <span onclick="gfg(2)"
            class="star">★
      </span>
      <span onclick="gfg(3)"
            class="star">★
      </span>
      <span onclick="gfg(4)"
            class="star">★
      </span>
      <span onclick="gfg(5)"
            class="star">★
      </span>
      <h3 id="output">
            Рейтинг: 0/5
      </h3>
      <a href="#close" class="btn-new" onclick="sendAnswers()">Завершить опрос</a>
    </div>
  </div>
	<script type="text/javascript">
  let userAnswers = [];
  let stars =
    document.getElementsByClassName("star");
  let output =
    document.getElementById("output");

    function gfg(n) {
      remove();
      for (let i = 0; i < n; i++) {
          if (n == 1) cls = "one";
          else if (n == 2) cls = "two";
          else if (n == 3) cls = "three";
          else if (n == 4) cls = "four";
          else if (n == 5) cls = "five";
          stars[i].className = "star " + cls;
      }
      output.innerText = "Рейтинг: " + n + "/5";
    }

    function remove() {
      let i = 0;
      while (i < 5) {
          stars[i].className = "star";
          i++;
      }
    }
    var surveyData = {};
    function nextQuestion(currentId, nextId, answer) {
        if(answer != 'NULL') {
          userAnswers.push(answer);
        }
        //userAnswers.push(answer);
        surveyData[currentId] = answer;
        var currentQuestion = document.getElementById(currentId);
        var nextQuestion = document.getElementById(nextId);

        if (currentQuestion && nextQuestion) {
          currentQuestion.classList.remove('active');
          nextQuestion.classList.add('active');
        }

        if (currentId === 'question1') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question2') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question3') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question4') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question5') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question6') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question7') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question8') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question9') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
        if (currentId === 'question10') {
          var answerDiv = document.getElementById('answers');
          var questionText = currentQuestion.querySelector('p').innerText;
          answerDiv.innerHTML += '<p><b>' + questionText + '</b><br>' + answer + '</p>';
        }
    }

    function sendAnswers()
    {
      const url = "./index.php";
      const data = {
        'answers': userAnswers,
        'dialog_id': <?php echo $_REQUEST['USER_ID'];?>
      };

      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok' + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        console.log('Answers sent to server:', data);
      })
      .catch(error => {
        console.error('Error sending answers:',error);
      });

      frameCommunicationSend({'action': 'close'});
      //const xhr = new XMLHttpRequest();
      //xhr.open("POST", "index.php", true);
      //xhr.setRequestHeader("Content-Type", "application/json");
      //const data = {
      //  dialogId: 'DIALOG_ID',
      //  answers: userAnswers,
      //  userId: 'USER_ID',
      //};
      //
      //xhr.onreadystatechange = function () {
      //  if (xhr.readyState === 4 && xhr.status === 200) {
      //    console.log('Answers sent to server:', xhr.responseText);
      //  } else {
      //    console.error('Error sending answers:', xhr.statusText);
      //  }
      //};
      //xhr.send(JSON.stringify(data));
      //
      //frameCommunicationSend({'action': 'close'})
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
