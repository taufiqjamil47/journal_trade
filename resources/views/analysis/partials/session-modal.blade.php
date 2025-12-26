<!-- Session-Time Heatmap Modal -->
<div id="sessionModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
    <div class="bg-gray-800 border border-gray-700 rounded-xl w-full max-w-2xl mx-auto max-h-[80vh] overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b border-gray-700">
            <h4 id="sessionModalTitle" class="text-lg font-bold text-primary-400">
                {{ __('analysis.modal.session_details') }}</h4>
            <button id="closeSessionModal" class="text-gray-400 hover:text-white transition-colors p-2">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div id="sessionModalContent" class="p-4 overflow-y-auto max-h-[60vh]">
            <!-- Content will be filled by JavaScript -->
        </div>
    </div>
</div>
