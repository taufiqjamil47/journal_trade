// Main Analysis Page Functionality
class AnalysisPage {
    constructor() {
        this.chartLoader = null;
        this.sessionModal = null;
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.setupNavigationToggle();
            this.setupBalanceToggle();
            this.setupRiskDetailsToggle();
            this.setupHeatmapToggle();
            this.setupStatsAnimations();
            this.initializeCharts();
            this.initializeSessionModal();

            // Clean up on page unload
            window.addEventListener('beforeunload', () => this.cleanup());
        });
    }

    initializeCharts() {
        if (window.ChartLoader && window.analysisData) {
            this.chartLoader = new ChartLoader();
            this.chartLoader.init();
        } else {
            console.warn('ChartLoader or analysisData not available');
        }
    }

    initializeSessionModal() {
        if (window.SessionModal) {
            this.sessionModal = new SessionModal();
        }
    }

    setupNavigationToggle() {
        const navToggle = document.getElementById('navToggle');
        const navItems = document.getElementById('navItems');
        const navToggleIcon = document.getElementById('navToggleIcon');

        if (navToggle && navItems) {
            navToggle.addEventListener('click', function () {
                navItems.classList.toggle('hidden');
                if (navToggleIcon) {
                    if (navItems.classList.contains('hidden')) {
                        navToggleIcon.classList.remove('fa-chevron-left');
                        navToggleIcon.classList.add('fa-chevron-right');
                    } else {
                        navToggleIcon.classList.remove('fa-chevron-right');
                        navToggleIcon.classList.add('fa-chevron-left');
                    }
                }
            });
        }
    }

    setupBalanceToggle() {
        const toggleBalanceBtn = document.getElementById('toggleBalance');
        const balanceText = document.getElementById('balanceText');
        const balanceValue = document.getElementById('balanceValue');
        const balanceIcon = document.getElementById('balanceIcon');

        if (!toggleBalanceBtn || !balanceText || !balanceValue || !balanceIcon) return;

        // Load state from localStorage
        const isVisible = localStorage.getItem('balanceVisible') === 'true';

        // Apply saved state
        if (isVisible) {
            this.showBalanceValues();
        } else {
            this.hideBalanceValues();
        }

        // Toggle function
        toggleBalanceBtn.addEventListener('click', () => {
            if (balanceText.classList.contains('hidden')) {
                this.hideBalanceValues();
            } else {
                this.showBalanceValues();
            }
        });

        // Keyboard shortcut
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && (e.key === 'b' || e.key === 'B')) {
                e.preventDefault();
                toggleBalanceBtn.click();
            }
        });
    }

    showBalanceValues() {
        const balanceText = document.getElementById('balanceText');
        const balanceValue = document.getElementById('balanceValue');
        const balanceIcon = document.getElementById('balanceIcon');
        const toggleBalanceBtn = document.getElementById('toggleBalance');

        if (balanceText) balanceText.classList.add('hidden');
        if (balanceValue) balanceValue.classList.remove('hidden');
        if (balanceIcon) {
            balanceIcon.classList.remove('fa-eye-slash');
            balanceIcon.classList.add('fa-eye');
        }
        localStorage.setItem('balanceVisible', 'true');
        if (toggleBalanceBtn) toggleBalanceBtn.title = "Hide Balance";
    }

    hideBalanceValues() {
        const balanceText = document.getElementById('balanceText');
        const balanceValue = document.getElementById('balanceValue');
        const balanceIcon = document.getElementById('balanceIcon');
        const toggleBalanceBtn = document.getElementById('toggleBalance');

        if (balanceText) balanceText.classList.remove('hidden');
        if (balanceValue) balanceValue.classList.add('hidden');
        if (balanceIcon) {
            balanceIcon.classList.remove('fa-eye');
            balanceIcon.classList.add('fa-eye-slash');
        }
        localStorage.setItem('balanceVisible', 'false');
        if (toggleBalanceBtn) toggleBalanceBtn.title = "Show Balance";
    }

    setupRiskDetailsToggle() {
        const toggleRiskDetails = document.getElementById('toggleRiskDetails');
        const riskDetails = document.getElementById('riskDetails');
        const toggleRiskIcon = toggleRiskDetails?.querySelector('i');

        if (toggleRiskDetails && riskDetails) {
            toggleRiskDetails.addEventListener('click', function () {
                riskDetails.classList.toggle('hidden');
                if (toggleRiskIcon) {
                    if (riskDetails.classList.contains('hidden')) {
                        toggleRiskIcon.classList.remove('fa-chevron-up');
                        toggleRiskIcon.classList.add('fa-chevron-down');
                        toggleRiskDetails.querySelector('span').textContent = 'Show Details';
                    } else {
                        toggleRiskIcon.classList.remove('fa-chevron-down');
                        toggleRiskIcon.classList.add('fa-chevron-up');
                        toggleRiskDetails.querySelector('span').textContent = 'Hide Details';
                    }
                }
            });
        }
    }

    setupHeatmapToggle() {
        const toggleHeatmap = document.getElementById('toggleHeatmap');
        if (toggleHeatmap) {
            toggleHeatmap.addEventListener('click', function () {
                const heatmapContainer = document.getElementById('heatmapContainer');
                if (heatmapContainer) {
                    heatmapContainer.classList.toggle('max-h-96');
                    heatmapContainer.classList.toggle('overflow-y-auto');

                    const icon = toggleHeatmap.querySelector('i');
                    if (icon) {
                        if (heatmapContainer.classList.contains('max-h-96')) {
                            icon.classList.remove('fa-compress');
                            icon.classList.add('fa-expand');
                        } else {
                            icon.classList.remove('fa-expand');
                            icon.classList.add('fa-compress');
                        }
                    }
                }
            });
        }
    }

    setupStatsAnimations() {
        // Animate number counters
        const animateCounter = (element, start, end, duration) => {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                element.textContent = this.formatNumber(value);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        };

        // Animate stats on scroll into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stat = entry.target;
                    const value = parseFloat(stat.textContent.replace(/[^0-9.-]+/g, ""));
                    if (!isNaN(value)) {
                        animateCounter(stat, 0, value, 1000);
                    }
                    observer.unobserve(stat);
                }
            });
        }, { threshold: 0.5 });

        // Observe all stat numbers
        document.querySelectorAll('.stat-number').forEach(stat => {
            observer.observe(stat);
        });
    }

    formatNumber(num) {
        if (num >= 1000) {
            return '$' + (num / 1000).toFixed(1) + 'k';
        }
        return '$' + num.toFixed(2);
    }

    cleanup() {
        if (this.chartLoader) {
            this.chartLoader.destroyAllCharts();
        }
    }
}

// Debugging helper
if (typeof window !== 'undefined') {
    window.debugAnalysis = {
        checkCharts: () => {
            console.log('Available Charts:', window.chartLoader?.charts);
            console.log('Loaded Charts:', window.chartLoader?.loadedCharts);
            console.log('Chart Instances:', window.chartLoader?.chartInstances);
            console.log('Analysis Data:', window.analysisData);
        },

        reloadChart: (chartId) => {
            if (window.chartLoader) {
                window.chartLoader.loadedCharts.delete(chartId);
                const chartInstance = window.chartLoader.chartInstances.get(chartId);
                if (chartInstance) {
                    chartInstance.destroy();
                    window.chartLoader.chartInstances.delete(chartId);
                }
                window.chartLoader.loadChart(chartId);
            }
        },

        reloadAllCharts: () => {
            if (window.chartLoader) {
                window.chartLoader.destroyAllCharts();
                window.chartLoader.charts.forEach(chart => {
                    window.chartLoader.loadedCharts.delete(chart.id);
                });
                window.chartLoader.init();
            }
        }
    };
}

// Initialize Analysis Page
if (typeof window !== 'undefined') {
    window.analysisPage = new AnalysisPage();
}

