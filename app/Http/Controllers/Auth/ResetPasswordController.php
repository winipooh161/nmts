<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        // Проверяем, существует ли запись с этим токеном в таблице password_resets
        $reset = DB::table('password_resets')->where('email', $request->email)->first();
        if (!$reset || !Hash::check($token, $reset->token)) {
            return redirect()->route('password.request')->withErrors(['email' => 'Недействительная или устаревшая ссылка для сброса пароля.']);
        }

        // Устанавливаем заголовок страницы
        $title = "Введи новый пароль от аккаунта";

        // Если токен валиден, показываем форму сброса пароля
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
            'title' => $title,
        ]);
    }

    public function reset(Request $request)
{
    // Упрощённая валидация входных данных
    $request->validate([
        'email' => 'required|email',
        'password' => 'required', // Проверка только на наличие пароля
        'token' => 'required',
    ]);

    // Получаем запись из таблицы password_resets по email
    $reset = DB::table('password_resets')->where('email', $request->email)->first();

    // Проверка токена
    if (!$reset || !Hash::check($request->token, $reset->token)) {
        return redirect()->route('password.request')->withErrors([
            'email' => 'Недействительная или устаревшая ссылка для сброса пароля.',
        ]);
    }

    // Найти пользователя по email
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return redirect()->route('password.request')->withErrors([
            'email' => 'Пользователь с таким email не найден.',
        ]);
    }

    try {
        // Сменить пароль на новый
        $user->password = Hash::make($request->password);
        $user->save();

        // Удалить запись с токеном после успешного сброса пароля
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Отправить письмо с уведомлением
        $data = [
            'email' => $request->email,
            'name' => $user->name, // Имя пользователя
            'password' => $request->password, // Новый пароль
        ];

        Mail::send('emails.password-yes', $data, function ($message) use ($request) {
            $message->from('mtstest@hench.ru', 'MTS Cyber Cup');
            $message->replyTo($request->email);
            $message->to($request->email)->subject('Сброс пароля на сайте MTS Cyber Cup');
        });

        // Авторизация пользователя (если необходимо)
        Auth::login($user);

        // Перенаправление с сообщением об успехе
        return redirect()->route('login')->with('status', 'Ваш пароль был успешно изменен! Мы отправили вам уведомление на вашу почту.');
    } catch (\Exception $e) {
        // Логирование ошибки
        \Log::error('Ошибка при смене пароля: ' . $e->getMessage());

        return redirect()->route('password.request')->withErrors([
            'email' => 'Произошла ошибка при смене пароля. Попробуйте снова.',
        ]);
    }
}

    
}
