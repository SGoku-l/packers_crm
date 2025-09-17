<div class="toast-container position-absolute top-0 end-0 p-3">
    @if(session('toasts'))
        @foreach(session('toasts') as $toast)
            <div class="toast align-items-center text-bg-{{ $toast['type'] ?? 'primary' }} show mb-2"
                 role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="20" class="me-1">
                    <h5 class="me-auto my-0">Mifty</h5>
                    <small>{{ $toast['time'] ?? 'Just now' }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ $toast['message'] }}
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toastElList.map(function (toastEl) {
            new bootstrap.Toast(toastEl, { delay: 4000 }).show();
        });
    });
</script>
