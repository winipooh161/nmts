    @section('register-soloPage')
        <div class="container register__fon ">
            <div class="register__group__title">
                <h1>Регистрация на дисциплину <br> {{$game->title}}</h1>
            </div>
            <div class="form__register">
                <h2 class="tt">Информация</h2>
                <form id="sologooppu" action="{{ route('registerSoloCommand', ['id' => $game->id]) }}" method="POST">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <label for="email">
                        <p>Корпоративная почта</p>
                        <input type="email" name="email" id="email" class="email-input" value="{{ old('email', Auth::user()->email ?? '') }}"
                            placeholder="Введи свою корпоративную почту" maxlength="70" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <div class="block__fio">
                        <label for="name">
                            <p>Имя</p>
                            <input type="text" name="name" id="name" class="name-input" placeholder="Введи своё имя"
                                value="{{ old('name', Auth::user()->name ?? '') }}" maxlength="30" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </label>
                        <label for="surname">
                            <p>Фамилия</p>
                            <input type="text" name="surname" id="surname" class="surname-input" placeholder="Введи свою фамилию"
                                value="{{ old('surname', Auth::user()->surname ?? '') }}" maxlength="30" required>
                            @error('surname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </label>
                        <label for="patronymic">
                            <p>Отчество</p>
                            <input type="text" name="patronymic" id="patronymic" class="patronymic-input" placeholder="Введи своё отчество"
                                value="{{ old('patronymic', Auth::user()->patronymic ?? '') }}" maxlength="30" required>
                            @error('patronymic')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    <div class="block__combo">
                        <label for="discord">
                            <p>Discord</p>
                            <input type="text" name="discord" id="discord" class="discord-input" placeholder="Введи свой @Discord"
                                maxlength="30" required>
                            @error('discord')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </label>
                        <label for="telegram">
                            <p>Telegram</p>
                            <input type="text" name="telegram" id="telegram" class="telegram-input"
                                value="{{ old('telegram', Auth::user()->telegram ?? '') }}" placeholder="Введи свой @Telegram"
                                maxlength="30" required>
                            @error('telegram')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    <label for="birth_date">
                        <p>Дата рождения</p>
                        <input type="text" name="birth_date" id="birth_date" class="date-mask" placeholder="Введи дату рождения"
                            maxlength="10" required>
                        @error('birth_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <label for="nickname">
                        <p>Твой игровой никнейм</p>
                        <input type="text" name="nickname" id="nickname" class="nickname-input" placeholder="Введи свой никнейм" maxlength="50"
                            required>
                        @error('nickname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <label for="rank">
                        <p>Какой твой текущий ранг или уровень игры в {{ $game->title }}?</p>
                        <input type="text" name="rank" id="rank" class="rank-input" placeholder="Введи информацию" maxlength="150"
                            required>
                        @error('rank')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <label for="time_game">
                        <p>Как долго ты играешь в {{ $game->title }}?</p>
                        <input type="text" name="time_game" id="time_game" class="time_game-input" placeholder="Введи информацию" maxlength="150"
                            required>
                        @error('time_game')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <label for="device">
                        <p>Какое устройство ты используешь для игры?</p>
                        <div class="custom-select">
                            <div class="select-selected">Выбери из списка</div>
                            <div class="select-items select-hide">
                                <div data-value="ПК">ПК</div>
                                <div data-value="Консоль">Мобильное устройство</div>
                                <div data-value="Консоль">Консоль</div>
                            </div>
                            <input type="hidden" name="device" id="device-input" required>
                            @error('device')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </label>
                    <label for="match_times">
                        <p>Какое время проведения матчей для тебя самое удобное? (МСК)</p>
                        <div class="custom-select">
                            <div class="select-selected">Выбери из списка</div>
                            <div class="select-items select-hide">
                                <div data-value="12:00–14:00">12:00–14:00</div>
                                <div data-value="13:00–15:00">13:00–15:00</div>
                                <div data-value="14:00–16:00">14:00–16:00</div>
                                <div data-value="15:00–17:00">15:00–17:00</div>
                                <div data-value="16:00–18:00">16:00–18:00</div>
                                <div data-value="17:00–19:00">17:00–19:00</div>
                                <div data-value="18:00–20:00">18:00–20:00</div>
                                <div data-value="19:00–21:00">19:00–21:00</div>
                                <div data-value="20:00–22:00">20:00–22:00</div>
                                <div data-value="21:00–23:00">21:00–23:00</div> 
                                <div data-value="22:00">22:00</div> 
                            </div>
                            <input type="hidden" name="match_times" id="match_times-input" required>
                            @error('match_times')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </label>
                    <label for="internet_connection">
                        <p>Есть ли у тебя стабильное интернет-соединение для участия в онлайн турнире?</p>
                        <div class="custom-select">
                            <div class="select-selected">Выбери из списка</div>
                            <div class="select-items select-hide">
                                <div data-value="Есть, стабильное">Есть, стабильное</div>
                                <div data-value="Есть, но нестабильное">Есть, но нестабильное</div>
                                <div data-value="Нет">Нет</div>
                            </div>
                            @error('internet_connection')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                            <input type="hidden" name="internet_connection" id="internet_connection-input" required>
                        </div>
                    </label>
                    <label for="special_requirements">
                        <p>Есть ли у тебя какие‑либо особые требования для участия в турнире или пожелания?</p>
                        <textarea name="special_requirements" id="special_requirements"maxlength="300"
                            placeholder="Введи информацию о требованиях или пожеланиях" required></textarea>
                        @error('special_requirements')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                   
                    <button type="submit">Отправить заявку</button>
                </form>
            </div>
        </div>
        <div class="block_abs__elements">
            <img src="../assets/img/elements/СyberSport3.png" alt="" class="cuber4">
            <img src="../assets/img/elements/CyberSport.png" alt="" class="cuber3">
        </div>

        <script >
 
document.addEventListener('DOMContentLoaded', function() { 
    const formElement = document.querySelector('#sologooppu'); // Изменяем на id формы
    if (!formElement) return; // Прерываем выполнение, если форма не найдена

    const emailField = formElement.querySelector('#email');
    const firstNameField = formElement.querySelector('#name');
    const lastNameField = formElement.querySelector('#surname');
    const middleNameField = formElement.querySelector('#patronymic');
    const discordField = formElement.querySelector('#discord');
    const telegramField = formElement.querySelector('#telegram');
    const birthDateField = formElement.querySelector('#birth_date');
    const nicknameField = formElement.querySelector('#nickname');
    const rankField = formElement.querySelector('#rank');
    const playtimeField = formElement.querySelector('#time_game');
    const deviceField = formElement.querySelector('#device-input');
    const matchTimeField = formElement.querySelector('#match_times-input');
    const internetConnectionField = formElement.querySelector('#internet_connection-input');


    // Функция для отображения ошибок
    function showValidationError(input, message) {
        let errorDisplay = input.closest('label').querySelector('.text-danger');
        if (!errorDisplay) {
            errorDisplay = document.createElement('span');
            errorDisplay.className = 'text-danger';
            input.closest('label').appendChild(errorDisplay);
        }
        errorDisplay.textContent = message;
    }

    // Функция для очистки ошибок
    function clearValidationError(input) {
        const errorDisplay = input.closest('label').querySelector('.text-danger');
        if (errorDisplay) {
            errorDisplay.textContent = '';
        }
    }

    // Маска для русских символов
    function applyRussianMask(input) {
        input.value = input.value.replace(/[^а-яА-ЯёЁ]/g, ''); // Удаляем все символы, кроме русских букв
    }

    // Валидация текстовых полей (проверка на пробелы и цифры, только русские символы)
    function validateNameInput(input, errorMessage) {
        const value = input.value.trim();
        const namePattern = /^[а-яА-ЯёЁ]+$/; // Регулярное выражение только для русских букв
        if (!namePattern.test(value)) {
            showValidationError(input, errorMessage);
            return false;
        } else {
            clearValidationError(input);
            return true;
        }
    }

    // Валидация email
    function validateEmailField() {
        const emailValue = emailField.value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailValue)) {
            showValidationError(emailField, 'Введите правильную корпоративную почту.');
            return false;
        } else {
            clearValidationError(emailField);
            return true;
        }
    }

    // Валидация даты
    function validateDate(input) {
        const dateValue = input.value.trim();
        const dateRegex = /^\d{2}\.\d{2}\.\d{4}$/; // формат DD.MM.YYYY
        if (!dateRegex.test(dateValue)) {
            showValidationError(input, 'Введите дату в формате DD.MM.YYYY.');
            return false;
        } else {
            clearValidationError(input);
            return true;
        }
    }

    // Валидация выбора устройства
    function validateDeviceSelection() {
        if (!deviceField.value) {
            showValidationError(deviceField, 'Выберите устройство для игры.');
            return false;
        } else {
            clearValidationError(deviceField);
            return true;
        }
    }

    // Валидация времени матчей
    function validateMatchTimeSelection() {
        if (!matchTimeField.value) {
            showValidationError(matchTimeField, 'Выберите удобное время для матчей.');
            return false;
        } else {
            clearValidationError(matchTimeField);
            return true;
        }
    }

    // Валидация интернет-соединения
    function validateInternetConnectionSelection() {
        if (!internetConnectionField.value) {
            showValidationError(internetConnectionField, 'Укажите наличие интернет-соединения.');
            return false;
        } else {
            clearValidationError(internetConnectionField);
            return true;
        }
    }

   
    // Обработка отправки формы
    formElement.addEventListener('submit', function(event) {
        let isFormValid = true;

        if (!validateEmailField()) isFormValid = false;
        if (!validateNameInput(firstNameField, 'Введите правильное имя только русскими буквами.')) isFormValid = false;
        if (!validateNameInput(lastNameField, 'Введите правильную фамилию только русскими буквами.')) isFormValid = false;
        if (!validateNameInput(middleNameField, 'Введите правильное отчество только русскими буквами.')) isFormValid = false;
        if (!validateTextInput(discordField, 'Введите Discord.')) isFormValid = false;
        if (!validateTextInput(telegramField, 'Введите Telegram.')) isFormValid = false;
        if (!validateDate(birthDateField)) isFormValid = false;
        if (!validateTextInput(nicknameField, 'Введите никнейм.')) isFormValid = false;
        if (!validateTextInput(rankField, 'Введите ранг.')) isFormValid = false;
        if (!validateTextInput(playtimeField, 'Введите продолжительность игры.')) isFormValid = false;
        if (!validateDeviceSelection()) isFormValid = false;
        if (!validateMatchTimeSelection()) isFormValid = false;
        if (!validateInternetConnectionSelection()) isFormValid = false;


        // Если форма не валидна, предотвращаем отправку
        if (!isFormValid) {
            event.preventDefault();
        }
    });

    // Применение маски для русских символов на лету
    firstNameField.addEventListener('input', function() {
        applyRussianMask(firstNameField);
    });

    lastNameField.addEventListener('input', function() {
        applyRussianMask(lastNameField);
    });

    middleNameField.addEventListener('input', function() {
        applyRussianMask(middleNameField);
    });

});
</script>

     
    @endsection
