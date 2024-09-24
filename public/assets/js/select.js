document.addEventListener("DOMContentLoaded", function() {
    // Функция для работы кастомных селектов
    function setupCustomSelects() {
        const customSelects = document.querySelectorAll('.custom-select');
        customSelects.forEach(function(selectContainer) {
            const selected = selectContainer.querySelector('.select-selected');
            const items = selectContainer.querySelector('.select-items');
            const hiddenInput = selectContainer.querySelector('input[type="hidden"]');
            const otherInput = selectContainer.querySelector('#other-input'); // Только у компании есть это поле
            
            // При клике на селект отображаем/скрываем список
            selected.addEventListener("click", function(e) {
                e.stopPropagation(); // Останавливаем всплытие события
                closeAllSelects(); // Закрываем другие открытые селекты
                items.classList.toggle("select-hide");
                selected.classList.toggle("select-arrow-active");
            });

            // Обрабатываем выбор элемента из списка
            items.addEventListener("click", function(e) {
                if (e.target && e.target.matches("div[data-value]")) {
                    const selectedValue = e.target.getAttribute("data-value");
                    selected.textContent = e.target.textContent;
                    hiddenInput.value = selectedValue;

                    // Проверка только для компании (если поле `otherInput` существует)
                    if (otherInput && selectedValue === "Другое") {
                        otherInput.classList.remove("select-hide");
                        otherInput.focus(); // Фокусируем поле для удобства
                    } else if (otherInput) {
                        otherInput.classList.add("select-hide");
                        otherInput.value = ''; // Очищаем поле ввода, если выбрана не опция "Другое"
                    }

                    items.classList.add("select-hide");
                    selected.classList.remove("select-arrow-active");
                }
            });

            // Обрабатываем ввод в поле "Другое"
            if (otherInput) {
                otherInput.addEventListener("input", function() {
                    hiddenInput.value = otherInput.value; // Сохраняем значение в скрытое поле
                });
            }
        });
    }

    // Функция закрытия всех открытых селектов
    function closeAllSelects() {
        const selectItems = document.querySelectorAll(".select-items");
        const selectSelecteds = document.querySelectorAll(".select-selected");
        selectItems.forEach(function(item) {
            item.classList.add("select-hide");
        });
        selectSelecteds.forEach(function(selected) {
            selected.classList.remove("select-arrow-active");
        });
    }

    // Закрываем селект при клике вне его области
    document.addEventListener('click', function(e) {
        closeAllSelects();
    });

    // Применяем кастомные селекты
    setupCustomSelects();
});
