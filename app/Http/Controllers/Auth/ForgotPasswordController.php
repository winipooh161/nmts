<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

use App\Models\TeamRegistration;
use App\Models\SoloRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $title = "Востановление пароля от аккаунта";
        return view('auth.passwords.email', compact('title'));
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Валидация email
        $request->validate(['email' => 'required|email']);
    
        // Проверка наличия пользователя с данным email
        $user = User::where('email', $request->email)->first();
      
        if ($user) {
            // Создаем токен для сброса пароля
            $token = Password::createToken($user);
            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );
    
            // Формируем ссылку для сброса пароля
            $resetLink = url('password/reset', $token) . '?email=' . urlencode($request->email);
            
            // Данные для отправки письма
            $data = [
                'resetLink' => $resetLink,
                'email' => $request->email,
                'name' => $user->name, // Предполагается, что поле name есть у пользователя
            ];
    
            // Отправка письма
            Mail::send('emails.password-reset', $data, function ($message) use ($request) {
                // Используем адрес отправителя, который соответствует домену
                $message->from('mtstest@hench.ru', 'MTS Cyber Cup');
    
                // Устанавливаем email пользователя для ответа
                $message->replyTo($request->email);
    
                // Адресат и тема письма
                $message->to($request->email)->subject('Сброс пароля на сайте MTS Cyber Cup');
            });
    
            // Перенаправление с сообщением об успешной отправке
            return back()->with('status', 'Ссылка для восстановления пароля отправлена на ваш email.');
        } else {
            // Если пользователь не найден
            return back()->withErrors(['email' => 'Пользователь с таким email не найден.']);
        }
    }
    
}
