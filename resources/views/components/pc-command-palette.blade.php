<!-- PC Command Palette (Spotlight / Raycast style for desktop efficiency) -->
<div id="pcCommandPaletteOverlay" class="pc-palette-overlay" onclick="handlePaletteBackdropClick(event)">
    <div class="pc-palette-box" role="dialog" aria-modal="true" aria-label="{{ __('Command Palette') }}">
        <!-- Search Input Header -->
        <div class="pc-palette-search-wrapper">
            <i class="fas fa-search text-muted mr-1" style="font-size: 1.1rem;"></i>
            <input type="text" 
                   id="pcPaletteInput" 
                   class="pc-palette-input" 
                   placeholder="{{ __('Type a command or jump to page... (or Esc to close)') }}" 
                   autocomplete="off"
                   spellcheck="false">
            <kbd class="pc-kbd-badge" style="cursor: pointer;" onclick="closePcCommandPalette()">ESC</kbd>
        </div>

        <!-- Filterable Commands & Navigation Items -->
        <div id="pcPaletteList" class="pc-palette-list">
            <!-- Navigation Section -->
            <div class="pc-palette-group-title">{{ __('Navigation & Academic') }}</div>

            <a href="/dashboard" class="pc-palette-item" data-keywords="dashboard home overview statistics metrics stats">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon"><i class="fas fa-chart-pie"></i></div>
                    <span class="pc-palette-item-text">{{ __('Dashboard') }}</span>
                </div>
                <kbd class="pc-palette-item-shortcut">Alt + D</kbd>
            </a>

            <a href="/students" class="pc-palette-item" data-keywords="students student list directory enroll pupils">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(99, 102, 241, 0.15); color: #6366f1;"><i class="fas fa-user-graduate"></i></div>
                    <span class="pc-palette-item-text">{{ __('Students Directory') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/students</span>
            </a>

            <a href="/students/create" class="pc-palette-item" data-keywords="enroll student add admission new">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;"><i class="fas fa-user-plus"></i></div>
                    <span class="pc-palette-item-text">{{ __('Enroll New Student') }}</span>
                </div>
                <span class="badge badge-success px-2 py-1" style="font-size: 0.72rem;">{{ __('Add') }}</span>
            </a>

            <a href="{{ !empty($defaultClassId) ? route('attendance.show', $defaultClassId) : '/attendance/class/62' }}" class="pc-palette-item" data-keywords="attendance student daily roll call present absent">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(14, 165, 233, 0.15); color: #0ea5e9;"><i class="fas fa-user-check"></i></div>
                    <span class="pc-palette-item-text">{{ __('Student Attendance') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/attendance</span>
            </a>

            <a href="/staff/attendance" class="pc-palette-item" data-keywords="staff attendance teacher employee instructors roll call">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;"><i class="fas fa-clipboard-check"></i></div>
                    <span class="pc-palette-item-text">{{ __('Staff Attendance') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/staff/attendance</span>
            </a>

            <a href="/teachers" class="pc-palette-item" data-keywords="teachers faculty instructor educator staff">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;"><i class="fas fa-chalkboard-teacher"></i></div>
                    <span class="pc-palette-item-text">{{ __('Teachers & Faculty') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/teachers</span>
            </a>

            <a href="/class" class="pc-palette-item" data-keywords="classes class grade sections room">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(236, 72, 153, 0.15); color: #ec4899;"><i class="fas fa-school"></i></div>
                    <span class="pc-palette-item-text">{{ __('Classes & Grades') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/class</span>
            </a>

            <a href="/class-routines" class="pc-palette-item" data-keywords="class routine timetable schedule period lesson hours">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;"><i class="fas fa-calendar-alt"></i></div>
                    <span class="pc-palette-item-text">{{ __('Class Routine & Timetable') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/class-routines</span>
            </a>

            <a href="/classes-subject" class="pc-palette-item" data-keywords="subjects curriculum course syllabus book learning">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(20, 184, 166, 0.15); color: #14b8a6;"><i class="fas fa-book-open"></i></div>
                    <span class="pc-palette-item-text">{{ __('Subject Management') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/classes-subject</span>
            </a>

            <a href="/departments" class="pc-palette-item" data-keywords="departments department organization division faculty">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(100, 116, 139, 0.15); color: #64748b;"><i class="fas fa-building"></i></div>
                    <span class="pc-palette-item-text">{{ __('Departments') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/departments</span>
            </a>

            <!-- Financials & Administration Section -->
            <div class="pc-palette-group-title">{{ __('Finance & Administration') }}</div>

            <a href="/profit" class="pc-palette-item" data-keywords="profit financials accounting revenue expense cash flow ledger balance">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;"><i class="fas fa-chart-line"></i></div>
                    <span class="pc-palette-item-text">{{ __('Financial Reports & Profit') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/profit</span>
            </a>

            <a href="/fee_receipt" class="pc-palette-item" data-keywords="fee receipt tuition billing invoice payment student fee">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;"><i class="fas fa-file-invoice-dollar"></i></div>
                    <span class="pc-palette-item-text">{{ __('Fee Receipts & Invoices') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/fee_receipt</span>
            </a>

            <a href="/purchase_req" class="pc-palette-item" data-keywords="purchase request requisition procurement orders supply expense">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;"><i class="fas fa-shopping-cart"></i></div>
                    <span class="pc-palette-item-text">{{ __('Purchase Requests') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/purchase_req</span>
            </a>

            <a href="/user-management" class="pc-palette-item" data-keywords="users accounts permissions roles security authentication">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(99, 102, 241, 0.15); color: #6366f1;"><i class="fas fa-user-shield"></i></div>
                    <span class="pc-palette-item-text">{{ __('User Access Management') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/user-management</span>
            </a>

            <a href="/user-profile" class="pc-palette-item" data-keywords="profile my account password settings photo avatar name">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(14, 165, 233, 0.15); color: #0ea5e9;"><i class="fas fa-user-circle"></i></div>
                    <span class="pc-palette-item-text">{{ __('My Profile') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/user-profile</span>
            </a>

            <a href="/customize" class="pc-palette-item" data-keywords="customize settings theme color logo branding appearance">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(244, 63, 94, 0.15); color: #f43f5e;"><i class="fas fa-sliders-h"></i></div>
                    <span class="pc-palette-item-text">{{ __('System Customization') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/customize</span>
            </a>

            <a href="/inbox" class="pc-palette-item" data-keywords="inbox messages requests notifications approvals mail">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;"><i class="fas fa-inbox"></i></div>
                    <span class="pc-palette-item-text">{{ __('Inbox & Approvals') }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.78rem;">/inbox</span>
            </a>

            <!-- Quick Desktop Actions Section -->
            <div class="pc-palette-group-title">{{ __('Quick Actions') }}</div>

            <div class="pc-palette-item" data-action="toggleTheme" data-keywords="dark mode light mode theme toggle switch color night day">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;"><i class="fas fa-adjust"></i></div>
                    <span class="pc-palette-item-text">{{ __('Toggle Dark / Light Theme') }}</span>
                </div>
                <kbd class="pc-palette-item-shortcut">Alt + T</kbd>
            </div>

            <div class="pc-palette-item" data-action="togglePcCompactMode" data-keywords="compact mode density table spacing comfortable dense">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;"><i class="fas fa-compress-arrows-alt"></i></div>
                    <span class="pc-palette-item-text">{{ __('Toggle Compact Table Density') }}</span>
                </div>
                <kbd class="pc-palette-item-shortcut">Alt + C</kbd>
            </div>

            <div class="pc-palette-item" data-action="toggleSidebar" data-keywords="sidebar menu collapse expand toggle fullscreen screen width">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(99, 102, 241, 0.15); color: #6366f1;"><i class="fas fa-columns"></i></div>
                    <span class="pc-palette-item-text">{{ __('Toggle Sidebar (Maximize Screen)') }}</span>
                </div>
                <kbd class="pc-palette-item-shortcut">Alt + S</kbd>
            </div>

            <div class="pc-palette-item" data-action="toggleFullscreen" data-keywords="fullscreen full screen expand monitor f11">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(14, 165, 233, 0.15); color: #0ea5e9;"><i class="fas fa-expand"></i></div>
                    <span class="pc-palette-item-text">{{ __('Toggle Fullscreen') }}</span>
                </div>
                <kbd class="pc-palette-item-shortcut">Alt + F</kbd>
            </div>

            <div class="pc-palette-item" data-action="openPcShortcutsModal" data-keywords="shortcuts hotkeys cheat sheet keyboard help commands">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(100, 116, 139, 0.15); color: #64748b;"><i class="fas fa-keyboard"></i></div>
                    <span class="pc-palette-item-text">{{ __('View Keyboard Shortcuts') }}</span>
                </div>
                <kbd class="pc-palette-item-shortcut">?</kbd>
            </div>

            <a href="/logout" class="pc-palette-item logout-btn" data-keywords="logout log out sign out exit leave switch user">
                <div class="pc-palette-item-left">
                    <div class="pc-palette-item-icon" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;"><i class="fas fa-sign-out-alt"></i></div>
                    <span class="pc-palette-item-text text-danger font-weight-bold">{{ __('Log Out of Account') }}</span>
                </div>
                <span class="badge badge-danger" style="font-size: 0.7rem;">{{ __('Exit') }}</span>
            </a>
        </div>

        <!-- Footer with Shortcut Hints -->
        <div class="pc-palette-footer">
            <div class="pc-palette-footer-hints">
                <span><kbd class="pc-kbd-badge mr-1">↑</kbd><kbd class="pc-kbd-badge mr-1">↓</kbd> {{ __('to navigate') }}</span>
                <span><kbd class="pc-kbd-badge mr-1">↵</kbd> {{ __('to select') }}</span>
                <span><kbd class="pc-kbd-badge mr-1">esc</kbd> {{ __('to close') }}</span>
            </div>
            <div class="text-muted d-none d-sm-block">
                {{ __('Desktop Efficiency Mode') }}
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const overlay = document.getElementById('pcCommandPaletteOverlay');
        const input = document.getElementById('pcPaletteInput');
        const list = document.getElementById('pcPaletteList');
        let selectedIndex = 0;

        function getVisibleItems() {
            return Array.from(list.querySelectorAll('.pc-palette-item')).filter(function(item) {
                return item.style.display !== 'none';
            });
        }

        function updateSelection(items, newIndex) {
            items.forEach(function(item) { item.classList.remove('active'); });
            if (!items.length) return;
            selectedIndex = Math.max(0, Math.min(newIndex, items.length - 1));
            const selected = items[selectedIndex];
            if (selected) {
                selected.classList.add('active');
                selected.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }
        }

        function filterItems() {
            const query = (input.value || '').trim().toLowerCase();
            const groups = list.querySelectorAll('.pc-palette-group-title');
            const items = list.querySelectorAll('.pc-palette-item');

            items.forEach(function(item) {
                const text = (item.querySelector('.pc-palette-item-text')?.textContent || '').toLowerCase();
                const keywords = (item.getAttribute('data-keywords') || '').toLowerCase();
                const href = (item.getAttribute('href') || '').toLowerCase();

                if (!query || text.includes(query) || keywords.includes(query) || href.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });

            // Hide section titles if all their items are hidden
            groups.forEach(function(group) {
                let next = group.nextElementSibling;
                let hasVisible = false;
                while (next && !next.classList.contains('pc-palette-group-title')) {
                    if (next.classList.contains('pc-palette-item') && next.style.display !== 'none') {
                        hasVisible = true;
                        break;
                    }
                    next = next.nextElementSibling;
                }
                group.style.display = hasVisible ? 'block' : 'none';
            });

            const visible = getVisibleItems();
            updateSelection(visible, 0);
        }

        function executeItem(item) {
            if (!item) return;
            closePcCommandPalette();
            const action = item.getAttribute('data-action');
            if (action) {
                if (action === 'toggleTheme' && typeof window.toggleTheme === 'function') {
                    const isDark = document.documentElement.classList.contains('dark-mode');
                    window.toggleTheme(!isDark);
                } else if (action === 'togglePcCompactMode' && typeof window.togglePcCompactMode === 'function') {
                    window.togglePcCompactMode();
                } else if (action === 'toggleSidebar') {
                    $('[data-widget="pushmenu"]').trigger('click');
                } else if (action === 'toggleFullscreen') {
                    $('[data-widget="fullscreen"]').trigger('click');
                } else if (action === 'openPcShortcutsModal' && typeof window.openPcShortcutsModal === 'function') {
                    window.openPcShortcutsModal();
                }
                return;
            }

            const href = item.getAttribute('href');
            if (href) {
                if (item.classList.contains('logout-btn') || href === '/logout') {
                    closePcCommandPalette();
                    $(item).trigger('click');
                    return;
                }
                if (typeof showOverlay === 'function') showOverlay();
                window.location.href = href;
            }
        }

        function openPcCommandPalette() {
            if (!overlay) return;
            overlay.style.display = 'flex';
            if (input) {
                input.value = '';
                filterItems();
                setTimeout(function() { input.focus(); }, 50);
            }
        }

        function closePcCommandPalette() {
            if (!overlay) return;
            overlay.style.display = 'none';
            if (input) input.blur();
        }

        function togglePcCommandPalette() {
            if (!overlay) return;
            if (overlay.style.display === 'flex') {
                closePcCommandPalette();
            } else {
                openPcCommandPalette();
            }
        }

        function handlePaletteBackdropClick(e) {
            if (e.target === overlay) {
                closePcCommandPalette();
            }
        }

        // Search typing listener
        if (input) {
            input.addEventListener('input', filterItems);
            input.addEventListener('keydown', function(e) {
                const visible = getVisibleItems();
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    updateSelection(visible, selectedIndex + 1);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    updateSelection(visible, selectedIndex - 1);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (visible[selectedIndex]) {
                        executeItem(visible[selectedIndex]);
                    }
                }
            });
        }

        // Direct click on items
        if (list) {
            list.addEventListener('click', function(e) {
                const item = e.target.closest('.pc-palette-item');
                if (item) {
                    e.preventDefault();
                    executeItem(item);
                }
            });
        }

        window.openPcCommandPalette = openPcCommandPalette;
        window.closePcCommandPalette = closePcCommandPalette;
        window.togglePcCommandPalette = togglePcCommandPalette;
        window.handlePaletteBackdropClick = handlePaletteBackdropClick;
    })();
</script>

