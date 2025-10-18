<div class="fixed top-0 right-0 z-50 flex flex-col items-end p-4 space-y-4">
    @if (isset($notification['status']) && $notification['status'] === 'error')
        <div id="alert-2"
            class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-800 bg-white border border-gray-300 rounded-lg shadow-sm opacity-0 transform translate-y-4 transition-all duration-300 ease-in-out"
            role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Error</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                {{ $notification['message'] }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 text-gray-500 hover:text-red-500 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    @if (isset($notification['status']) && $notification['status'] === 'success')
        <div id="alert-3"
            class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-800 bg-white border border-gray-300 rounded-lg shadow-sm opacity-0 transform translate-y-4 transition-all duration-300 ease-in-out"
            role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Success</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                {{ $notification['message'] }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 text-gray-500 hover:text-red-500 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    @if (isset($notification['status']) && $notification['status'] === 'warning')
        <div id="alert-4"
            class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-800 bg-white border border-gray-300 rounded-lg shadow-sm opacity-0 transform translate-y-4 transition-all duration-300 ease-in-out"
            role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                </svg>
                <span class="sr-only">Warning</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                {{ $notification['message'] }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 text-gray-500 hover:text-orange-500 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert-4" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    <script>
        function showToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('opacity-0', 'translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
            }
        }

        function hideToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-4');
                toast.addEventListener('transitionend', () => {
                    toast.style.display = 'none';
                }, { once: true });
            }
        }

        function setupCloseButton(toastId) {
            const toast = document.getElementById(toastId);
            const closeButton = toast.querySelector('[data-dismiss-target="#' + toastId + '"]');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    hideToast(toastId);
                });
            }
        }

        const toasts = ['alert-2', 'alert-3', 'alert-4'];

        toasts.forEach(toastId => {
            const toast = document.getElementById(toastId);
            @if (isset($notification['duration']))
                const toastDuration = {{ $notification['duration'] }};
            @else
                const toastDuration = 10000;
            @endif

            if (toast) {
                showToast(toastId);
                setTimeout(() => hideToast(toastId), toastDuration);
                setupCloseButton(toastId);
            }
        });
    </script>
</div>
