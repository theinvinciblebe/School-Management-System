<!-- PC Keyboard Shortcuts Modal -->
<div id="pcShortcutsModalOverlay" class="pc-shortcuts-overlay" onclick="handleShortcutsBackdropClick(event)">
    <div class="pc-shortcuts-box" role="dialog" aria-modal="true" aria-label="{{ __('Keyboard Shortcuts') }}">
        <div class="pc-shortcuts-header">
            <div class="d-flex align-items-center">
                <i class="fas fa-keyboard text-primary mr-2" style="font-size: 1.25rem;"></i>
                <h5 class="m-0 font-weight-bold" style="font-size: 1.05rem;">{{ __('PC Keyboard Shortcuts') }}</h5>
            </div>
            <button type="button" class="close text-muted" onclick="closePcShortcutsModal()" aria-label="Close" style="outline: none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="pc-shortcuts-body">
            <p class="text-muted mb-3" style="font-size: 0.85rem;">
                {{ __('Boost your administrative productivity with built-in desktop keyboard shortcuts.') }}
            </p>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Command Palette / Quick Search') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Search pages, students, classes, or actions') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Ctrl</kbd>
                    <span class="text-muted">+</span>
                    <kbd class="pc-shortcut-kbd">K</kbd>
                    <span class="text-muted">or</span>
                    <kbd class="pc-shortcut-kbd">/</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Toggle Sidebar (Maximize Screen)') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Give full desktop width to tables & charts') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Alt</kbd>
                    <span class="text-muted">+</span>
                    <kbd class="pc-shortcut-kbd">S</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Toggle Dark / Light Theme') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Instantly toggle interface color scheme') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Alt</kbd>
                    <span class="text-muted">+</span>
                    <kbd class="pc-shortcut-kbd">T</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Toggle Compact Table Density') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Fit 40% more records vertically on PC') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Alt</kbd>
                    <span class="text-muted">+</span>
                    <kbd class="pc-shortcut-kbd">C</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Jump to Dashboard') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Return to home overview immediately') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Alt</kbd>
                    <span class="text-muted">+</span>
                    <kbd class="pc-shortcut-kbd">D</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Toggle Fullscreen Mode') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Distraction-free desktop view') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Alt</kbd>
                    <span class="text-muted">+</span>
                    <kbd class="pc-shortcut-kbd">F</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Close Active Modal or Palette') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Dismiss popups or search overlay') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">Esc</kbd>
                </div>
            </div>

            <div class="pc-shortcut-row">
                <div>
                    <strong style="font-size: 0.88rem;">{{ __('Show Keyboard Shortcuts') }}</strong>
                    <div class="text-muted" style="font-size: 0.78rem;">{{ __('Open this reference dialog') }}</div>
                </div>
                <div class="pc-shortcut-keys">
                    <kbd class="pc-shortcut-kbd">?</kbd>
                </div>
            </div>
        </div>

        <div class="pc-palette-footer justify-content-end">
            <button type="button" class="btn btn-sm btn-primary px-3" onclick="closePcShortcutsModal()" style="border-radius: 8px;">
                {{ __('Got it!') }}
            </button>
        </div>
    </div>
</div>

<script>
    (function() {
        const overlay = document.getElementById('pcShortcutsModalOverlay');

        function openPcShortcutsModal() {
            if (overlay) overlay.style.display = 'flex';
        }

        function closePcShortcutsModal() {
            if (overlay) overlay.style.display = 'none';
        }

        function handleShortcutsBackdropClick(e) {
            if (e.target === overlay) closePcShortcutsModal();
        }

        window.openPcShortcutsModal = openPcShortcutsModal;
        window.closePcShortcutsModal = closePcShortcutsModal;
        window.handleShortcutsBackdropClick = handleShortcutsBackdropClick;
    })();
</script>

