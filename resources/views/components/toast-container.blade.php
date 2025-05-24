<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <!-- Els toasts es generaran dinàmicament aquí -->
</div>

<script>
class ToastManager {
    constructor() {
        this.container = document.getElementById('toast-container');
        this.toastCounter = 0;
    }

    show(message, type = 'success', duration = 5000) {
        const toastId = `toast-${++this.toastCounter}`;
        const iconClass = this.getIconClass(type);
        const bgClass = this.getBgClass(type);
        
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center">
                        <i class="bi ${iconClass} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        this.container.insertAdjacentHTML('beforeend', toastHtml);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: duration
        });
        
        toast.show();
        
        // Eliminar l'element del DOM després que es tanqui
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
        
        return toast;
    }

    success(message, duration = 5000) {
        return this.show(message, 'success', duration);
    }

    error(message, duration = 7000) {
        return this.show(message, 'error', duration);
    }

    warning(message, duration = 6000) {
        return this.show(message, 'warning', duration);
    }

    info(message, duration = 5000) {
        return this.show(message, 'info', duration);
    }

    getIconClass(type) {
        const icons = {
            'success': 'bi-check-circle-fill',
            'error': 'bi-exclamation-triangle-fill',
            'warning': 'bi-exclamation-triangle-fill',
            'info': 'bi-info-circle-fill'
        };
        return icons[type] || icons['info'];
    }

    getBgClass(type) {
        const classes = {
            'success': 'bg-success',
            'error': 'bg-danger',
            'warning': 'bg-warning',
            'info': 'bg-info'
        };
        return classes[type] || classes['info'];
    }
}

// Instància global del ToastManager
window.toastManager = new ToastManager();

// Funcions globals per facilitar l'ús
window.showToast = (message, type, duration) => window.toastManager.show(message, type, duration);
window.showSuccess = (message, duration) => window.toastManager.success(message, duration);
window.showError = (message, duration) => window.toastManager.error(message, duration);
window.showWarning = (message, duration) => window.toastManager.warning(message, duration);
window.showInfo = (message, duration) => window.toastManager.info(message, duration);
</script>

<style>
.toast-container {
    max-width: 400px;
}

.toast {
    min-width: 300px;
    box-shadow: var(--shadow-lg);
    border-radius: var(--radius-md);
}

.toast-body {
    font-size: var(--font-size-sm);
    font-weight: 500;
}

/* Animacions personalitzades */
.toast.showing {
    animation: slideInRight 0.3s ease-out;
}

.toast.hide {
    animation: slideOutRight 0.3s ease-in;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>