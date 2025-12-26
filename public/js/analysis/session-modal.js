// Session Heatmap Modal Functionality
class SessionModal {
    constructor() {
        this.modal = document.getElementById('sessionModal');
        this.modalTitle = document.getElementById('sessionModalTitle');
        this.modalContent = document.getElementById('sessionModalContent');
        this.closeBtn = document.getElementById('closeSessionModal');

        // Get translations
        this.translations = window.translations?.analysis || {};

        this.init();
    }

    init() {
        if (!this.modal) return;

        this.setupHeatmapClickHandlers();
        this.setupCloseHandlers();
    }

    setupHeatmapClickHandlers() {
        document.querySelectorAll('#heatmapContainer [data-trades]').forEach(cell => {
            cell.addEventListener('click', (e) => this.handleHeatmapClick(e));
        });
    }

    handleHeatmapClick(event) {
        const cell = event.currentTarget;
        const hour = cell.getAttribute('data-hour');
        const day = parseInt(cell.getAttribute('data-day'));
        const profit = parseFloat(cell.getAttribute('data-profit'));
        const trades = parseInt(cell.getAttribute('data-trades'));

        if (trades > 0) {
            this.showModal(day, hour, profit, trades);
        }
    }

    getDayName(dayIndex) {
        const days = this.translations.days || {
            Mon: 'Monday', Tue: 'Tuesday', Wed: 'Wednesday',
            Thu: 'Thursday', Fri: 'Friday', Sat: 'Saturday', Sun: 'Sunday'
        };

        const dayKeys = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        return days[dayKeys[dayIndex]] || 'Unknown';
    }

    getHourRange(hour) {
        const startHour = hour.padStart(2, '0');
        const endHour = String((parseInt(hour) + 1) % 24).padStart(2, '0');
        return `${startHour}:00-${endHour}:00`;
    }

    showModal(dayIndex, hour, profit, trades) {
        const dayName = this.getDayName(dayIndex);
        const hourRange = this.getHourRange(hour);
        const avgPlPerTrade = (profit / trades).toFixed(2);

        // Set modal title
        this.modalTitle.textContent = `${dayName}, ${hourRange}`;

        // Get translations
        const t = this.translations.modal || {};
        const tStats = this.translations.stats || {};
        const tTime = this.translations.time_analysis || {};

        // Create modal content
        this.modalContent.innerHTML = `
            <div class="mb-4 p-3 rounded-lg ${profit > 0 ? 'bg-green-500/10 border border-green-500/30' : profit < 0 ? 'bg-red-500/10 border border-red-500/30' : 'bg-gray-700/50 border border-gray-600'}">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <div class="text-sm text-gray-400">${t.total_performance || 'Total Performance'}</div>
                        <div class="text-2xl font-bold ${profit > 0 ? 'text-green-400' : profit < 0 ? 'text-red-400' : 'text-gray-400'}">
                            $${profit.toFixed(2)}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-400">${t.total_trades || 'Total Trades'}</div>
                        <div class="text-2xl font-bold text-gray-200">${trades}</div>
                    </div>
                </div>
                <div class="mt-2 pt-2 border-t border-gray-600">
                    <div class="text-xs text-gray-400">${t.time_slot || 'Time Slot'}</div>
                    <div class="text-sm text-gray-300">${hourRange} (GMT)</div>
                </div>
            </div>
            
            <div class="mb-4">
                <h5 class="text-sm font-medium text-gray-300 mb-2">${t.performance_insights || 'Performance Insights'}</h5>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-750 rounded-lg p-3">
                        <div class="text-xs text-gray-400">${t.avg_pl_per_trade || 'Avg P/L per Trade'}</div>
                        <div class="text-lg font-bold ${avgPlPerTrade >= 0 ? 'text-green-400' : 'text-red-400'}">
                            $${avgPlPerTrade}
                        </div>
                    </div>
                    <div class="bg-gray-750 rounded-lg p-3">
                        <div class="text-xs text-gray-400">${t.win_loss_ratio || 'Win/Loss Ratio'}</div>
                        <div class="text-lg font-bold text-gray-200">
                            ${profit > 0 ? (t.profitable || 'Profitable') : (t.unprofitable || 'Unprofitable')}
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <h5 class="text-sm font-medium text-gray-300 mb-2">${t.recommendations || 'Recommendations'}</h5>
                <div class="bg-gray-900/50 rounded-lg p-3 border border-gray-700">
                    <div class="flex items-start gap-2">
                        <i class="fas ${profit > 0 ? 'fa-thumbs-up text-green-500' : 'fa-thumbs-down text-red-500'} mt-0.5"></i>
                        <div>
                            <p class="text-sm text-gray-300">
                                ${profit > 0
                ? (t.positive_recommendation || 'This time slot shows positive performance. Consider increasing trading activity during this period.')
                : (t.negative_recommendation || 'This time slot shows negative performance. Consider reducing or avoiding trading during this period.')}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                ${t.based_on || 'Based on'} ${trades} ${tStats.trades || 'trade'}${trades !== 1 ? 's' : ''} ${t.at_this_time || 'at this time'}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-700">
                <p class="text-xs text-gray-400 text-center">
                    <i class="fas fa-lightbulb mr-1"></i>
                    ${t.click_other_slots || 'Click on other time slots to see their performance'}
                </p>
            </div>
        `;

        this.modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    setupCloseHandlers() {
        // Close button
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.closeModal());
        }

        // Close on outside click
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });

        // Close with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                this.closeModal();
            }
        });
    }

    closeModal() {
        this.modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    window.sessionModal = new SessionModal();
});