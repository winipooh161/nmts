<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        } .red {
            color:red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Привет {{$name}}</h1>
        <p>Чтобы сбросить пароль на сайте МТС Cyber Cup, пожалуйста, перейди по следующей ссылке: <br>   <a href="{{ $resetLink }}">{{ $resetLink }}</a></p>
     
        <p>Если запрос был не от тебя, проигнорируй это сообщение или напиши в поддержку на эту почту  <a href="mailto:info@mtscybercup.ru"></a>  info@mtscybercup.ru.</p>
        <div class="footer">
            <p><a
                    href="https://moskva.mts.ru/about/investoram-i-akcioneram/korporativnoe-upravlenie/dokumenti-pao-mts/politika-obrabotka-personalnih-dannih-v-pao-mts">Условия
                    обработки персональных данных</a> <span class="red">*</span></p>
            <p><a href="{{ secure_asset('assets/doc/The rules of the MTC CYBER CUP tournament.pdf') }}">Регламент
                    проведения турнира</a><span class="red">*</span></p>
        </div>
    </div>
</body>
</html>
