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

// Преобразуем все города в один массив для удобства поиска и сортируем по алфавиту
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
