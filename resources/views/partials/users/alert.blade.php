<link rel="stylesheet" href="{{ asset('asset/libs/toastify-js/src/toastify.css') }}">

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
        <div class="toast-header text-default" id="toastHeader">
            <!-- Icon will change based on the type of message -->
            <span id="toastIcon" class="rounded me-2"></span>
            <strong class="me-auto" id="toastTitle">Notification</strong>
            <small id="toastTime">Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body fw-bold" id="toastMessage">
            This is a toast message.
        </div>
    </div>
</div>

<!-- Session Message Handlers -->
@if (session('error'))
    <div class="d-none" id="toastData" data-type="error" data-message="{{ session('error') }}"></div>
@elseif(session('success'))
    <div class="d-none" id="toastData" data-type="success" data-message="{{ session('success') }}"></div>
@elseif(session('info'))
    <div class="d-none" id="toastData" data-type="info" data-message="{{ session('info') }}"></div>
@endif




<script src="{{ asset('asset/js/toasts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toastData = document.getElementById('toastData');
    if (toastData) {
        var toastType = toastData.getAttribute('data-type');
        var toastMessage = toastData.getAttribute('data-message');
        var toastTitle = "Notification";
        var toastIcon = "";
        var toastHeader = document.getElementById('toastHeader');

        // Adjust title, icon, and header background based on message type
        switch (toastType) {
            case 'success':
                toastTitle = 'Success';
                toastIcon = '<i class="bi bi-check-circle-fill text-success"></i>';
                toastHeader.classList.add('bg-success-transparent', 'text-success');
                break;
            case 'error':
                toastTitle = 'Error';
                toastIcon = '<i class="bi bi-x-circle-fill text-danger"></i>';
                toastHeader.classList.add('bg-danger-transparent', 'text-danger');
                break;
            case 'info':
                toastTitle = 'Info';
                toastIcon = '<i class="bi bi-info-circle-fill text-info"></i>';
                toastHeader.classList.add('bg-info-transparent', 'text-info');
                break;
        }

        // Update toast content
        document.getElementById('toastTitle').innerText = toastTitle;
        document.getElementById('toastMessage').innerText = toastMessage;
        document.getElementById('toastIcon').innerHTML = toastIcon;

        // Initialize and show the toast
        var toastElement = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
});

</script>