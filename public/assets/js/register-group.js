
document.addEventListener('DOMContentLoaded', function() {
    // Находим форму с id="registration__form__group"
    const form = document.getElementById('registration__form__group');
    if (form) { // Убедимся, что форма существует на странице
        const email = document.getElementById('email');
        const nickname = document.getElementById('nickname');
        const name = document.getElementById('name');
        const surname = document.getElementById('surname');
        const patronymic = document.getElementById('patronymic');
        const discord = document.getElementById('discord');
        const telegram = document.getElementById('telegram');
        const birthDate = document.getElementById('birth_date');
        const city = document.getElementById('city');
        const teamName = document.getElementById('team_name');
        const rank = document.getElementById('rank');
        const teamExperience = document.getElementById('team_experience');
        const deviceInput = document.getElementById('device-input');
        const matchTimesInput = document.getElementById('match_times-input');
        const internetConnectionInput = document.getElementById('internet_connection-input');
        const policyCheckbox = document.getElementById('policy');
        const rullesCheckbox = document.getElementById('rulles');

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

        // Валидация чекбоксов
        function validateCheckbox(checkbox, errorMessage) {
            if (!checkbox.checked) {
                showError(checkbox.parentElement, errorMessage);  // Показываем ошибку рядом с чекбоксом
                return false;
            } else {
                clearError(checkbox.parentElement);
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

            // Проверка состояния чекбоксов
            if (!validateCheckbox(policyCheckbox, 'Вы должны согласиться с условиями обработки персональных данных.')) isValid = false;
            if (!validateCheckbox(rullesCheckbox, 'Вы должны ознакомиться с правилами онлайн платформы.')) isValid = false;

            // Если есть ошибки, отменяем отправку формы
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});
