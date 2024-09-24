document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".profilemodalredact"); // Используем класс profilemodalredact
    const avatarInput = document.getElementById("avatar");
    const nameInput = document.getElementById("name");
    const surnameInput = document.getElementById("surname");
    const patronymicInput = document.getElementById("patronymic");
    const passwordInput = document.getElementById("password");
    const cityInput = document.getElementById("city");
    const passwordConfirmInput = document.getElementById("password-confirm");
    const modalErrors = document.getElementById("modal-errors");
    const errorList = document.getElementById("error-list");
    
    // Регулярное выражение для проверки русских букв
    const nameRegex = /^[А-Яа-яЁё]+$/;

    // Удаление пробелов и ограничение только на русские буквы при вводе
    [nameInput, surnameInput, patronymicInput].forEach(input => {
        input.addEventListener("input", function () {
            // Удаляем пробелы
            input.value = input.value.replace(/\s/g, "");
            // Оставляем только русские буквы
            input.value = input.value.replace(/[^А-Яа-яЁё]/g, "");
        });
    });

    // Удаление пробелов в полях пароля при вводе
    [passwordInput, passwordConfirmInput].forEach(input => {
        input.addEventListener("input", function () {
            input.value = input.value.replace(/\s/g, ""); // Удаляем пробелы
        });
    });

    form.addEventListener("submit", function (event) {
        // Очищаем все предыдущие ошибки
        errorList.innerHTML = "";
        modalErrors.style.display = "none";
        clearErrorStyles([avatarInput, nameInput, surnameInput, patronymicInput, passwordInput, passwordConfirmInput]);
        let hasErrors = false;

        // Проверка аватара на размер
        const avatarFile = avatarInput.files[0];
        if (avatarFile && avatarFile.size > 4.9 * 1024 * 1024) {
            displayError(avatarInput, "Размер файла не должен превышать 4.9 МБ");
            hasErrors = true;
        }

        // Проверка полей на русские буквы
        if (!nameRegex.test(nameInput.value.trim())) {
            displayError(nameInput, "Имя должно содержать только русские буквы без пробелов");
            hasErrors = true;
        }
        if (!nameRegex.test(surnameInput.value.trim())) {
            displayError(surnameInput, "Фамилия должна содержать только русские буквы без пробелов");
            hasErrors = true;
        }
        if (!nameRegex.test(patronymicInput.value.trim())) {
            displayError(patronymicInput, "Отчество должно содержать только русские буквы без пробелов");
            hasErrors = true;
        }
        if (!nameRegex.test(cityInput.value.trim())) {
            displayError(cityInput, "Город должн содержать только русские буквы без пробелов");
            hasErrors = true;
        }
        // Проверка пароля на совпадение
        if (passwordInput.value !== passwordConfirmInput.value) {
            displayError(passwordInput, "Пароли не совпадают");
            displayError(passwordConfirmInput, "Пароли не совпадают");
            hasErrors = true;
        }

        // Если есть ошибки, предотвращаем отправку формы
        if (hasErrors) {
            event.preventDefault();
            modalErrors.style.display = "block";
        }
    });

    function displayError(inputElement, message) {
        const errorFeedback = inputElement.parentElement.querySelector(".invalid-feedback strong");
        if (errorFeedback) {
            errorFeedback.textContent = message;
        } else {
            const errorFeedback = document.createElement("span");
            errorFeedback.classList.add("invalid-feedback");
            errorFeedback.innerHTML = `<strong>${message}</strong>`;
            inputElement.parentElement.appendChild(errorFeedback);
        }
        inputElement.classList.add("is-invalid");
    }

    function clearErrorStyles(inputs) {
        inputs.forEach(input => {
            input.classList.remove("is-invalid");
            const errorFeedback = input.parentElement.querySelector(".invalid-feedback strong");
            if (errorFeedback) {
                errorFeedback.textContent = "";
            }
        });
    }
});
