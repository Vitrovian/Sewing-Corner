<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class UserController extends Controller
{
    /**
     * Показати форму реєстрації.
     */
    public function showRegistrationForm()
    {
        return view('user.register');
    }

    // Обробка запиту на реєстрацію
    public function store(Request $request)
    {
        // Валідація даних
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => ['required', 'regex:/^\+380\d{9}$/'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Створення нового користувача
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone, 
            'role' => 'user', // роль за замовчуванням
        ]);
        
        Auth::login($user); // автоматичний вхід після реєстрації

        return redirect()->route('verification.notice')->with('success', 'Реєстрація успішна! Ви увійшли в свій кабінет.');
    }
    
    public function dashboard()
    {
        if (auth()->user()->role === UserRole::Admin) {
            // адміністратор
            return redirect()->route('admin.dashboard')->with('success', 'Вітаю в адмін-панелі!');
        } else {
            // користувач
            return view('user.dashboard');
        }
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        // Валідація даних
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255', // Поле для імені або email
            'password' => 'required|string|min:6', // Перевірка пароля
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Визначаємо, чи це email або ім'я
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Спроба входу
        $remember = $request->has('remember');
        if (auth()->attempt([$loginField => $request->login, 'password' => $request->password], $remember)) {
            return redirect()->route('dashboard')->with('success', 'Вхід успішний!');
        }

        // Якщо вхід не вдався
        return redirect()->back()->withErrors(['login' => 'Неправильне ім\'я, email або пароль.']);
    }
    
    public function forgotPasswordStore(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => 'Посилання для скидання пароля успішно відправлено на вашу електронну пошту.']);
        } elseif ($status === Password::INVALID_USER) {
            return back()->withErrors(['email' => 'Користувача з такою електронною поштою не знайдено.']);
        }
    
        return back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
 
        $status = Password::reset(
            $request->only('password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
 
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['password' => [__($status)]]);
    }
    public function edit()
    {
        $user = auth()->user();
        return view('user.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        $user->update($validated);

        // Повторна авторизація, якщо email змінено
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Дані оновлено');
    }
    public function logout(Request $request)
    {
        auth()->logout();
        
        return redirect()->route('login')->with('success', 'Вихід успішний!');
    }

}
