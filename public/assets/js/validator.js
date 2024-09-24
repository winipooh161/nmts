document.addEventListener('DOMContentLoaded', function() {

    // Универсальная функция для вывода ошибок
    function showError(input, message) {
        let errorSpan = input.parentElement.querySelector('.text-danger');
        if (!errorSpan) {
            errorSpan = document.createElement('span');
            errorSpan.className = 'text-danger';
            input.parentElement.appendChild(errorSpan);
        }
        errorSpan.textContent = message;
    }

    // Универсальная функция для очистки ошибок
    function clearError(input) {
        const errorSpan = input.parentElement.querySelector('.text-danger');
        if (errorSpan) {
            errorSpan.textContent = '';
        }
    }

    // Валидация регулярного выражения
    function validateRegex(input, regex, errorMessage) {
        if (input && !regex.test(input.value.trim())) {
            showError(input, errorMessage);
            return false;
        } else if (input) {
            clearError(input);
            return true;
        }
        return true;
    }

    // Валидация электронной почты
    function validateEmail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return validateRegex(input, emailRegex, 'Введите правильную корпоративную почту.');
    }

    // Валидация текста (только русские буквы без цифр и пробелов)
    function validateTextOnly(input, errorMessage) {
        const textRegex = /^[А-Яа-яЁё]+$/;
        return validateRegex(input, textRegex, errorMessage);
    }

    // Валидация даты (формат "32/45/6789")
    function validateDate(input) {
        const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
        return validateRegex(input, dateRegex, 'Введите дату в формате "32/45/6789".');
    }

    // Валидация телефона
    function validatePhone(input) {
        const phoneRegex = /^[7]\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/;
        return validateRegex(input, phoneRegex, 'Введите телефон в формате 7 (XXX) XXX-XX-XX.');
    }

    // Валидация пароля
    function validatePassword(password) {
        if (password && password.value.length < 8) {
            showError(password, 'Пароль должен содержать не менее 8 символов.');
            return false;
        } else {
            clearError(password);
            return true;
        }
    }

    // Валидация подтверждения пароля
    function validatePasswordConfirmation(password, passwordConfirmation) {
        if (passwordConfirmation && passwordConfirmation.value !== password.value) {
            showError(passwordConfirmation, 'Пароли не совпадают.');
            return false;
        } else {
            clearError(passwordConfirmation);
            return true;
        }
    }

    // Валидация чекбоксов
    function validateCheckbox(checkbox, errorMessage) {
        if (checkbox && !checkbox.checked) {
            showError(checkbox, errorMessage);
            return false;
        } else if (checkbox) {
            clearError(checkbox.parentElement);
            return true;
        }
        return true;
    }

    // Валидация поля на отсутствие пробелов
    function validateNoSpaces(input, errorMessage) {
        const noSpacesRegex = /^\S+$/;
        return validateRegex(input, noSpacesRegex, errorMessage);
    }

    // Основная функция проверки формы перед отправкой
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Проверка полей электронной почты
            form.querySelectorAll('input[type="email"]').forEach(emailField => {
                if (!validateEmail(emailField)) isValid = false;
            });

            // Проверка текстовых полей на русские буквы (например, name, surname, patronymic, city)
            form.querySelectorAll('input.text-only').forEach(textField => {
                if (!validateTextOnly(textField, 'Поле должно содержать только русские буквы без цифр и пробелов.')) isValid = false;
            });

            // Проверка дат (например, birth_date)
            form.querySelectorAll('input.date-only').forEach(dateField => {
                if (!validateDate(dateField)) isValid = false;
            });

            // Проверка телефонов
            form.querySelectorAll('input.maskphone').forEach(phoneField => {
                if (!validatePhone(phoneField)) isValid = false;
            });

            // Проверка паролей и подтверждений пароля
            const password = form.querySelector('input[name="password"]');
            const passwordConfirmation = form.querySelector('input[name="password_confirmation"]');
            if (password && !validatePassword(password)) isValid = false;
            if (passwordConfirmation && !validatePasswordConfirmation(password, passwordConfirmation)) isValid = false;

            // Проверка чекбоксов
            form.querySelectorAll('input[type="checkbox"]').forEach(checkboxField => {
                if (checkboxField.required && !validateCheckbox(checkboxField, 'Это поле обязательно для согласия.')) isValid = false;
            });

            // Проверка полей без пробелов (например, nickname, rank)
            form.querySelectorAll('input.no-spaces').forEach(noSpacesField => {
                if (!validateNoSpaces(noSpacesField, 'Поле не должно содержать пробелов.')) isValid = false;
            });

            // Если есть ошибки, отменяем отправку формы
            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    // Маска для Telegram и Discord (начинаются с @ и не содержат пробелов)
    document.querySelectorAll('.maskTg, .maskDiscord').forEach(input => {
        input.addEventListener('input', function() {
            if (!input.value.startsWith('@')) {
                input.value = '@' + input.value.replace(/@+/g, '');
            }
            input.value = input.value.replace(/[^@a-zA-Z0-9_]/g, '');
        });

        input.addEventListener('blur', function() {
            if (input.value === '@') {
                input.value = '';
            }
        });
    });

    // Маска для телефонов
    document.querySelectorAll('input.maskphone').forEach(input => {
        input.addEventListener('input', mask);
        input.addEventListener('focus', mask);
        input.addEventListener('blur', mask);
    });

    function mask(event) {
        const blank = "_ (___) ___-__-__";
        let i = 0;
        const val = this.value.replace(/\D/g, "").replace(/^8/, "7").replace(/^9/, "79");
        this.value = blank.replace(/./g, function(char) {
            if (/[_\d]/.test(char) && i < val.length) return val.charAt(i++);
            return i >= val.length ? "" : char;
        });
        if (event.type === "blur" && this.value.length === 2) this.value = "";
    }

});
