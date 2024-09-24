<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeamRegistration;
use App\Models\SoloRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegController extends Controller
{
    public function registerGroup($id)
    {

        $game = Game::findOrFail($id);
        $title = "Регистрация команды на  $game->title ";

        return view('register-group', compact('game', 'title'));
    }

    public function registerGroupCommand(Request $request, $id)
    {
        $user = Auth::user();
        $game = Game::findOrFail($id);
    
        // Проверяем, зарегистрирован ли пользователь для этой игры командой
        $existingRegistration = TeamRegistration::where('game_id', $game->id)
                                                 ->where('user_id', $user->id)
                                                 ->first();
        if ($existingRegistration) {
            // Если регистрация найдена, перенаправляем на главную страницу с сообщением
            return redirect()->route('home')->withErrors(['error' => 'Вы уже зарегистрированы на эту игру.']);
        }
        $participants = $request->input('participants', []);
    
        // Проверяем, что $participants является массивом
        if (!is_array($participants)) {
            return redirect()->back()->withErrors(['participants' => "Invalid data format for participants."]);
        }
    
        // Проверяем и форматируем дату рождения для каждого участника
        foreach ($participants as $key => $participant) {
            if (!is_array($participant)) {
                return redirect()->back()->withErrors(['participants' => "Invalid data format for participant $key."]);
            }
            if (isset($participant['birth_date'])) {
                $birthDate = $this->formatDate($participant['birth_date']);
                if ($birthDate === false) {
                    return redirect()->back()->withErrors(['participants' => "Invalid date format for participant $key."]);
                }
                $participants[$key]['birth_date'] = $birthDate;
            }
        }
    
        // Преобразование даты рождения
        if ($request->has('birth_date')) {
            $birthDate = \DateTime::createFromFormat('d.m.Y', $request->birth_date);
            if ($birthDate) {
                $request->merge(['birth_date' => $birthDate->format('Y-m-d')]);
            } else {
                return redirect()->back()->withErrors(['birth_date' => 'Invalid date format.']);
            }
        }
    
        // Перезаписываем данные участников с преобразованной датой
        $request->merge(['participants' => $participants]);
    
        // Валидация данных
        $validated = $request->validate([
            'email' => 'required|email|max:70',
            'name' => 'required|string|max:70',
            'surname' => 'required|string|max:70',
            'patronymic' => 'required|string|max:70',
            'nickname' => 'nullable|string',
            'participants' => 'required|array|min:1|max:7',
            'participants.*.fio' => 'required|string|max:100',
            'participants.*.email' => 'required|email|max:50',
            'participants.*.nickname' => 'required|string|max:50',
        ]);
    
        // Собираем данные для регистрации команды
        $teamData = [
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'nickname' => $request->nickname,
            'birth_date' => $request->birth_date,
  'participants' => json_encode($participants, JSON_UNESCAPED_UNICODE),

            'game_id' => $game->id,
            'user_id' => $user->id,
            'city' => $user->city,
            'company' => $user->company,
            'internet_connection' => $request->input('internet_connection', 'Нет данных'),
        ];
    
        // Добавляем необязательные поля с значениями по умолчанию
        $optionalFields = [
            'discord',
            'telegram',
            'branch',
            'team_name',
            'rank',
            'team_experience',
            'device',
            'match_times',
            'special_requirements'
        ];
        foreach ($optionalFields as $field) {
            $teamData[$field] = $request->input($field, 'Нет данных');
        }
    
        // Сохраняем данные регистрации команды
        $teamRegistration = TeamRegistration::create($teamData);
    
        // Данные для отправки в шаблон письма
        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'nickname' => $request->nickname,
            'birth_date' => $request->birth_date,
            'participants' => $participants,
            'game' => $game,
            'company' => $user->company,
            'city' => $user->city,
            'discord' => $request->discord,
            'telegram' => $request->telegram,
            'rank' => $request->rank,
            'team_name' => $request->team_name,
            'team_experience' => $request->team_experience,
            'device' => $request->device,
            'match_times' => $request->match_times,
            'internet_connection' => $request->internet_connection,
            'special_requirements' => $request->special_requirements,
        ];
       
        // Отправка письма с использованием шаблона
        Mail::send('emails.registration-group', $data, function ($message) use ($request) {
            $message->from('mts.cybercup@mail.ru', 'MTS Cyber Cup');
            $message->to("mtstest@hench.ru")->subject('Успешная регистрация команды!');
        });
    

        return redirect()->route('thanky', ['id' => $game->id])->with('success', 'Команда успешно зарегистрирована!');
    }
    



    public function registerquiz($id)
    {

        $game = Game::findOrFail($id);
        $title = "Регистрация команды на  $game->title ";

        return view('register-quiz', compact('game', 'title'));
    }
    public function registerquizCommand(Request $request, $id)
    {
        $user = Auth::user();
        $game = Game::findOrFail($id);
    
        // Проверяем, зарегистрирован ли пользователь для этой игры командой
        $existingRegistration = TeamRegistration::where('game_id', $game->id)
                                                 ->where('user_id', $user->id)
                                                 ->first();
        if ($existingRegistration) {
            // Если регистрация найдена, перенаправляем на главную страницу с сообщением
            return redirect()->route('home')->withErrors(['error' => 'Вы уже зарегистрированы на эту игру.']);
        }
        $participants = $request->input('participants', []);
    
        // Проверяем, что $participants является массивом
        if (!is_array($participants)) {
            return redirect()->back()->withErrors(['participants' => "Invalid data format for participants."]);
        }
    
        // Проверяем и форматируем дату рождения для каждого участника
        foreach ($participants as $key => $participant) {
            if (!is_array($participant)) {
                return redirect()->back()->withErrors(['participants' => "Invalid data format for participant $key."]);
            }
            if (isset($participant['birth_date'])) {
                $birthDate = $this->formatDate($participant['birth_date']);
                if ($birthDate === false) {
                    return redirect()->back()->withErrors(['participants' => "Invalid date format for participant $key."]);
                }
                $participants[$key]['birth_date'] = $birthDate;
            }
        }
    
        // Преобразование даты рождения
        if ($request->has('birth_date')) {
            $birthDate = \DateTime::createFromFormat('d.m.Y', $request->birth_date);
            if ($birthDate) {
                $request->merge(['birth_date' => $birthDate->format('Y-m-d')]);
            } else {
                return redirect()->back()->withErrors(['birth_date' => 'Invalid date format.']);
            }
        }
    
        // Перезаписываем данные участников с преобразованной датой
        $request->merge(['participants' => $participants]);
    
        // Валидация данных
        $validated = $request->validate([
            'email' => 'required|email|max:70',
            'name' => 'required|string|max:70',
            'surname' => 'required|string|max:70',
            'patronymic' => 'required|string|max:70',
            'nickname' => 'nullable|string',
            'participants' => 'required|array|min:1|max:7',
            'participants.*.fio' => 'required|string|max:100',
            'participants.*.email' => 'required|email|max:50',
            'participants.*.nickname' => 'required|string|max:50',
        ]);
    
        // Собираем данные для регистрации команды
        $teamData = [
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'nickname' => $request->nickname,
            'birth_date' => $request->birth_date,
'participants' => json_encode($participants, JSON_UNESCAPED_UNICODE),

            'game_id' => $game->id,
            'user_id' => $user->id,
            'city' => $user->city,
            'company' => $user->company,
            'internet_connection' => $request->input('internet_connection', 'Нет данных'),
        ];
    
        // Добавляем необязательные поля с значениями по умолчанию
        $optionalFields = [
            'discord',
            'telegram',
            'branch',
            'team_name',
            'rank',
            'team_experience',
            'device',
            'match_times',
            'special_requirements'
        ];
        foreach ($optionalFields as $field) {
            $teamData[$field] = $request->input($field, 'Нет данных');
        }
    
        // Сохраняем данные регистрации команды
        $teamRegistration = TeamRegistration::create($teamData);
    
        // Данные для отправки в шаблон письма
        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'nickname' => $request->nickname,
            'birth_date' => $request->birth_date,
            'participants' => $participants,
            'game' => $game,
            'company' => $user->company,
            'city' => $user->city,
            'discord' => $request->discord,
            'telegram' => $request->telegram,
            'rank' => $request->rank,
            'team_name' => $request->team_name,
            'team_experience' => $request->team_experience,
            'device' => $request->device,
            'match_times' => $request->match_times,
            'internet_connection' => $request->internet_connection,
            'special_requirements' => $request->special_requirements,
        ];
       
        
        // Отправка письма с использованием шаблона
        Mail::send('emails.registration-quiz', $data, function ($message) use ($request) {
            $message->from('mts.cybercup@mail.ru', 'MTS Cyber Cup');
            $message->to('mtstest@hench.ru')->subject('Успешная регистрация команды!');
        });
    
        // Возвращаем успешный ответ
        return redirect()->route('thanky', ['id' => $game->id])->with('success', 'Команда успешно зарегистрирована!');
    }
    





    private function formatDate($date)
    {
        $dateTime = \DateTime::createFromFormat('d.m.Y', $date);
        if ($dateTime !== false) {
            return $dateTime->format('Y-m-d');
        }
        return false;
    }

    public function registerSolo($id)
    {
      
        $game = Game::findOrFail($id);
        $title = "Регистрация по дисциплине:  $game->title ";

        return view('register-solo', compact('game', 'title'));
    }
    public function registerSoloCommand(Request $request, $id)
    {
        $user = Auth::user();
        $game = Game::findOrFail($id);
    
        // Проверяем, зарегистрирован ли пользователь для этой игры соло
        $existingRegistration = SoloRegistration::where('game_id', $game->id)
                                                 ->where('user_id', $user->id)
                                                 ->first();
        if ($existingRegistration) {
            // Если регистрация найдена, перенаправляем на главную страницу с сообщением
            return redirect()->route('home')->withErrors(['error' => 'Вы уже зарегистрированы на эту игру.']);
        }
    
        // Преобразование даты рождения
        if ($request->has('birth_date')) {
            $birthDate = \DateTime::createFromFormat('d.m.Y', $request->birth_date);
            if ($birthDate) {
                $request->merge(['birth_date' => $birthDate->format('Y-m-d')]); // преобразование в формат Y-m-d для базы данных
            } else {
                return redirect()->back()->withErrors(['birth_date' => 'Invalid date format.']);
            }
        }
    
        // Валидация данных
        $validated = $request->validate([
            'email' => 'required|email|max:70',
            'name' => 'required|string|max:70',
            'surname' => 'required|string|max:70',
            'patronymic' => 'required|string|max:70',
            'discord' => 'required|string|max:70',
            'telegram' => 'required|string|max:70',
            'birth_date' => 'required|date',
            'nickname' => 'nullable|string',
            'rank' => 'required|string|max:150',
            'time_game' => 'required|string|max:150',
            'device' => 'required|string',
            'match_times' => 'required|string|max:150',
            'internet_connection' => 'required|string|max:150',
            'special_requirements' => 'nullable|string|max:150',
        ]);
    
        $user = Auth::user(); // Получаем аутентифицированного пользователя
    
        // Сохраняем данные регистрации
        SoloRegistration::create([
            'game_id' => $game->id,
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'discord' => $request->discord,
            'telegram' => $request->telegram,
            'birth_date' => $request->birth_date,
            'nickname' => $request->nickname,
            'rank' => $request->rank,
            'time_game' => $request->time_game,
            'device' => $request->device,
            'match_times' => $request->match_times,
            'internet_connection' => $request->internet_connection,
            'special_requirements' => $request->special_requirements,
            'user_id' => $user->id,
            'city' => $user->city,
            'company' => $user->company,
        ]);
    
        // Данные для отправки письма
        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'discord' => $request->discord,
            'telegram' => $request->telegram,
            'birth_date' => $request->birth_date,
            'nickname' => $request->nickname,
            'rank' => $request->rank,
            'time_game' => $request->time_game,
            'device' => $request->device,
            'match_times' => $request->match_times,
            'internet_connection' => $request->internet_connection,
            'special_requirements' => $request->special_requirements,
            'game' => $game,
            'company' => $user->company,
            'city' => $user->city,
        ];
    
        // Отправка письма
        Mail::send('emails.solo_registration', $data, function ($message) use ($request) {
            $message->from('mtstest@hench.ru', 'MTS Cyber Cup');
            $message->to("mtstest@hench.ru")->subject('Успешная регистрация в дисциплине!');
        });
    
        // Редирект на страницу благодарности
        return redirect()->route('thanky', ['id' => $game->id])->with('success', 'Registration completed successfully.');
    }
    public function thanky($id)
    {
        $game = Game::findOrFail($id);
        $title = "Спасибо за регистрацию по игре $game->title";
        return view('thanky', compact('game', 'title'));
    }
}



