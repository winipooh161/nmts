<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Jobs\SendRegistrationEmail;

class RegisterController extends Controller
{
    // Список разрешённых доменов
    protected $allowedDomains = [
        'urent.ru', 'ticketscloud.com', 'greendc.ru', 'bronevik.com', 'gulfstream.ru', 'mts.ru',
       'mtsretail.ru', 'metro-telecom.ru', 'mgts.ru', 'mts-energo.ru', 'rstudios.ru', 'ponominalu.ru',
        'stopol-auto.com', 'litebox.ru', 'mtsbank.ru', 'ticketland.ru', 'it-grad.ru', 'zelenaya.net', 'mtt.ru', 
        'comdi.com', 'webinar.ru', 'iformula.ru', 'cc.zelenaya.net', 'mtrend.ru', 'elista.zelenaya.net', 'gorodtv.net',
        'tambov.zelenaya.net', 'vladivostok.zelenaya.net', 'belgorod.zelenaya.net', 'lipezk.zelenaya.net', 'tomsk.zelenaya.net',
        'ufa.zelenaya.net', 'visionlabs.ai', 'nov.mts.ru', 'exolve.ru', 'skai.online', 'mts-link.ru', 'ekb.gulfstream.ru',
        'krd.gulfstream.ru', 'krk.gulfstream.ru', 'kzn.gulfstream.ru', 'nn.gulfstream.ru', 'nsb.gulfstream.ru', 'oms.gulfstream.ru',
        'prm.gulfstream.ru', 'rst.gulfstream.ru', 'sch.gulfstream.ru', 'sip.gulfstream.ru', 'smartsafety.dev', 'smr.gulfstream.ru',
        'sochi.gulfstream.ru', 'spb.gulfstream.ru', 'srv.gulfstream.ru', 'yar.gulfstream.ru', 'weareathome.ru', 'vrz.gulfstream.ru',
        'vgd.gulfstream.ru', 'ufa.gulfstream.ru', 'tul.gulfstream.ru', 'tmn.gulfstream.ru', 'exibank.ru', 'exi-bank.ru', 'urent.city'
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Показ формы регистрации
    public function showRegistrationForm()
    {
        $title = "Регистрация аккаунта";
        return view('auth.registers.complete', compact('title'));
    }

    // Обработка завершения регистрации
    public function completeRegistration(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', function ($attribute, $value, $fail) {
                $domain = substr(strrchr($value, "@"), 1);
                if (!in_array($domain, $this->allowedDomains)) {
                    $fail('Ваш домен не разрешён для регистрации.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telegram' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:18'],
            'city' => ['required', 'string', 'max:50'],
            'company' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Avatar processing
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . uniqid() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telegram' => $request->telegram,
            'phone' => $request->phone,
            'city' => $request->city,
            'company' => $request->company,
            'avatar' => $avatarName,
        ]);

        // Данные для отправки письма
        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'password' => $request->password,
            'telegram' => $request->telegram,
            'phone' => $request->phone,
            'city' => $request->city,
            'company' => $request->company,
            'avatar' => $avatarName,
        ];

        Mail::send('emails.registration', $data, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Регистрация аккаунта')
                ->from('mtstest@hench.ru', 'MTS Cyber Cup');
        });

        return redirect('/login');
    }
}
