import './bootstrap';
import './topbar';
import './nav';
import { initDashboard } from './dashboard';

// Initialize dashboard functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a dashboard page
    if (document.getElementById('sidebar')) {
        initDashboard();
    }
});