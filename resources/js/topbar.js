// Topbar functionality - Search toggle and social icons hover effect

document.addEventListener('DOMContentLoaded', function() {
    // Get home route from data attribute
    const topbarElement = document.querySelector('[data-home-route]');
    const homeRoute = topbarElement?.dataset.homeRoute || '/';
    
    // Journal route for search
    const journalRoute = '/journals'; // or use route('journals') if passed from Blade
    
    // Desktop Search Toggle with smooth transition
    const desktopToggle = document.getElementById('desktopSearchToggle');
    const desktopSearchContainer = document.getElementById('desktopSearchContainer');
    const desktopSearchInput = document.getElementById('desktopSearchInput');
    
    // Check if there's an active search query
    const searchInputs = document.querySelectorAll('input[name="search"]');
    let hasActiveSearch = false;
    searchInputs.forEach(input => {
        if (input.value && input.value.length > 0) {
            hasActiveSearch = true;
        }
    });
    
    if (desktopToggle && desktopSearchContainer) {
        // If there's an active search, expand the search box on page load
        if (hasActiveSearch) {
            desktopSearchContainer.classList.remove('w-0', 'opacity-0');
            desktopSearchContainer.classList.add('w-64', 'opacity-100');
        }
        
        desktopToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle classes for smooth animation
            if (desktopSearchContainer.classList.contains('w-0')) {
                // Open search
                desktopSearchContainer.classList.remove('w-0', 'opacity-0');
                desktopSearchContainer.classList.add('w-64', 'opacity-100');
                
                // Focus the input after animation completes
                setTimeout(() => {
                    if (desktopSearchInput) {
                        desktopSearchInput.focus();
                    }
                }, 300);
            } else {
                // Only close if there's no active search
                if (!hasActiveSearch) {
                    desktopSearchContainer.classList.remove('w-64', 'opacity-100');
                    desktopSearchContainer.classList.add('w-0', 'opacity-0');
                    
                    // Blur the input
                    if (desktopSearchInput) {
                        desktopSearchInput.blur();
                    }
                }
            }
        });

        // Submit form on Enter key
        if (desktopSearchInput) {
            desktopSearchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('desktopSearchForm').submit();
                }
            });
        }

        // Close search when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = desktopToggle.contains(event.target) || 
                                 desktopSearchContainer.contains(event.target);
            
            if (!isClickInside && !desktopSearchContainer.classList.contains('w-0') && !hasActiveSearch) {
                desktopSearchContainer.classList.remove('w-64', 'opacity-100');
                desktopSearchContainer.classList.add('w-0', 'opacity-0');
                
                if (desktopSearchInput) {
                    desktopSearchInput.blur();
                }
            }
        });

        // Close search on Escape key
        if (desktopSearchInput) {
            desktopSearchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !hasActiveSearch) {
                    desktopSearchContainer.classList.remove('w-64', 'opacity-100');
                    desktopSearchContainer.classList.add('w-0', 'opacity-0');
                    this.blur();
                }
            });
        }
    }

    // Handle clear search buttons - redirect to journals page without search query
    const clearButtons = document.querySelectorAll('.clear-search');
    clearButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Redirect to journals page without search parameter
            window.location.href = journalRoute;
        });
    });

    // Social Icons Hover Effect - Change Background Color
    const socialIcons = document.querySelectorAll('.social-icon');
    
    socialIcons.forEach(icon => {
        const brandColor = icon.getAttribute('data-color');
        
        icon.addEventListener('mouseenter', function() {
            this.style.backgroundColor = brandColor;
            // For Snapchat (yellow), keep text dark for contrast
            if (brandColor === '#fffc00') {
                this.style.color = '#000000';
            } else {
                this.style.color = '#ffffff';
            }
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.color = '';
        });
    });
});