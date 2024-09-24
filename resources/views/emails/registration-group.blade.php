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
        <p>Привет, {{ $name }}!</p>
        <p>Поздравляем с успешной регистрацией твоей команды в дисциплине {{ $game->title }} на <a href="{{ url('/') }}">сайте</a> МТС Cyber Cup!</p>
        <table>
            <tr>
                <th>Имя</th>
                <td>{{ $name }}</td>
            </tr>
            <tr>
                <th>Фамилия</th>
                <td>{{ $surname }}</td>
            </tr>
            <tr>
                <th>Отчество</th>
                <td>{{ $patronymic }}</td>
            </tr>
            <tr>
                <th>Discord</th>
                <td>{{ $discord }}</td>
            </tr>
            <tr>
                <th>Telegram</th>
                <td>{{ $telegram }}</td>
            </tr>
            <tr>
                <th>Дата рождения</th>
                <td>{{ $birth_date }}</td>
            </tr>
            <tr>
                <th>Компания</th>
                <td>{{ $company }}</td>
            </tr>
            <tr>
                <th>Город</th>
                <td>{{ $city }}</td>
            </tr>
            <tr>
                <th>Никнейм</th>
                <td>{{ $nickname }}</td>
            </tr>
            <tr>
                <th>Уровень игры </th>
                <td>{{ $rank }}</td>
            </tr>
            <tr>
                <th>Название команды</th>
                <td>{{ $team_name }}</td>
            </tr>
            <tr>
                <th>Как долго играете </th>
                <td>{{ $team_experience }}</td>
            </tr>
            <tr>
                <th>Используемое устройство </th>
                <td>{{ $device }}</td>
            </tr>
            <tr>
                <th>Удобное время </th>
                <td>{{ $match_times }}</td>
            </tr>
            <tr>
                <th>Интернет-соединение</th>
                <td>{{ $internet_connection }}</td>
            </tr>
            <tr>
                <th>Пожелания и требования</th>
                <td>{{ $special_requirements }}</td>
            </tr>
        </table>
        @if (!empty($participants))
            @foreach ($participants as $index => $participant)
                <h3>Игрок {{ $index + 1 }}</h3>
                <table>
                    <tr>
                        <th>ФИО</th>
                        <td>{{ $participant['fio'] }}</td>
                    </tr>
                    <tr>
                        <th>Дата рождения</th>
                        <td>{{ $participant['birth_date'] }}</td>
                    </tr>
                    <tr>
                        <th>Город</th>
                        <td>{{ $participant['city'] }}</td>
                    </tr>
                    <tr>
                        <th>Корпоративная почта</th>
                        <td>{{ $participant['email'] }}</td>
                    </tr>
                    <tr>
                        <th>Telegram</th>
                        <td>{{ $participant['telegram'] }}</td>
                    </tr>
                    <tr>
                        <th>Discord</th>
                        <td>{{ $participant['discord'] }}</td>
                    </tr>
                    <tr>
                        <th>Никнейм</th>
                        <td>{{ $participant['nickname'] }}</td>
                    </tr>
                </table>
            @endforeach
        @else
            <p>Участники не указаны или отсутствуют.</p>
        @endif
        <div class="footer">
            <p><a href="https://moskva.mts.ru/about/investoram-i-akcioneram/korporativnoe-upravlenie/dokumenti-pao-mts/politika-obrabotka-personalnih-dannih-v-pao-mts">Условия обработки персональных данных</a> <span class="red">*</span></p>
            <p><a href="{{ secure_asset('assets/doc/The rules of the MTC CYBER CUP tournament.pdf') }}">Регламент турнира</a><span class="red">*</span></p>
        </div>
    </div>
</body>
</html>
