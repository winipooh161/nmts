document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.regform'); // Используем только для блока с классом regform
    const nameInput = form.querySelector('#name');
    const surnameInput = form.querySelector('#surname');
    const patronymicInput = form.querySelector('#patronymic');
    const passwordInput = form.querySelector('#password');
    const passwordConfirmInput = form.querySelector('#password-confirm');
    const cityInput = document.getElementById("city");
    const phoneInput = form.querySelector('#phone'); // Поле телефона
    const avatarInput = form.querySelector('#avatar');
    const avatarError = form.querySelector('#avatar-error');
    const policyCheckbox = form.querySelector('#policy'); // Чекбокс согласия с обработкой данных
    const rulesCheckbox = form.querySelector('#rulles'); // Чекбокс ознакомления с правилами
    const errorMessage = '<strong>Поле содержит недопустимые символы. Разрешены только русские буквы</strong>';
    const passwordMismatchMessage = '<strong>Пароли не совпадают</strong>';
    const phoneErrorMessage = '<strong>Телефон должен содержать ровно 17 символов</strong>';
    const checkboxErrorMessage = '<strong>Необходимо согласиться с условиями</strong>';
    const avatarErrorMessage = 'Пожалуйста, загрузите ваше реальное фото для подтверждения личности';
    const errorContainers = {};

    // Регулярное выражение для проверки на русские символы
    const nameRegex = /^[А-Яа-яЁё]+$/;

    // Маска для проверки допустимого ввода в поля "Имя", "Фамилия", "Отчество"
    const validateTextInput = (input) => {
        return nameRegex.test(input.value);
    };

    // Удаление пробелов и запрет на ввод недопустимых символов в полях "Имя", "Фамилия", "Отчество"
    [nameInput, surnameInput, patronymicInput, cityInput].forEach(input => {
        input.addEventListener('input', function () {
            input.value = input.value.replace(/[^А-Яа-яЁё]/g, ''); // Удаление всех символов кроме русских букв
        });
    });

    // Функция проверки на совпадение паролей
    const validatePasswordMatch = () => {
        return passwordInput.value === passwordConfirmInput.value;
    };

    // Функция проверки загрузки изображения
    const validateAvatarUpload = () => {
        return avatarInput.files && avatarInput.files.length > 0;
    };

    // Функция проверки длины телефона (должно быть ровно 17 символов)
    const validatePhoneLength = () => {
        return phoneInput.value.length === 17;
    };

    // Функция проверки, выбраны ли чекбоксы
    const validateCheckboxes = () => {
        return policyCheckbox.checked && rulesCheckbox.checked;
    };

    // Функция для создания блока ошибки
    const createErrorContainer = (input) => {
        const errorContainer = document.createElement('span');
        errorContainer.classList.add('invalid-feedback');
        errorContainer.role = 'alert';
        input.parentNode.appendChild(errorContainer);
        return errorContainer;
    };

    // Добавление ошибки в контейнер
    const showError = (input, message) => {
        if (!errorContainers[input.id]) {
            errorContainers[input.id] = createErrorContainer(input);
        }
        errorContainers[input.id].innerHTML = message;
        input.classList.add('is-invalid');
    };

    // Удаление ошибки
    const clearError = (input) => {
        if (errorContainers[input.id]) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            errorContainers[input.id].innerHTML = '';
        }
    };

    // Валидация формы перед отправкой
    form.addEventListener('submit', function(event) {
        let isValid = true;

        // Валидация полей "Имя", "Фамилия", "Отчество" (запрещены цифры и спецсимволы)
        [nameInput, surnameInput, patronymicInput].forEach(input => {
            if (!validateTextInput(input)) {
                showError(input, errorMessage);
                isValid = false;
            } else {
                clearError(input);
            }
        });

        // Валидация поля "Пароль" и "Подтверждение пароля"
        if (!validatePasswordMatch()) {
            showError(passwordConfirmInput, passwordMismatchMessage);
            isValid = false;
        } else {
            clearError(passwordConfirmInput);
        }

        // Валидация поля "Телефон" (ровно 17 символов)
        if (!validatePhoneLength()) {
            showError(phoneInput, phoneErrorMessage);
            isValid = false;
        } else {
            clearError(phoneInput);
        }

        // Валидация загрузки изображения
        if (!validateAvatarUpload()) {
            avatarError.style.display = 'block';
            avatarError.textContent = avatarErrorMessage;
            isValid = false;
        } else {
            avatarError.style.display = 'none';
        }

        // Валидация чекбоксов
        if (!validateCheckboxes()) {
           // Можно использовать модальное окно или встроенные ошибки
            isValid = false;
        }

        // Предотвращение отправки формы, если есть ошибки
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Удаление ошибок при вводе
    [nameInput, surnameInput, patronymicInput, phoneInput, passwordInput, passwordConfirmInput, avatarInput].forEach(input => {
        input.addEventListener('input', function() {
            // Проверка только на имя, фамилию и отчество
            if ([nameInput, surnameInput, patronymicInput].includes(input)) {
                if (validateTextInput(input)) {
                    clearError(input);
                }
            } else if (input === passwordConfirmInput && validatePasswordMatch()) {
                // Проверка на совпадение паролей
                clearError(input);
            } else if (input === phoneInput && validatePhoneLength()) {
                // Проверка длины телефона
                clearError(input);
            }
        });
    });

    avatarInput.addEventListener('change', function() {
        if (validateAvatarUpload()) {
            avatarError.style.display = 'none';
        }
    });
});
