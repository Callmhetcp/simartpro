// const TOAST_CONFIGS = {
//     success: {
//         icon: `<svg viewBox="0 0 24 24" width="24" height="24">
//             <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
//         </svg>`,
//         title: 'Success',
//         duration: 3000
//     },
//     error: {
//         icon: `<svg viewBox="0 0 24 24" width="24" height="24">
//             <path fill="currentColor" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
//         </svg>`,
//         title: 'Error',
//         duration: 3000
//     }
// };

// const toastContainer = document.getElementById('toast-container');
// const activeToasts = new Set();

// function createToast(type, message) {
//     const config = TOAST_CONFIGS[type];
//     const toast = document.createElement('div');
//     toast.className = `toast ${type}`;
    
//     toast.innerHTML = `
//         <div class="toast-icon">${config.icon}</div>
//         <div class="toast-content">
//             <h4>${config.title}</h4>
//             <p>${message}</p>
//         </div>
//         <button class="dismiss-btn" aria-label="Dismiss">
//             <svg viewBox="0 0 24 24" width="20" height="20">
//                 <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
//             </svg>
//         </button>
//         <div class="progress-bar"><div class="progress"></div></div>
//     `;

//     toast.querySelector('.dismiss-btn').addEventListener('click', () => {
//         dismissToast(toast);
//     });

//     return toast;
// }

// function dismissToast(toast) {
//     if (!activeToasts.has(toast)) return;

//     toast.classList.add('hide');
//     toast.addEventListener('animationend', () => {
//         toast.remove();
//         activeToasts.delete(toast);
//     });
// }

// function showToast(type, message) {
//     const toast = createToast(type, message);
//     toastContainer.appendChild(toast);
//     activeToasts.add(toast);

//     toast.offsetHeight;
//     toast.classList.add('show');

//     setTimeout(() => dismissToast(toast), TOAST_CONFIGS[type].duration);
// }







const TOAST_CONFIGS = {
    success: {
        icon: `<svg viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>`,
        title: 'Success',
        duration: 3000
    },
    error: {
        icon: `<svg viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
        </svg>`,
        title: 'Error',
        duration: 3000
    }
};

const $toastContainer = $('#toast-container');
const activeToasts = new Set();

function createToast(type, message) {
    const config = TOAST_CONFIGS[type];
    const $toast = $(`
        <div class="toast ${type}">
            <div class="toast-icon">${config.icon}</div>
            <div class="toast-content">
                <h4>${config.title}</h4>
                <p>${message}</p>
            </div>
            <button class="dismiss-btn" aria-label="Dismiss">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                </svg>
            </button>
            <div class="progress-bar"><div class="progress"></div></div>
        </div>
    `);

    $toast.find('.dismiss-btn').on('click', function () {
        dismissToast($toast);
    });

    return $toast;
}

function dismissToast($toast) {
    if (!activeToasts.has($toast)) return;

    $toast.addClass('hide').on('animationend', function () {
        $toast.remove();
        activeToasts.delete($toast);
    });
}

function showToast(type, message) {
    const $toast = createToast(type, message);
    $toastContainer.append($toast);
    activeToasts.add($toast);

    $toast[0].offsetHeight; 
    $toast.addClass('show');

    setTimeout(() => dismissToast($toast), TOAST_CONFIGS[type].duration);
}
