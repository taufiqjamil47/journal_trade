// Chart Lazy Loading Manager
class ChartLoader {
    constructor() {
        this.charts = [];
        this.loadedCharts = new Map(); // Ubah ke Map untuk menyimpan instance chart
        this.chartInstances = new Map(); // Simpan instance chart
        this.isLoading = false;
        this.loadDelay = 300;

        this.chartPriority = [
            'hourlyChart',
            'pairChart',
            'entryTypeChart',
            'dayOfWeekChart',
            'monthlyChart'
        ];
    }

    init() {
        this.collectCharts();
        this.startLazyLoading();
        this.setupIntersectionObserver();
    }

    collectCharts() {
        this.chartPriority.forEach(chartId => {
            const canvas = document.getElementById(chartId);
            if (canvas) {
                this.charts.push({
                    id: chartId,
                    loadingId: `${chartId}Loading`,
                    containerId: `${chartId}Container`,
                    noDataId: `${chartId}NoData`,
                    canvas: canvas
                });
            }
        });
    }

    setupIntersectionObserver() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    const chartId = container.id.replace('Container', '');

                    if (!this.loadedCharts.has(chartId) && !this.isLoading) {
                        this.loadChart(chartId);
                    }
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });

        this.charts.forEach(chart => {
            const container = document.getElementById(chart.containerId);
            if (container) {
                observer.observe(container);
            }
        });
    }

    startLazyLoading() {
        if (this.charts.length > 0) {
            this.loadChart(this.charts[0].id);
        }
    }

    async loadChart(chartId) {
        if (this.loadedCharts.has(chartId) || this.isLoading) return;

        const chartInfo = this.charts.find(c => c.id === chartId);
        if (!chartInfo) return;

        this.isLoading = true;

        try {
            // Show loading state
            const loadingEl = document.getElementById(chartInfo.loadingId);
            const noDataEl = document.getElementById(chartInfo.noDataId);

            if (loadingEl) loadingEl.style.display = 'flex';
            if (noDataEl) noDataEl.style.display = 'none';
            chartInfo.canvas.style.display = 'none';

            // Check if chart already has data
            if (this.checkIfChartHasNoData(chartId)) {
                if (noDataEl) noDataEl.style.display = 'flex';
                if (loadingEl) loadingEl.style.display = 'none';
                this.loadedCharts.set(chartId, true);
                return;
            }

            // Small delay for better UX
            await new Promise(resolve => setTimeout(resolve, this.loadDelay));

            // Destroy previous chart instance if exists
            if (this.chartInstances.has(chartId)) {
                this.chartInstances.get(chartId).destroy();
                this.chartInstances.delete(chartId);
            }

            // Render the chart
            await this.renderChart(chartId);

            // Mark as loaded
            this.loadedCharts.set(chartId, true);

            // Hide loading, show chart
            if (loadingEl) loadingEl.style.display = 'none';
            chartInfo.canvas.style.display = 'block';

        } catch (error) {
            console.error(`Error loading chart ${chartId}:`, error);
            this.showChartError(chartInfo.loadingId);
        } finally {
            this.isLoading = false;
        }
    }

    checkIfChartHasNoData(chartId) {
        const data = window.analysisData || {};

        switch (chartId) {
            case 'hourlyChart':
                const hourlyData = data.hourlyPerformance || {};
                const hourlyValues = Object.values(hourlyData);
                return hourlyValues.length === 0 || hourlyValues.every(d => d.profit === 0);

            case 'pairChart':
                const pairData = data.pairData || {};
                return Object.keys(pairData).length === 0;

            case 'entryTypeChart':
                const entryData = data.entryTypeData || {};
                return Object.keys(entryData).length === 0;

            case 'dayOfWeekChart':
                const dowData = data.dayOfWeekPerformance || [];
                return dowData.length === 0;

            case 'monthlyChart':
                const monthlyData = data.monthlyPerformance || [];
                return monthlyData.length === 0;

            default:
                return false;
        }
    }

    showChartError(loadingId) {
        const loadingEl = document.getElementById(loadingId);
        if (loadingEl) {
            loadingEl.innerHTML = `
                <div class="text-red-400 text-center">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>Failed to load chart</p>
                </div>
            `;
        }
    }

    async renderChart(chartId) {
        return new Promise((resolve, reject) => {
            try {
                switch (chartId) {
                    case 'hourlyChart':
                        this.renderHourlyChart();
                        break;
                    case 'pairChart':
                        this.renderPairChart();
                        break;
                    case 'entryTypeChart':
                        this.renderEntryTypeChart();
                        break;
                    case 'dayOfWeekChart':
                        this.renderDayOfWeekChart();
                        break;
                    case 'monthlyChart':
                        this.renderMonthlyChart();
                        break;
                }
                resolve();
            } catch (error) {
                reject(error);
            }
        });
    }

    renderHourlyChart() {
        const ctx = document.getElementById('hourlyChart');
        if (!ctx) return;

        const data = window.analysisData?.hourlyPerformance || {};
        const labels = Object.keys(data).sort((a, b) => parseInt(a) - parseInt(b));

        if (labels.length === 0) return;

        const profits = labels.map(hour => data[hour]?.profit || 0);
        const trades = labels.map(hour => data[hour]?.trades || 0);

        const formattedLabels = labels.map(hour => {
            const hourNum = parseInt(hour);
            const nextHour = (hourNum + 1) % 24;
            return `${hour.toString().padStart(2, '0')}:00-${nextHour.toString().padStart(2, '0')}:00`;
        });

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: formattedLabels,
                datasets: [{
                    label: 'Profit',
                    data: profits,
                    backgroundColor: profits.map(p =>
                        p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                    ),
                    borderColor: profits.map(p =>
                        p >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                    ),
                    borderWidth: 1,
                    borderRadius: 4,
                    yAxisID: 'y',
                }, {
                    label: 'Trades',
                    data: trades,
                    type: 'line',
                    borderColor: 'rgba(59, 130, 246, 0.8)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1',
                }]
            },
            options: this.getChartOptions('hourly')
        });

        this.chartInstances.set('hourlyChart', chart);
    }

    renderPairChart() {
        const ctx = document.getElementById('pairChart');
        if (!ctx) return;

        const data = window.analysisData?.pairData || {};
        const labels = Object.keys(data);
        const values = Object.values(data);

        if (labels.length === 0) return;

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit/Loss',
                    data: values,
                    backgroundColor: values.map(v =>
                        v >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                    ),
                    borderColor: values.map(v =>
                        v >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                    ),
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: this.getChartOptions('pair')
        });

        this.chartInstances.set('pairChart', chart);
    }

    renderEntryTypeChart() {
        const ctx = document.getElementById('entryTypeChart');
        if (!ctx) return;

        const data = window.analysisData?.entryTypeData || {};
        const labels = Object.keys(data);
        const values = labels.map(label => data[label]?.profit_loss || 0);

        if (labels.length === 0) return;

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit/Loss',
                    data: values,
                    backgroundColor: values.map(v =>
                        v >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                    ),
                    borderColor: values.map(v =>
                        v >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                    ),
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: this.getChartOptions('entryType')
        });

        this.chartInstances.set('entryTypeChart', chart);
    }

    renderDayOfWeekChart() {
        const ctx = document.getElementById('dayOfWeekChart');
        if (!ctx) return;

        const data = window.analysisData?.dayOfWeekPerformance || [];
        const sortedData = data.sort((a, b) => a.day_number - b.day_number);

        const labels = sortedData.map(d => d.short_name);
        const profits = sortedData.map(d => d.profit);

        if (labels.length === 0) return;

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit',
                    data: profits,
                    backgroundColor: profits.map(p =>
                        p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                    ),
                    borderColor: profits.map(p =>
                        p >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                    ),
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: this.getChartOptions('dayOfWeek')
        });

        this.chartInstances.set('dayOfWeekChart', chart);
    }

    renderMonthlyChart() {
        const ctx = document.getElementById('monthlyChart');
        if (!ctx) return;

        const data = window.analysisData?.monthlyPerformance || [];
        const sortedData = data.sort((a, b) => {
            // Sort by year and month
            const [yearA, monthA] = a.month_key?.split('-') || [0, 0];
            const [yearB, monthB] = b.month_key?.split('-') || [0, 0];
            return yearA - yearB || monthA - monthB;
        });

        const labels = sortedData.map(m => m.month_name);
        const profits = sortedData.map(m => m.profit);

        if (labels.length === 0) return;

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Profit',
                    data: profits,
                    borderColor: 'rgba(139, 92, 246, 0.8)',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: this.getChartOptions('monthly')
        });

        this.chartInstances.set('monthlyChart', chart);
    }

    getChartOptions(type) {
        const baseOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            },
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(31, 41, 55, 0.9)',
                    titleColor: '#f3f4f6',
                    bodyColor: '#f3f4f6',
                    borderColor: 'rgba(75, 85, 99, 0.5)',
                    borderWidth: 1
                },
                legend: {
                    labels: {
                        color: '#9ca3af'
                    }
                }
            }
        };

        switch (type) {
            case 'hourly':
                return {
                    ...baseOptions,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        x: {
                            grid: { color: 'rgba(75, 85, 99, 0.3)' },
                            ticks: { color: '#9ca3af', maxRotation: 45 }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: 'rgba(75, 85, 99, 0.3)' },
                            ticks: {
                                color: '#9ca3af',
                                callback: function (value) {
                                    return '$' + value;
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { color: '#9ca3af' }
                        }
                    }
                };
            case 'pair':
            case 'entryType':
            case 'dayOfWeek':
                return {
                    ...baseOptions,
                    plugins: {
                        ...baseOptions.plugins,
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            grid: { color: 'rgba(75, 85, 99, 0.3)' },
                            ticks: {
                                color: '#9ca3af',
                                callback: function (value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                };
            case 'monthly':
                return {
                    ...baseOptions,
                    scales: {
                        x: {
                            grid: { color: 'rgba(75, 85, 99, 0.3)' },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            grid: { color: 'rgba(75, 85, 99, 0.3)' },
                            ticks: {
                                color: '#9ca3af',
                                callback: function (value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                };
            default:
                return baseOptions;
        }
    }

    // Clean up method untuk destroy semua charts
    destroyAllCharts() {
        this.chartInstances.forEach((chart, chartId) => {
            chart.destroy();
        });
        this.chartInstances.clear();
        this.loadedCharts.clear();
    }
}

// Export untuk penggunaan global
if (typeof window !== 'undefined') {
    window.ChartLoader = ChartLoader;
}