@section('slider')
    <section class="slider__Fon">
        <div class="container">
            <div class="title">
                <h1 class="tt">МТС CYBER CUP</h1>
            </div>
            <div class="slider__Fon__video">
                <h2  class="tt">Главное о турнире</h2>
                <video controls poster="{{ secure_asset('assets/video/lider.png') }}">
                    <source src="{{ secure_asset('assets/video/lider.mp4') }}" type="video/mp4">
                    Ваш браузер не поддерживает элемент <code>video</code>.
                </video>
                
            </div>
        </div>
        {{-- <div class="swiper">
            <div class="swiper-wrapper">
                <div class="title">
                    <h1 class="tt">МТС CYBER CUP</h1>
                </div>
                <div class="swiper-slide">
                    <h4 class="tt">Главное о турнире</h4>
                    <iframe width="720" height="405" src="https://rutube.ru/play/embed/fd372082b1c8f8e92b866ce3ba69864d/"
                        frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen
                        allowFullScreen></iframe>
                </div>
                <div class="swiper-slide">
                    <h4 class="tt">Прямой эфир с лан-финала в Москве</h4>
                    <iframe width="720" height="405"
                        src="https://rutube.ru/play/embed/fd372082b1c8f8e92b866ce3ba69864d/" frameBorder="0"
                        allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                </div>
            </div>
            <div class="div__errt">
                <div class="swiper-button-prev"><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" transform="rotate(180 20 20)" fill="white" />
                    <circle cx="20" cy="20" r="19.5" transform="rotate(180 20 20)" stroke="#BCC3D0"
                        stroke-opacity="0.5" />
                    <path
                        d="M23 26.4875C23 27.3877 21.9234 27.8386 21.2938 27.202C21.2938 27.202 21.2938 27.202 21.2938 27.202L18.1984 24.0727C16.0661 21.9171 15 20.8393 15 19.5C15 18.1607 16.0661 17.0829 18.1984 14.9273L21.2938 11.798C21.9234 11.1614 23 11.6123 23 12.5125C23 12.7804 22.8947 13.0375 22.7073 13.2269L19.6118 16.3563C18.5058 17.4745 17.8214 18.1724 17.3888 18.7456C16.9984 19.2629 16.9988 19.4435 16.999 19.4972L16.999 19.5L16.999 19.5027C16.9988 19.5565 16.9984 19.7371 17.3888 20.2544C17.8214 20.8276 18.5058 21.5255 19.6118 22.6437L22.7073 25.7731C22.7073 25.7731 22.7073 25.7731 22.7073 25.7731C22.8947 25.9625 23 26.2196 23 26.4875Z"
                        fill="black" />
                </svg>
            </div>
            <div class="swiper-button-next"><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" transform="rotate(180 20 20)" fill="white" />
                    <circle cx="20" cy="20" r="19.5" transform="rotate(180 20 20)" stroke="#BCC3D0"
                        stroke-opacity="0.5" />
                    <path
                        d="M17 27.4875C17 28.3877 18.0766 28.8386 18.7062 28.202C18.7062 28.202 18.7062 28.202 18.7062 28.202L21.8016 25.0727C23.9339 22.9171 25 21.8393 25 20.5C25 19.1607 23.9339 18.0829 21.8016 15.9273L18.7062 12.798C18.0766 12.1614 17 12.6123 17 13.5125C17 13.7804 17.1053 14.0375 17.2927 14.2269L20.3882 17.3563C21.4942 18.4745 22.1786 19.1724 22.6112 19.7456C23.0016 20.2629 23.0012 20.4435 23.001 20.4972L23.001 20.5L23.001 20.5027C23.0012 20.5565 23.0016 20.7371 22.6112 21.2544C22.1786 21.8276 21.4942 22.5255 20.3882 23.6437L17.2927 26.7731C17.2927 26.7731 17.2927 26.7731 17.2927 26.7731C17.1053 26.9625 17 27.2196 17 27.4875Z"
                        fill="black" />
                </svg>
            </div>
            </div>
        </div> --}}
    </section>
@endsection
