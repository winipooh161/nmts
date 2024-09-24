@section('offlineModalYES')
<div class="modal" id="offlineModalYES" style="display: none;">
    <div class="modal__body">
        <div class="alert alert-danger" id="modal-errors" style="display: none;">
            <ul id="error-list"></ul>
        </div>
        <span class="close-modal"><svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 12.2793C0 5.65188 5.37258 0.279297 12 0.279297H20C26.6274 0.279297 32 5.65188 32 12.2793V20.2793C32 26.9067 26.6274 32.2793 20 32.2793H12C5.37258 32.2793 0 26.9067 0 20.2793V12.2793Z" fill="#F2F3F7"/>
            <g clip-path="url(#clip0_53_546)">
            <path d="M10.2929 20.5722C9.90237 20.9627 9.90237 21.5959 10.2929 21.9864C10.6834 22.3769 11.3166 22.3769 11.7071 21.9864L15.9999 17.6936L20.2929 21.9866C20.6834 22.3771 21.3166 22.3771 21.7071 21.9866C22.0976 21.596 22.0976 20.9629 21.7071 20.5723L17.4141 16.2794L21.7071 11.9864C22.0976 11.5959 22.0976 10.9627 21.7071 10.5722C21.3166 10.1817 20.6834 10.1817 20.2929 10.5722L15.9999 14.8652L11.7071 10.5723C11.3166 10.1818 10.6834 10.1818 10.2929 10.5723C9.90237 10.9629 9.90237 11.596 10.2929 11.9866L14.5857 16.2794L10.2929 20.5722Z" fill="#1D2023"/>
            </g>
            <defs>
            <clipPath id="clip0_53_546">
            <rect width="24" height="24" fill="white" transform="translate(4 4.2793)"/>
            </clipPath>
            </defs>
            </svg>
    </span> 
        <div class="modal__form offlineModal">
          <form  > 
                @csrf
                <h6 class="tt">Твоя заявка принята</h6>
                <p>Мы вышлем подробную информацию на твою почтау</p>
            </form>
            <label for="" class="yes__button__no">
                <button onclick="" class="close-modal" >{{ __('На главную') }}</button>
            </label>
        </div>
    </div>
</div>
@endsection