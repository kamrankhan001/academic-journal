// Mobile drawer functionality
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobileMenuToggle');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const drawerPanel = document.getElementById('drawerPanel');
    const drawerOverlay = document.getElementById('drawerOverlay');
    const closeDrawerBtn = document.getElementById('closeDrawerBtn');
    
    if (!menuToggle || !mobileDrawer || !drawerPanel || !drawerOverlay) return;
    
    function openDrawer() {
        // Make drawer visible
        mobileDrawer.classList.remove('invisible');
        
        // Trigger reflow to ensure transition works
        void mobileDrawer.offsetWidth;
        
        // Animate in - using Tailwind classes
        drawerOverlay.classList.remove('opacity-0');
        drawerOverlay.classList.add('opacity-100');
        drawerPanel.classList.remove('translate-x-full');
        drawerPanel.classList.add('translate-x-0');
        
        // Prevent body scrolling
        document.body.classList.add('overflow-hidden');
    }
    
    function closeDrawer() {
        // Animate out - using Tailwind classes
        drawerOverlay.classList.remove('opacity-100');
        drawerOverlay.classList.add('opacity-0');
        drawerPanel.classList.remove('translate-x-0');
        drawerPanel.classList.add('translate-x-full');
        
        // After animation, hide drawer and restore scrolling
        setTimeout(() => {
            mobileDrawer.classList.add('invisible');
            document.body.classList.remove('overflow-hidden');
        }, 300); // Match the transition duration
    }
    
    // Open drawer when menu button is clicked
    menuToggle.addEventListener('click', openDrawer);
    
    // Close drawer when overlay is clicked
    drawerOverlay.addEventListener('click', closeDrawer);
    
    // Close drawer when close button is clicked
    if (closeDrawerBtn) {
        closeDrawerBtn.addEventListener('click', closeDrawer);
    }
    
    // Close drawer on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileDrawer.classList.contains('invisible')) {
            closeDrawer();
        }
    });
    
    // Prevent clicks inside drawer panel from closing the drawer
    drawerPanel.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Handle touch events to prevent scrolling when drawer is open
    mobileDrawer.addEventListener('touchmove', function(e) {
        if (!mobileDrawer.classList.contains('invisible')) {
            e.preventDefault();
        }
    }, { passive: false });
});