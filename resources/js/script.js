// function initSkeleton(skeletonId, contentId, delay = 1000) {
//     const skeleton = document.getElementById(skeletonId);
//     const content = document.getElementById(contentId);

//     // Gunakan sessionStorage key unik berdasarkan halaman
//     const pageKey = `skeleton-loaded-${window.location.pathname}`;

//     if (sessionStorage.getItem(pageKey) === 'true') {
//         // Kalau sudah pernah diload, langsung sembunyikan skeleton
//         skeleton?.classList.add("hidden");
//         content?.classList.remove("hidden");
//     } else {
//         // Tampilkan skeleton lalu simpan status di sessionStorage
//         setTimeout(() => {
//             skeleton?.classList.add("hidden");
//             content?.classList.remove("hidden");
//             sessionStorage.setItem(pageKey, 'true');
//         }, delay);
//     }
// }

// function initSubmitLoaders() {
//     document.querySelectorAll("[data-submit-loader]").forEach(button => {
//         const loaderSelector = button.getAttribute("data-loader");
//         const contentSelector = button.getAttribute("data-content");

//         const loader = loaderSelector ? document.querySelector(loaderSelector) : null;
//         const content = contentSelector ? document.querySelector(contentSelector) : null;

//         button.addEventListener("click", () => {
//             content?.classList.remove("hidden");
//             loader?.classList.remove("hidden");
//             button.classList.add("cursor-not-allowed", "opacity-70");
//         });

//         const buttonId = button.id;
//         window[`hideSubmitLoader_${buttonId}`] = () => {
//             content?.classList.add("hidden");
//             loader?.classList.add("hidden");
//             button.classList.remove("cursor-not-allowed", "opacity-70");
//         };

//         window.hideSubmitLoader_submitSearchUser?.();

//     });
// }

// function initImagePreview(inputId, containerId, submitButtonId, maxSizeMB = 2) {
//     const input = document.getElementById(inputId);
//     const container = document.getElementById(containerId);
//     const submitButton = document.getElementById(submitButtonId);
//     const initialsSpan = container?.querySelector("span");

//     input?.addEventListener("change", function () {
//         const file = this.files[0];
//         if (file) {
//             const reader = new FileReader();
//             reader.onload = function (e) {
//                 container.style.backgroundImage = `url('${e.target.result}')`;
//                 container.style.backgroundSize = "cover";
//                 container.style.backgroundPosition = "center";
//                 initialsSpan?.style && (initialsSpan.style.display = "none");
//                 submitButton?.classList.remove("hidden");
//             };
//             reader.readAsDataURL(file);
//         }
//     });
// }

// function initModularModals() {
//     document.querySelectorAll('[data-modal-show]').forEach(button => {
//         button.addEventListener('click', () => {
//             const target = button.getAttribute('data-modal-show');
//             const modal = document.getElementById(target);
//             if (modal) {
//                 modal.classList.remove('hidden');
//                 modal.classList.add('flex');
//             }
//         });
//     });

//     document.querySelectorAll('[data-modal-hide]').forEach(button => {
//         button.addEventListener('click', () => {
//             const target = button.getAttribute('data-modal-hide');
//             const modal = document.getElementById(target);
//             if (modal) {
//                 modal.classList.add('hidden');
//                 modal.classList.remove('flex');
//             }
//         });
//     });

//     // Optional: klik luar modal untuk tutup
//     document.querySelectorAll('.custom-modal').forEach(modal => {
//         modal.addEventListener('click', function (e) {
//             if (e.target === modal) {
//                 modal.classList.add('hidden');
//                 modal.classList.remove('flex');
//             }
//         });
//     });
// }

// function showFlashNotification() {
//     const toasts = ['alert-2', 'alert-3', 'alert-4'];
//     toasts.forEach(toastId => {
//         const toast = document.getElementById(toastId);
//         if (toast) {
//             toast.classList.remove('opacity-0', 'translate-y-4');
//             toast.classList.add('opacity-100', 'translate-y-0');
//             setTimeout(() => {
//                 toast.classList.remove('opacity-100', 'translate-y-0');
//                 toast.classList.add('opacity-0', 'translate-y-4');
//                 toast.addEventListener('transitionend', () => {
//                     toast.style.display = 'none';
//                 }, {
//                     once: true
//                 });
//             }, 10000);
//             const closeButton = toast.querySelector('[data-dismiss-target="#' + toastId + '"]');
//             if (closeButton) {
//                 closeButton.addEventListener('click', () => {
//                     toast.classList.remove('opacity-100', 'translate-y-0');
//                     toast.classList.add('opacity-0', 'translate-y-4');
//                     toast.addEventListener('transitionend', () => {
//                         toast.style.display = 'none';
//                     }, {
//                         once: true
//                     });
//                 });
//             }
//         }
//     });
// }

// function initDropdowns() {
//     document.querySelectorAll('[data-collapse-toggle]').forEach(toggle => {
//         // Hapus event listener lama (jika ada), supaya tidak dobel
//         toggle.replaceWith(toggle.cloneNode(true));
//     });

//     document.querySelectorAll('[data-collapse-toggle]').forEach(toggle => {
//         toggle.addEventListener('click', () => {
//             const targetId = toggle.getAttribute('aria-controls');
//             const target = document.getElementById(targetId);
//             if (!target) return;

//             target.classList.toggle('hidden');
//         });
//     });
// }

// function initAll() {
//     initSkeleton("profile-content-skeleton", "profile-content");
//     initSkeleton("home-content-skeleton", "home-content");
//     initSkeleton("user-management-skeleton", "user-management-content");

//     initImagePreview("avatarInput", "avatar-container", "submitPhoto");
// }

// function reinitUI() {
//     if (window.initModals) window.initModals();
//     if (window.initAccordions) window.initAccordions();
//     if (window.initDropdowns) window.initDropdowns();
//     if (window.initTabs) window.initTabs();
//     if (window.initTooltips) window.initTooltips();

//     if (window.lucide) {
//         lucide.createIcons();
//     }

//     initAll();
//     initDropdowns();
//     showFlashNotification();
//     initModularModals();
//     initSubmitLoaders();
// }

// // Event-event Turbo dan DOM
// document.addEventListener("DOMContentLoaded", reinitUI);
// document.addEventListener("turbo:load", reinitUI);
// document.addEventListener("turbo:frame-load", reinitUI);














































// // ------------------------- Skeleton Loader -------------------------
// function initSkeleton(skeletonId, contentId, delay = 1000) {
//     const skeleton = document.getElementById(skeletonId);
//     const content = document.getElementById(contentId);

//     if (!skeleton || !content) return;

//     const pageKey = `skeleton-loaded-${window.location.pathname}`;

//     if (sessionStorage.getItem(pageKey) === 'true') {
//         skeleton.classList.add("hidden");
//         content.classList.remove("hidden");
//     } else {
//         setTimeout(() => {
//             skeleton.classList.add("hidden");
//             content.classList.remove("hidden");
//             sessionStorage.setItem(pageKey, 'true');
//         }, delay);
//     }
// }

// ------------------------- Submit Loaders -------------------------
// function initSubmitLoaders() {
//     document.querySelectorAll("[data-submit-loader]").forEach(button => {
//         const loaderSelector = button.getAttribute("data-loader");
//         const contentSelector = button.getAttribute("data-content");

//         const loader = loaderSelector ? document.querySelector(loaderSelector) : null;
//         const content = contentSelector ? document.querySelector(contentSelector) : null;

//         button.addEventListener("click", () => {
//             content?.classList.remove("hidden");
//             loader?.classList.remove("hidden");
//             button.classList.add("cursor-not-allowed", "opacity-70");
//         });

//         // Buat fungsi global untuk mengembalikan button
//         const buttonId = button.id;
//         if (buttonId) {
//             window[`hideSubmitLoader_${buttonId}`] = () => {
//                 content?.classList.add("hidden");
//                 loader?.classList.add("hidden");
//                 button.classList.remove("cursor-not-allowed", "opacity-70");
//             };
//         }
//     });
// }

// // ------------------------- Image Preview -------------------------
// function initImagePreview(inputId, containerId, submitButtonId, maxSizeMB = 2) {
//     const input = document.getElementById(inputId);
//     const container = document.getElementById(containerId);
//     const submitButton = document.getElementById(submitButtonId);
//     const initialsSpan = container?.querySelector("span");

//     if (!input || !container) return;

//     input.addEventListener("change", function () {
//         const file = this.files[0];
//         if (!file) return;

//         if (file.size > maxSizeMB * 1024 * 1024) {
//             alert(`Ukuran maksimal ${maxSizeMB}MB`);
//             input.value = "";
//             return;
//         }

//         const reader = new FileReader();
//         reader.onload = function (e) {
//             container.style.backgroundImage = `url('${e.target.result}')`;
//             container.style.backgroundSize = "cover";
//             container.style.backgroundPosition = "center";
//             if (initialsSpan) initialsSpan.style.display = "none";
//             submitButton?.classList.remove("hidden");
//         };
//         reader.readAsDataURL(file);
//     });
// }

// // ------------------------- Modals -------------------------
// function initModularModals() {
//     document.body.addEventListener('click', (e) => {
//         const showBtn = e.target.closest('[data-modal-show]');
//         const hideBtn = e.target.closest('[data-modal-hide]');

//         if (showBtn) {
//             const target = showBtn.getAttribute('data-modal-show');
//             const modal = document.getElementById(target);
//             if (modal) {
//                 modal.classList.remove('hidden');
//                 modal.classList.add('flex');
//             }
//         }

//         if (hideBtn) {
//             const target = hideBtn.getAttribute('data-modal-hide');
//             const modal = document.getElementById(target);
//             if (modal) {
//                 modal.classList.add('hidden');
//                 modal.classList.remove('flex');
//             }
//         }
//     });

//     // klik luar modal untuk close
//     document.querySelectorAll('.custom-modal').forEach(modal => {
//         modal.addEventListener('click', function (e) {
//             if (e.target === modal) {
//                 modal.classList.add('hidden');
//                 modal.classList.remove('flex');
//             }
//         });
//     });

//     // Escape key untuk close
//     document.addEventListener('keydown', (e) => {
//         if (e.key === "Escape") {
//             document.querySelectorAll('.custom-modal.flex').forEach(modal => {
//                 modal.classList.add('hidden');
//                 modal.classList.remove('flex');
//             });
//         }
//     });
// }



// // ------------------------- Dropdowns -------------------------
// function initDropdowns() {
//     document.body.addEventListener('click', (e) => {
//         const toggle = e.target.closest('[data-collapse-toggle]');
//         if (!toggle) return;

//         const targetId = toggle.getAttribute('aria-controls');
//         const target = document.getElementById(targetId);
//         if (!target) return;

//         target.classList.toggle('hidden');
//     });
// }

// // ------------------------- Reinit & Init -------------------------
// function initAll() {
//     initSkeleton("profile-content-skeleton", "profile-content");
//     initSkeleton("home-content-skeleton", "home-content");
//     initSkeleton("user-management-skeleton", "user-management-content");

//     initImagePreview("avatarInput", "avatar-container", "submitPhoto");
// }


// // ------------------------- Events -------------------------
// document.addEventListener("DOMContentLoaded", reinitUI);
// document.addEventListener("turbo:load", reinitUI);
// document.addEventListener("turbo:frame-load", reinitUI);

// ------------------------- Flash Notifications -------------------------
// function showFlashNotification() {
//     const toasts = ['alert-2', 'alert-3', 'alert-4'];

//     toasts.forEach(toastId => {
//         const toast = document.getElementById(toastId);
//         if (!toast) return;

//         const show = () => {
//             toast.classList.remove('opacity-0', 'translate-y-4');
//             toast.classList.add('opacity-100', 'translate-y-0');
//         };

//         const hide = () => {
//             toast.classList.remove('opacity-100', 'translate-y-0');
//             toast.classList.add('opacity-0', 'translate-y-4');
//             toast.addEventListener('transitionend', () => {
//                 toast.style.display = 'none';
//             }, { once: true });
//         };

//         show();
//         setTimeout(hide, 10000);

//         const closeButton = toast.querySelector(`[data-dismiss-target="#${toastId}"]`);
//         if (closeButton) closeButton.addEventListener('click', hide);
//     });
// }

// // ------------------------- Submit Loaders -------------------------
// function initSubmitLoaders() {
//     document.querySelectorAll("[data-submit-loader]").forEach(button => {
//         const loaderSelector = button.getAttribute("data-loader");
//         const contentSelector = button.getAttribute("data-content");

//         const loader = loaderSelector ? document.querySelector(loaderSelector) : null;
//         const content = contentSelector ? document.querySelector(contentSelector) : null;

//         // Bersihkan listener lama biar gak numpuk saat turbo load
//         const newButton = button.cloneNode(true);
//         button.replaceWith(newButton);

//         newButton.addEventListener("click", () => {
//             if (content) content.classList.add("hidden");   // sembunyikan teks
//             if (loader) loader.classList.remove("hidden");  // tampilkan loader
//             newButton.classList.add("cursor-not-allowed", "opacity-70");
//         });

//         // Buat fungsi global untuk reset button
//         const buttonId = newButton.id;
//         if (buttonId) {
//             window[`hideSubmitLoader_${buttonId}`] = () => {
//                 if (content) content.classList.remove("hidden");
//                 if (loader) loader.classList.add("hidden");
//                 newButton.classList.remove("cursor-not-allowed", "opacity-70");
//             };
//         }
//     });
// }

// function reinitUI() {
//     showFlashNotification();
//     initSubmitLoaders();
// }

// function initApp() {
//     reinitUI();
//     if (window.lucide) {
//         lucide.createIcons();
//     }

//     if (typeof initFlowbite === "function") {
//         initFlowbite();
//     }
// } 

// document.addEventListener("DOMContentLoaded", initApp);
// document.addEventListener("turbo:load", initApp);
// document.addEventListener("turbo:frame-load", initApp);




// document.addEventListener('DOMContentLoaded', function () {
// const tabButtons = document.querySelectorAll('.tab-button');
// const tabContents = document.querySelectorAll('.tab-content');

// tabButtons.forEach(button => {
//     button.addEventListener('click', () => {
//         tabButtons.forEach(btn => {
//             btn.classList.remove('active');
//             btn.classList.remove('bg-[#468B97]', 'text-white');
//             btn.classList.add('bg-gray-100', 'text-gray-700');
//         });

//         button.classList.add('active', 'bg-[#468B97]', 'text-white');
//         button.classList.remove('bg-gray-100', 'text-gray-700');

//         tabContents.forEach(content => {
//             content.classList.remove('active');
//             content.classList.add('hidden');
//         });

//         const tabId = button.getAttribute('data-tab');
//         const activeTab = document.getElementById(tabId);
//         activeTab.classList.remove('hidden');
//         activeTab.classList.add('active');
//     });
// });

// const slides = document.querySelectorAll('.slideshow-image');
// let currentSlide = 0;

// function showNextSlide() {
//     slides[currentSlide].classList.remove('active');
//     currentSlide = (currentSlide + 1) % slides.length;
//     slides[currentSlide].classList.add('active');
// }

// setInterval(showNextSlide, 5000);
// });

// lucide.createIcons();





// function handleSubmitLoaderClick(e) {
//     const button = e.target.closest("[data-submit-loader]");
//     if (!button) return;

//     const loaderSelector = button.getAttribute("data-loader");
//     const contentSelector = button.getAttribute("data-content");

//     const loader = loaderSelector ? document.querySelector(loaderSelector) : null;
//     const content = contentSelector ? document.querySelector(contentSelector) : null;

//     // Tampilkan loader
//     if (loader) loader.classList.remove("hidden");
//     if (content) content.classList.add("hidden");
//     button.classList.add("cursor-not-allowed", "opacity-70");

//     // Simpan fungsi global agar bisa di-hide kembali
//     const buttonId = button.id;
//     if (buttonId) {
//         window[`hideSubmitLoader_${buttonId}`] = () => {
//             if (loader) loader.classList.add("hidden");
//             if (content) content.classList.remove("hidden");
//             button.classList.remove("cursor-not-allowed", "opacity-70");
//         };
//     }
// }

// function initSubmitLoaders() {
//     document.removeEventListener("click", handleSubmitLoaderClick);
//     document.addEventListener("click", handleSubmitLoaderClick);
// }













function slideImage() {
    const slides = document.querySelectorAll('.slideshow-image');
    let currentSlide = 0;

    function showNextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    setInterval(showNextSlide, 5000);
}

function tabButton() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('bg-[#468B97]', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            button.classList.add('active', 'bg-[#468B97]', 'text-white');
            button.classList.remove('bg-gray-100', 'text-gray-700');

            tabContents.forEach(content => {
                content.classList.remove('active');
                content.classList.add('hidden');
            });

            const tabId = button.getAttribute('data-tab');
            const activeTab = document.getElementById(tabId);
            activeTab.classList.remove('hidden');
            activeTab.classList.add('active');
        });
    });
}

function handleSubmitLoaderClick(e) {
    const button = e.target.closest("[data-submit-loader]");
    if (!button) return;

    const loaderSelector = button.getAttribute("data-loader");
    const loader = loaderSelector ? document.querySelector(loaderSelector) : null;

    const shouldHideIcon = button.getAttribute("data-hide-icon") === "true";
    const contentIcons = button.querySelectorAll("[data-content]");

    if (loader) loader.classList.remove("hidden");
    if (shouldHideIcon) {
        contentIcons.forEach(icon => icon.classList.add("hidden"));
    }

    button.classList.add("cursor-not-allowed", "opacity-70");

    const buttonId = button.id;
    if (buttonId) {
        window[`hideSubmitLoader_${buttonId}`] = () => {
            if (loader) loader.classList.add("hidden");
            if (shouldHideIcon) {
                contentIcons.forEach(icon => icon.classList.remove("hidden"));
            }
            button.classList.remove("cursor-not-allowed", "opacity-70");
        };
    }
}

function initSubmitLoaders() {
    document.removeEventListener("click", handleSubmitLoaderClick);
    document.addEventListener("click", handleSubmitLoaderClick);
}

function showFlashNotification() {
    const toasts = ['alert-2', 'alert-3', 'alert-4'];

    toasts.forEach(toastId => {
        const toast = document.getElementById(toastId);
        if (!toast) return;

        toast.classList.remove('opacity-0', 'translate-y-4');
        toast.classList.add('opacity-100', 'translate-y-0');

        // Auto hide setelah 10 detik
        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-4');
            toast.addEventListener('transitionend', () => {
                toast.style.display = 'none';
            }, { once: true });
        }, 10000);

        const closeButton = toast.querySelector(`[data-dismiss-target="#${toastId}"]`);
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-4');
                toast.addEventListener('transitionend', () => {
                    toast.style.display = 'none';
                }, { once: true });
            });
        }
    });
}

function initImagePreview(inputId, containerId, submitButtonId, maxSizeMB = 2) {
    const input = document.getElementById(inputId);
    const container = document.getElementById(containerId);
    const submitButton = document.getElementById(submitButtonId);
    const initialsSpan = container?.querySelector("span");

    input?.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                container.style.backgroundImage = `url('${e.target.result}')`;
                container.style.backgroundSize = "cover";
                container.style.backgroundPosition = "center";
                initialsSpan?.style && (initialsSpan.style.display = "none");
                submitButton?.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    });
}

function initUI() {
    if (typeof initFlowbite === "function") initFlowbite();
    if (window.lucide) lucide.createIcons();

    // Init komponen lokal
    slideImage();
    tabButton();

    initSubmitLoaders();
    showFlashNotification();

    initImagePreview("avatarInput", "avatar-container", "submitPhoto");
}

["DOMContentLoaded", "turbo:load", "turbo:render", "turbo:frame-load", "turbo:before-stream-render"].forEach(evt => {
    document.addEventListener(evt, initUI);
});

