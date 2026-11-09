/**
 * POSMA PREDATECH - Interactive AlpineJS & Vanilla UI Helpers
 * Loaded on all pages for rich animations, onscroll effects, dynamic counters, and live search
 */

document.addEventListener('DOMContentLoaded', () => {
    // Scroll progress bar
    const progressBar = document.getElementById('scrollProgressBar');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + '%';
        });
    }

    // Scroll Reveal Observer
    const revealElements = document.querySelectorAll('.reveal-on-scroll');
    if ('IntersectionObserver' in window && revealElements.length > 0) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                    obs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(el => {
            el.classList.add('transition-all', 'duration-700', 'ease-out', 'opacity-0', 'translate-y-10');
            observer.observe(el);
        });
    }
});

// Alpine Component for Animated Number Counter
function animatedCounter(target, duration = 1200) {
    return {
        current: 0,
        target: parseInt(target, 10) || 0,
        init() {
            let start = 0;
            const stepTime = 20;
            const steps = Math.max(Math.floor(duration / stepTime), 1);
            const increment = this.target / steps;
            
            const timer = setInterval(() => {
                start += increment;
                if (start >= this.target) {
                    this.current = this.target;
                    clearInterval(timer);
                } else {
                    this.current = Math.floor(start);
                }
            }, stepTime);
        }
    };
}

// Alpine Component for Hero Live Search
function posmaSearch(baseUrl) {
    return {
        category: 'Anggota', // 'Anggota' or 'Karya'
        keyword: '',
        isLoading: false,
        results: [],
        showDropdown: false,

        setCategory(cat) {
            this.category = cat;
            if (this.keyword.length >= 2) {
                this.performSearch();
            }
        },

        async performSearch() {
            if (this.keyword.trim().length < 2) {
                this.results = [];
                this.showDropdown = false;
                return;
            }

            this.isLoading = true;
            try {
                const response = await fetch(`${baseUrl}api/search?type=${encodeURIComponent(this.category)}&q=${encodeURIComponent(this.keyword)}`);
                const data = await response.json();
                this.results = data.data || [];
                this.showDropdown = true;
            } catch (err) {
                console.error('Search error:', err);
            } finally {
                this.isLoading = false;
            }
        },

        closeDropdown() {
            setTimeout(() => {
                this.showDropdown = false;
            }, 250);
        }
    };
}
