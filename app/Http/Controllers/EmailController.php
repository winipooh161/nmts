<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SoloRegistration;
use App\Models\TeamRegistration; // Импортируем модель TeamRegistration
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Функция для отправки писем зарегистрированным пользователям в указанном диапазоне ID.
     * Теперь поддерживает GET-запросы.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmails(Request $request)
    {
        // Получаем параметры start_id и end_id из запроса
        $startId = $request->query('start_id', 1); // По умолчанию 1
        $endId = $request->query('end_id', 500);   // По умолчанию 500

        // Получаем пользователей в указанном диапазоне ID
        $users = User::whereBetween('id', [$startId, $endId])->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'Нет пользователей в указанном диапазоне.'], 404);
        }

        // Проходим по каждому пользователю и отправляем письмо
        foreach ($users as $user) {
            $this->sendEmailToUser($user);
        }

        return response()->json(['message' => 'Письма успешно разосланы пользователям в диапазоне ID от ' . $startId . ' до ' . $endId . '.']);
    }

    /**
     * Отправка письма пользователю.
     *
     * @param User $user
     * @return void
     */
    private function sendEmailToUser(User $user)
    {
        // Генерируем временный пароль
        $password = Str::random(8); // Генерация случайного пароля длиной 8 символов
    
        // Сохраняем новый пароль в зашифрованном виде
        $user->password = bcrypt($password);
        $user->save();
    
        // Данные для отправки письма
        $data = [
            'name' => $user->name,
            'surname' => $user->surname,
            'patronymic' => $user->patronymic,
            'email' => $user->email,
            'telegram' => $user->telegram,
            'password' => $password,  // Отправляем временный пароль
            'phone' => $user->phone,
            'city' => $user->city,
            'company' => $user->company,
            'avatar' => $user->avatar,
        ];
    
        // Отправляем письмо с использованием Mail фасада
        Mail::send('emails.registration', $data, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Регистрация аккаунта')
                    ->from('mtstest@hench.ru', 'MTS Cyber Cup');
        });
    }

    /**
     * Функция для отправки писем всем пользователям, зарегистрированным в таблице solo_registrations.
     * Теперь поддерживает GET-запросы.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmailsToAllSoloRegistrations(Request $request)
    {
        // Получаем всех пользователей из таблицы solo_registrations
        $registrations = SoloRegistration::all();

        if ($registrations->isEmpty()) {
            return response()->json(['message' => 'Нет пользователей в таблице solo_registrations.'], 404);
        }

        // Проходим по каждому пользователю и отправляем письмо
        foreach ($registrations as $registration) {
            $this->sendEmailToRegistration($registration);
        }

        return response()->json(['message' => 'Письма успешно разосланы всем пользователям.']);
    }

    /**
     * Отправка письма пользователю из таблицы solo_registrations.
     *
     * @param SoloRegistration $registration
     * @return void
     */
    private function sendEmailToRegistration(SoloRegistration $registration)
    {
        // Предположим, что в таблице solo_registrations есть ссылка на игру через поле game_id
        $game = $registration->game; // Или получаем игру через другую логику
    
        // Данные для отправки письма
        $data = [
            'name' => $registration->name,
            'surname' => $registration->surname,
            'patronymic' => $registration->patronymic,
            'discord' => $registration->discord,
            'telegram' => $registration->telegram,
            'birth_date' => $registration->birth_date,
            'nickname' => $registration->nickname,
            'rank' => $registration->rank,
            'time_game' => $registration->time_game,
            'device' => $registration->device,
            'match_times' => $registration->match_times,
            'internet_connection' => $registration->internet_connection,
            'special_requirements' => $registration->special_requirements,
            'city' => $registration->city,
            'company' => $registration->company,
            'game' => $game // Передаем объект игры в шаблон
        ];
    
        // Отправка письма с использованием Mail фасада
        Mail::send('emails.solo_registration', $data, function ($message) use ($registration) {
            $message->to($registration->email)
                    ->subject('Регистрация в дисциплине MTS Cyber Cup')
                    ->from('mtstest@hench.ru', 'MTS Cyber Cup');
        });
    }

    /**
     * Функция для отправки писем всем пользователям, зарегистрированным в таблице registration-groups.
     * Теперь поддерживает GET-запросы.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmailsToAllTeamRegistrations(Request $request)
    {
        // Получаем все команды из таблицы registration-groups
        $registrations = TeamRegistration::all();

        if ($registrations->isEmpty()) {
            return response()->json(['message' => 'Нет команд в таблице registration-groups.'], 404);
        }

        // Проходим по каждой регистрации и отправляем письмо
        foreach ($registrations as $registration) {
            $this->sendEmailToTeamRegistration($registration);
        }

        return response()->json(['message' => 'Письма успешно разосланы всем зарегистрированным командам.']);
    }

    /**
     * Отправка письма пользователю из таблицы registration-groups.
     *
     * @param TeamRegistration $registration
     * @return void
     */
    private function sendEmailToTeamRegistration(TeamRegistration $registration)
    {
        // Предположим, что в таблице registration-groups есть связь с игрой через поле game_id
        $game = $registration->game; // Или получаем игру через другую логику
        
        // Данные для отправки письма
        $data = [
            'name' => $registration->name,
            'surname' => $registration->surname,
            'patronymic' => $registration->patronymic,
            'nickname' => $registration->nickname,
            'team_name' => $registration->team_name,
            'participants' => json_decode($registration->participants, true),
            'game' => $game,
            'city' => $registration->city,
            'company' => $registration->company,
            'discord' => $registration->discord,
            'birth_date' => $registration->birth_date,
            'telegram' => $registration->telegram,
            'rank' => $registration->rank,
            'team_experience' => $registration->team_experience,
            'device' => $registration->device,
            'match_times' => $registration->match_times,
            'internet_connection' => $registration->internet_connection,
            'special_requirements' => $registration->special_requirements,
        ];

        // Отправляем письмо с использованием Mail фасада
        Mail::send('emails.registration-group', $data, function ($message) use ($registration) {
            $message->to($registration->email)
                    ->subject('Регистрация команды MTS Cyber Cup')
                    ->from('mtstest@hench.ru', 'MTS Cyber Cup');
        });
    }

    public function updateParticipantsEncoding()
    {
        // Получаем все записи из таблицы TeamRegistration
        $registrations = TeamRegistration::all();
    
        foreach ($registrations as $registration) {
            // Декодируем поле participants
            $participants = json_decode($registration->participants, true);
    
            // Проверяем, была ли ошибка при декодировании
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Пропускаем эту запись, если JSON некорректен
                continue;
            }
    
            // Перекодируем поле participants с флагом JSON_UNESCAPED_UNICODE
            $updatedParticipants = json_encode($participants, JSON_UNESCAPED_UNICODE);
    
            // Обновляем поле participants в базе данных
            $registration->participants = $updatedParticipants;
            $registration->save();
        }
    
        return response()->json(['message' => 'Все записи успешно обновлены']);
    }
    

}
