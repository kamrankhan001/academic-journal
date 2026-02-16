// resources/js/dashboard.js

// Sidebar Toggle Functionality
export function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth < 1024) { // lg breakpoint
        sidebar.classList.toggle('-translate-x-full');
        if (overlay) {
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
    }
}

// Close sidebar when clicking on overlay
export function setupSidebarOverlay() {
    const overlay = document.getElementById('sidebarOverlay');
    const sidebar = document.getElementById('sidebar');
    
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }
}

// Handle window resize
export function setupResizeHandler() {
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            if (overlay) {
                overlay.classList.add('hidden');
            }
            document.body.classList.remove('overflow-hidden');
        }
    });
}

// Active link handling for nested routes
export function setActiveNavLinks(currentRoute) {
    if (currentRoute === 'author.submission.detail') {
        const submissionsLink = document.querySelector('a[href*="submissions"]');
        if (submissionsLink) {
            submissionsLink.classList.add('bg-[#86662c]/10', 'text-[#86662c]');
        }
    }
}

// Initialize all dashboard functionality
export function initDashboard() {
    setupSidebarOverlay();
    setupResizeHandler();
}

// Make toggleSidebar globally available for onclick attributes
window.toggleSidebar = toggleSidebar;