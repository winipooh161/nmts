@section('register-groupPage')
    <div class="container register__fon validreg   ">
        <div class="register__group__title">
            <h1>Регистрация на дисциплину <br> {{$game->title}}</h1>
      
        </div>
        <div class="form__register">
            <div class="form__register__title">
                <h2 class="tt">Информация</h2>
                <p>Данную информацию заполняет капитан команды и только один раз.</p>
            </div>
     
            <form id="registration__form__group" action="{{ route('registerGroupCommand', ['id' => $game->id]) }}" method="POST">
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
                    <input type="email" name="email" id="email" class="email-input" value="{{ old('email', Auth::user()->email) }}"
                        placeholder="Введи свою корпоративную почту" maxlength="70" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </label>
                <div class="block__fio">
                    <label for="name">
                        <p>Имя</p>
                        <input type="text" name="name" id="name" class="name-input" placeholder="Введи своё имя"
                            value="{{ old('name', Auth::user()->name) }}" maxlength="30" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <label for="surname">
                        <p>Фамилия</p>
                        <input type="text" name="surname" id="surname" class="surname-input" placeholder="Введи свою фамилию"
                            value="{{ old('surname', Auth::user()->surname) }}" maxlength="30" required>
                        @error('surname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                    <label for="patronymic">
                        <p>Отчество</p>
                        <input type="text" name="patronymic" id="patronymic" class="patronymic-input" placeholder="Введи своё отчество"
                            value="{{ old('patronymic', Auth::user()->patronymic) }}" maxlength="30" required>
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
                            value="{{ old('telegram', Auth::user()->telegram) }}" placeholder="Введи свой @Telegram"
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
                <label for="team_name">
                    <p>Название твоей команды</p>
                    <input type="text" name="team_name" id="team_name" class="team_name-input" placeholder="Введи название команды"
                        maxlength="30" required>
                    @error('team_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </label>
                <div class="register__participants">
                    <h2 class="tt">Данные участников</h2>
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="participant">
                            <span>{{ $i }}</span>
                            <label for="fio__participant_{{ $i }}">
                                <p>ФИО</p>
                                <input type="text" name="participants[{{ $i }}][fio]"
                                    id="fio__participant_{{ $i }}" placeholder="Введи ФИО игрока"
                                    maxlength="100" required>
                                @error("participants.$i.fio")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </label>
                            <label for="birth_date__participant_{{ $i }}">
                                <p>Дата рождения</p>
                                <input type="text" name="participants[{{ $i }}][birth_date]"
                                    id="birth_date__participant_{{ $i }}" placeholder="Введи дату рождения"
                                    class="date-mask" maxlength="10" required>
                                @error("participants.$i.birth_date")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </label>
                            <label for="city__participant_{{ $i }}">
                                <p>Город проживания </p>
                                <input type="text" name="participants[{{ $i }}][city]"
                                    id="city__participant_{{ $i }}" placeholder="Выбери город"
                                    maxlength="50" required autocomplete="off">
                                <div id="city-list-{{ $i }}" class="city-list"></div>
                                @error("participants.$i.city")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </label>
                            <div class="block__fio">
                                <label for="email__participant_{{ $i }}">
                                    <p>Корпоративная почта</p>
                                    <input type="email" name="participants[{{ $i }}][email]"
                                        id="email__participant_{{ $i }}"
                                        placeholder="Введи корпоративную почту" maxlength="70" required>
                                    @error("participants.$i.email")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </label>
                                <label for="telegram__participant_{{ $i }}">
                                    <p>Телеграм</p>
                                    <input type="text" name="participants[{{ $i }}][telegram]"
                                        id="telegram__participant_{{ $i }}"
                                        placeholder="Введи @Telegram игрока" maxlength="50" required>
                                    @error("participants.$i.telegram")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                            <div class="block__fio">
                                <label for="discord__participant_{{ $i }}">
                                    <p>Discord</p>
                                    <input type="text" name="participants[{{ $i }}][discord]"
                                        id="discord__participant_{{ $i }}"
                                        placeholder="Введи @Discord игрока" maxlength="50" required>
                                    @error("participants.$i.discord")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </label>
                                <label for="nickname__participant_{{ $i }}">
                                    <p>Игровой никнейм</p>
                                    <input type="text" name="participants[{{ $i }}][nickname]"
                                        id="nickname__participant_{{ $i }}"
                                        placeholder="Введи никнейм игрока" maxlength="50" required>
                                    @error("participants.$i.nickname")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </label>
                                </label>
                            </div>
                        </div>
                    @endfor
                </div>
                <label for="rank">
                    <p>Какой средний текущий ранг или уровень участников твоей команды в {{ $game->title }}?</p>
                    <input type="text" name="rank" id="rank" class="rank-input" placeholder="Введи информацию"
                        maxlength="150" required>
                    @error('rank')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </label>
                <label for="team_experience">
                    <p>Как долго твоя команда играет вместе?</p>
                    <input type="text" name="team_experience" id="team_experience" class="team_experience-input" placeholder="Введи информацию"
                        maxlength="150" required>
                    @error('team_experience')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </label>
                <label for="device">
                    <p>Какое устройство ты и твоя команда используете для игры?</p>
                    <div class="custom-select">
                        <div class="select-selected" id="selected-device">Выбери из списка</div>
                        <div class="select-items select-hide">
                            <div data-value="ПК">ПК</div>
                            <div data-value="Консоль">Мобильное устройство</div>
                            <div data-value="Консоль">Консоль</div>
                        </div>
                        <input type="hidden" name="device" id="device-input">
                    </div>
                </label>
                <label for="match_times">
                    <p>Какое время проведения матчей для тебя и твоей команды самое удобное? (МСК)</p>
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
                    <p>Есть ли у тебя стабильное интернет-соединение для участия в онлайн турнире?</p>
                    <div class="custom-select">
                        <div class="select-selected" id="selected-internet_connection">Выбери из списка</div>
                        <div class="select-items select-hide">
                            <div data-value="Есть, стабильное">Есть, стабильное</div>
                            <div data-value="Есть, но нестабильное">Есть, но нестабильное</div>
                            <div data-value="Нет">Нет</div>
                        </div>
                        <input type="hidden" name="internet_connection" id="internet_connection-input">
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
    <script>
        const cities = {
            "Дальний Восток": ["Владивосток", "Хабаровск", "Южно-Сахалинск", "Якутск", "Благовещенск",
                "Петропавловск-Камчатский", "Магадан", "Айхал", "Алдан", "Амурск", "Анадырь", "Арсеньев", "Артем",
                "Белогорск", "Биробиджан", "Большой Камень"
            ],
            "Северо-Запад": ["Санкт-Петербург", "Калининград", "Мурманск", "Архангельск", "Великий Новгород", "Вологда",
                "Сыктывкар", "Псков", "Петрозаводск", "Балтийск", "Бокситогорск", "Боровичи", "Валдай",
                "Великие Луки", "Великий Устюг", "Вельск"
            ],
            "Поволжье": ["Пермь", "Уфа", "Оренбург", "Пенза", "Казань", "Ижевск", "Саратов", "Нижний Новгород",
                "Самара", "Киров", "Чебоксары", "Ульяновск", "Йошкар-Ола", "Саранск", "Агрыз", "Азнакаево"
            ],
            "Сибирь": ["Новосибирск", "Омск", "Красноярск", "Норильск", "Иркутск", "Кемерово", "Томск", "Чита",
                "Улан-Удэ", "Абакан", "Кызыл", "Барнаул", "Анжеро-Судженск", "Ачинск", "Белово"
            ],
            "Урал": ["Екатеринбург", "Челябинск", "Тюмень", "Курган", "Ханты-Мансийск", "Ноябрьск", "Алапаевск",
                "Артемовский", "Асбест", "Аша", "Белоярский", "Березовский", "Богданович", "Верхнеуральск"
            ],
            "Центр": ["Белгород", "Брянск", "Владимир", "Воронеж", "Иваново", "Калуга", "Кострома", "Курск", "Липецк",
                "Орёл", "Рязань", "Смоленск", "Тамбов", "Тверь", "Тула"
            ],
            "Юг": ["Ростов-на-Дону", "Краснодар", "Ставрополь", "Махачкала", "Владикавказ", "Волгоград", "Астрахань",
                "Нальчик", "Абинск", "Азов", "Аксай", "Александровское", "Анапа", "Адлер", "Апшеронск"
            ],
            "Москва и МО": ["Москва", "Андреевка", "Архангельское", "Балашиха", "Бронницы", "Бутово", "Быково",
                "Видное", "Власиха", "ВНИИССОК", "Волоколамск", "Воскресенск", "Голицыно", "Голубое", "Дедовск"
            ]
        };
    
        // Преобразуем все города в один массив и сортируем по алфавиту
        const allCities = Object.values(cities).flat().sort((a, b) => a.localeCompare(b));
    
        // Функция для отображения списка городов
        function showCityList(cityInput, cityList, filteredCities) {
            cityList.innerHTML = ''; // Очищаем предыдущие результаты
            if (filteredCities.length === 0) {
                cityList.style.display = 'none';
                return;
            }
            filteredCities.forEach(city => {
                const div = document.createElement('div');
                div.classList.add('city-list-item');
                div.textContent = city;
                div.addEventListener('click', () => {
                    cityInput.value = city; // При клике заполняем input выбранным городом
                    cityList.style.display = 'none'; // Скрываем список
                });
                cityList.appendChild(div);
            });
            cityList.style.display = 'block'; // Показываем список
        }
    
        // Обработчик ввода текста в input
        function setupCityAutocomplete(cityInputId, cityListId) {
            const cityInput = document.getElementById(cityInputId);
            const cityList = document.getElementById(cityListId);
            cityInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const filteredCities = allCities.filter(city => city.toLowerCase().includes(query));
                showCityList(cityInput, cityList, filteredCities);
            });
    
            // Скрываем список, если клик вне его
            document.addEventListener('click', function(e) {
                if (!cityInput.contains(e.target) && !cityList.contains(e.target)) {
                    cityList.style.display = 'none';
                }
            });
        }
    
        // Применяем автозаполнение к основному полю города
        setupCityAutocomplete('city', 'city-list');
    
        // Применяем автозаполнение к каждому полю участников
        document.addEventListener('DOMContentLoaded', function() {
            @for ($i = 1; $i <= 4; $i++)
                setupCityAutocomplete('city__participant_{{ $i }}', 'city-list-{{ $i }}');
            @endfor
        });
    </script>
    
    <script></script>
    <div class="block_abs__elements">
        <img src="../assets/img/elements/СyberSport3.png" alt="" class="cuber4">
        <img src="../assets/img/elements/CyberSport.png" alt="" class="cuber3">
    </div>
    <script>
     document.addEventListener('DOMContentLoaded', function() {
    // Находим форму с классом 'registration__form__group'
    const form = document.querySelector('.registration__form__group');
    if (form) { // Убедимся, что форма существует на странице
        const email = form.querySelector('.email-input');
        const nickname = form.querySelector('.nickname-input');
        const name = form.querySelector('.name-input');
        const surname = form.querySelector('.surname-input');
        const patronymic = form.querySelector('.patronymic-input');
        const discord = form.querySelector('.discord-input');
        const telegram = form.querySelector('.telegram-input');
        const birthDate = form.querySelector('.birthdate-input');
        const city = form.querySelector('.city-input');
        const teamName = form.querySelector('.teamname-input');
        const rank = form.querySelector('.rank-input');
        const teamExperience = form.querySelector('.teamexperience-input');
        const deviceInput = form.querySelector('.device-input');
        const matchTimesInput = form.querySelector('.matchtimes-input');
        const internetConnectionInput = form.querySelector('.internetconnection-input');

        // Функция для вывода ошибок
        function showError(input, message) {
            let errorSpan = input.parentElement.querySelector('.text-danger');
            if (!errorSpan) {
                errorSpan = document.createElement('span');
                errorSpan.className = 'text-danger';
                input.parentElement.appendChild(errorSpan);
            }
            errorSpan.textContent = message;
        }

        // Функция для очистки ошибок
        function clearError(input) {
            const errorSpan = input.parentElement.querySelector('.text-danger');
            if (errorSpan) {
                errorSpan.textContent = '';
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
                showError(input, errorMessage);
                return false;
            } else {
                clearError(input);
                return true;
            }
        }

        // Валидация электронной почты
        function validateEmail() {
            const emailValue = email.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailValue)) {
                showError(email, 'Введите правильную корпоративную почту.');
                return false;
            } else {
                clearError(email);
                return true;
            }
        }

        // Валидация обязательных текстовых полей
        function validateTextInput(input, errorMessage) {
            if (input.value.trim() === '') {
                showError(input, errorMessage);
                return false;
            } else {
                clearError(input);
                return true;
            }
        }

        // Валидация даты
        function validateDate(input) {
            const dateValue = input.value.trim();
            const dateRegex = /^\d{2}\.\d{2}\.\d{4}$/; // формат DD.MM.YYYY
            if (!dateRegex.test(dateValue)) {
                showError(input, 'Введите дату в формате DD.MM.YYYY.');
                return false;
            } else {
                clearError(input);
                return true;
            }
        }

        // Функция для автоматической замены "/" на "."
        function autoCorrectDateInput(input) {
            input.value = input.value.replace(/\//g, '.'); // Заменяем все "/" на "."
        }

        // Применение маски для русских символов на лету
        name.addEventListener('input', function() {
            applyRussianMask(name);
        });

        surname.addEventListener('input', function() {
            applyRussianMask(surname);
        });

        patronymic.addEventListener('input', function() {
            applyRussianMask(patronymic);
        });

        // Применение автоматической коррекции формата даты на лету
        birthDate.addEventListener('input', function() {
            autoCorrectDateInput(birthDate);
        });

        // Валидация выбора устройства
        function validateDevice() {
            if (!deviceInput.value) {
                showError(deviceInput.parentElement, 'Выберите устройство для игры.');
                return false;
            } else {
                clearError(deviceInput.parentElement);
                return true;
            }
        }

        // Валидация времени матчей
        function validateMatchTime() {
            if (!matchTimesInput.value) {
                showError(matchTimesInput.parentElement, 'Выберите удобное время для матчей.');
                return false;
            } else {
                clearError(matchTimesInput.parentElement);
                return true;
            }
        }

        // Валидация интернет-соединения
        function validateInternetConnection() {
            if (!internetConnectionInput.value) {
                showError(internetConnectionInput.parentElement, 'Укажите наличие интернет-соединения.');
                return false;
            } else {
                clearError(internetConnectionInput.parentElement);
                return true;
            }
        }

        // Обработка отправки формы
        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Валидация всех полей формы
            if (!validateEmail()) isValid = false;
            if (!validateTextInput(nickname, 'Введите игровой никнейм.')) isValid = false;
            if (!validateNameInput(name, 'Введите правильное имя только русскими буквами.')) isValid = false;
            if (!validateNameInput(surname, 'Введите правильную фамилию только русскими буквами.')) isValid = false;
            if (!validateNameInput(patronymic, 'Введите правильное отчество только русскими буквами.')) isValid = false;
            if (!validateTextInput(discord, 'Введите Discord.')) isValid = false;
            if (!validateTextInput(telegram, 'Введите Telegram.')) isValid = false;
            if (!validateDate(birthDate)) isValid = false;
            if (!validateTextInput(city, 'Введите город.')) isValid = false;
            if (!validateTextInput(teamName, 'Введите название команды.')) isValid = false;
            if (!validateTextInput(rank, 'Введите средний ранг команды.')) isValid = false;
            if (!validateTextInput(teamExperience, 'Введите опыт команды.')) isValid = false;
            if (!validateDevice()) isValid = false;
            if (!validateMatchTime()) isValid = false;
            if (!validateInternetConnection()) isValid = false;

            // Если есть ошибки, отменяем отправку формы
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});

        </script>
        
@endsection
