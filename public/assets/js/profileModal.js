document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const avatarInput = document.querySelector('#avatar');
    const avatarPreview = document.querySelector('#avatar-preview img');
    const submitButton = document.querySelector('button[type="submit"]');
    const successMessageContainer = document.createElement('div');
    const modalProfile = document.getElementById('profileModal');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    successMessageContainer.classList.add('alert', 'alert-success');
    successMessageContainer.style.display = 'none';  // Initially hidden
    form.insertBefore(successMessageContainer, form.firstChild);  // Add success message above form

    function updateURLParameter(param, value) {
        const url = new URL(window.location);
        if (value) {
            url.searchParams.set(param, value);
        } else {
            url.searchParams.delete(param);
        }
        window.history.replaceState(null, null, url);
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();  
        const formData = new FormData(form);
        submitButton.disabled = true;
        axios.post(form.action, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            document.querySelectorAll('.invalid-feedback').forEach(element => element.textContent = '');
            document.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
            successMessageContainer.textContent = response.data.success;
            successMessageContainer.style.display = 'block';
            submitButton.disabled = false;
            openModal(modalProfile);
            updateURLParameter('modal', 'profileModal'); 
        })
        .catch(error => {
            submitButton.disabled = false;
            document.querySelectorAll('.invalid-feedback').forEach(element => element.textContent = '');
            document.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
            if (error.response && error.response.data.errors) {
                const errors = error.response.data.errors;
                Object.keys(errors).forEach(function(key) {
                    const errorMessage = errors[key][0];
                    const inputField = document.querySelector(`[name="${key}"]`);
                    if (inputField) {
                        const errorElement = inputField.closest('label').querySelector('.invalid-feedback');
                        if (errorElement) {
                            errorElement.textContent = errorMessage;
                            inputField.classList.add('is-invalid');
                        }
                    }
                });
            }
        });
    });

    avatarInput.addEventListener('change', function() {
        const file = avatarInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    const nameInput = document.querySelector('[name="name"]');
    const surnameInput = document.querySelector('[name="surname"]');
    const patronymicInput = document.querySelector('[name="patronymic"]');
    const passwordInput = document.querySelector('[name="password"]');
    const passwordConfirmInput = document.querySelector('[name="password_confirmation"]');

    // Ограничиваем ввод только русскими буквами и удаляем пробелы
    [nameInput, surnameInput, patronymicInput].forEach(input => {
        input.addEventListener("input", function () {
            input.value = input.value.replace(/[^а-яА-ЯёЁ]/g, "");  // Удаляем все символы, кроме русских букв
            input.value = input.value.replace(/\s/g, "");  // Удаляем пробелы
        });
    });

    [passwordInput, passwordConfirmInput].forEach(input => {
        input.addEventListener("input", function () {
            input.value = input.value.replace(/\s/g, "");  // Удаляем пробелы
        });
    });

    const tgInput = document.querySelector('.maskTg');
    tgInput.addEventListener('input', function() {
        if (!tgInput.value.startsWith('@')) {
            tgInput.value = '@' + tgInput.value.replace(/@+/g, '');
        }
        tgInput.value = tgInput.value.replace(/[^@a-zA-Z0-9_]/g, '');
    });

    tgInput.addEventListener('blur', function() {
        if (tgInput.value === '@') {
            tgInput.value = '';
        }
    });

    function openModal(modal) {
        modal.style.display = 'flex';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
        updateURLParameter('modal', '');
    }

    closeModalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            closeModal(modalProfile);
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const modalName = urlParams.get('modal');
    if (modalName === 'profileModal') {
        openModal(modalProfile);
    }
});
