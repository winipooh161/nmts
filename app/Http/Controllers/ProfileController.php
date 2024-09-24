<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;
use App\Models\UserOfflineStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Show the profile edit form
    // Handle the profile update
    public function profileedit(Request $request)
    {
        // Валидация данных
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:50',
            'surname' => 'nullable|max:50',
            'patronymic' => 'nullable|max:50',
            'telegram' => 'nullable|max:50',
            'email' => 'nullable|email|max:70',
            'company' => 'nullable|max:100',
            'city' => 'nullable|max:100',
            'phone' => 'nullable|max:20',
            'current_password' => 'required_with:password',
            'password' => 'nullable|confirmed|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Получаем текущего пользователя
        $user = Auth::user();
    
        // Проверка текущего пароля перед обновлением
        if ($request->filled('password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Неверный текущий пароль.'])->withInput();
            }
            $user->password = Hash::make($request->input('password'));
        }
    
        // Обновляем аватар
        if ($request->hasFile('avatar')) {
            $uploadPath = public_path('avatars');
            $avatarName = time() . '_' . uniqid() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move($uploadPath, $avatarName);
            $user->avatar = $avatarName;
        }
    
        // Обновляем другие данные пользователя
        $user->name = $request->input('name', $user->name);
        $user->surname = $request->input('surname', $user->surname);
        $user->patronymic = $request->input('patronymic', $user->patronymic);
        $user->telegram = $request->input('telegram', $user->telegram);
        $user->email = $request->input('email', $user->email);
        $user->company = $request->input('company', $user->company);
        $user->city = $request->input('city', $user->city);
        $user->phone = $request->input('phone', $user->phone);
    
        // Сохраняем пользователя
        $user->save();
    
        // Отправляем письмо через SMTP с использованием Blade-шаблона
        $to = $request->email;
        $subject = 'Успешное изменение профиля!';
    
        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'phone' => $request->phone,
            'telegram' => $request->telegram,
            'company' => $request->company,
            'city' => $request->city,
        ];
    
        
        Mail::send('emails.profile-updated', $data, function ($message) use ($to, $subject) {
            $message->to($to)
                    ->subject($subject);
        });
    
        return redirect()->to(url()->previous() . '?modal=profileModal')->with('success', 'Profile updated successfully.');
    }

    
    public function offlineModal(Request $request)
    {
        $request->validate([
            'offline' => 'required|string|in:Да,Нет',
        ]);
        // Получаем авторизованного пользователя
        $user = Auth::user();
        // Сохраняем статус в новую таблицу
        UserOfflineStatus::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'offline' => $request->offline,
        ]);
        // Возвращаем ответ
        return response()->json(['message' => 'Статус успешно обновлен!'], 200);
    }
    public function profileDelete(Request $request)
    {
        // Получаем текущего пользователя
        $user = Auth::user();
        // Удаляем пользователя
        if ($user) {
            $user->delete(); // Удаление пользователя
            // Завершаем сессию
            Auth::logout();
            // Перенаправляем на страницу логина
            return redirect()->route('login')->with('status', 'Ваш аккаунт был успешно удалён.');
        }
        return redirect()->back()->withErrors(['Не удалось удалить аккаунт. Попробуйте позже.']);
    }
}
