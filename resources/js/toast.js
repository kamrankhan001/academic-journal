class ToastManager {
    constructor() {
        this.container = null;
        this.toasts = new Set();
        this.init();
    }

    init() {
        // Create container if it doesn't exist
        if (!this.container) {
            this.container = document.getElementById('toastContainer');
            if (!this.container) {
                this.container = document.createElement('div');
                this.container.id = 'toastContainer';
                this.container.className = 'toast-container';
                document.body.appendChild(this.container);
            }
        }
    }

    show(message, type = 'info', duration = 5000) {
        this.init();
        const toast = this.createToast(message, type);
        this.container.appendChild(toast);
        this.toasts.add(toast);

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => this.remove(toast), duration);
        }

        return toast;
    }

    createToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        const icon = this.getIcon(type);
        
        toast.innerHTML = `
            <div class="toast-content">
                <span class="toast-icon">${icon}</span>
                <span class="toast-message">${this.escapeHtml(message)}</span>
            </div>
            <button class="toast-close" aria-label="Close">&times;</button>
        `;

        // Add click event to close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => this.remove(toast));

        return toast;
    }

    getIcon(type) {
        const icons = {
            success: '✓',
            error: '✗',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || icons.info;
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    remove(toast) {
        if (toast && toast.parentNode) {
            toast.classList.add('fade-out');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                    this.toasts.delete(toast);
                }
            }, 300);
        }
    }

    success(message, duration = 5000) {
        return this.show(message, 'success', duration);
    }

    error(message, duration = 5000) {
        return this.show(message, 'error', duration);
    }

    warning(message, duration = 5000) {
        return this.show(message, 'warning', duration);
    }

    info(message, duration = 5000) {
        return this.show(message, 'info', duration);
    }

    // Clear all toasts
    clearAll() {
        this.toasts.forEach(toast => this.remove(toast));
    }
}

// Create and export a single instance
const toast = new ToastManager();

// Function to check for and display session messages from Laravel
function displaySessionMessages() {
    // These will be populated by Laravel's blade
    const sessionMessages = {
        success: document.querySelector('meta[name="session-success"]')?.content,
        error: document.querySelector('meta[name="session-error"]')?.content,
        warning: document.querySelector('meta[name="session-warning"]')?.content,
        info: document.querySelector('meta[name="session-info"]')?.content,
        message: document.querySelector('meta[name="session-message"]')?.content
    };

    if (sessionMessages.success) {
        toast.success(sessionMessages.success);
    }
    if (sessionMessages.error) {
        toast.error(sessionMessages.error);
    }
    if (sessionMessages.warning) {
        toast.warning(sessionMessages.warning);
    }
    if (sessionMessages.info) {
        toast.info(sessionMessages.info);
    }
    if (sessionMessages.message) {
        toast.info(sessionMessages.message);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    displaySessionMessages();
});

// Export for use in other modules
export default toast;