import './bootstrap';
import './topbar';
import './nav';
import { initDashboard } from './dashboard';
import toast from './toast';

// Initialize dashboard functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a dashboard page
    if (document.getElementById('sidebar')) {
        initDashboard();
    }
});

// Make toast available globally
window.toast = toast;