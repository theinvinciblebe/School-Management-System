
<!-- Bootstrap 4 (Includes Popper.js) -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>

<!-- Sidebar Scroll Position & OverlayScrollbars Consistency Script -->
<script>
    (function () {
        const SIDEBAR_SCROLL_KEY = 'adminlte_sidebar_scroll_pos';
        const SIDEBAR_PATH_KEY   = 'adminlte_sidebar_last_path';

        function getSidebar() {
            return $('.main-sidebar .sidebar');
        }

        function getOsInstance() {
            const $sb = getSidebar();
            if ($sb.length && typeof $sb.overlayScrollbars === 'function') {
                return $sb.overlayScrollbars() || null;
            }
            return null;
        }

        function syncSidebarTheme(force) {
            const $mainSidebar = $('.main-sidebar');
            const $sidebar     = getSidebar();
            if (!$sidebar.length) return;

            const isLight = $mainSidebar.is('[class*="sidebar-light-"]');
            $sidebar
                .toggleClass('os-theme-dark',  isLight)
                .toggleClass('os-theme-light', !isLight);

            const os = getOsInstance();
            if (os && typeof os.options === 'function') {
                os.options({
                    className: isLight ? 'os-theme-dark' : 'os-theme-light',
                    overflowBehavior: { x: 'hidden', y: 'scroll' },
                    scrollbars: {
                        visibility: 'auto',
                        autoHide: 'leave',
                        autoHideDelay: 800,
                        dragScrolling: true,
                        clickScrolling: true,
                        touchSupport: true
                    },
                    callbacks: {
                        onScroll: function() {
                            saveSidebarScroll();
                        }
                    }
                });
            }
        }

        function readSidebarScroll() {
            try {
                // 1. Raw os-viewport scrollTop (direct DOM value)
                const vp = document.querySelector('.main-sidebar .sidebar .os-viewport');
                if (vp && typeof vp.scrollTop === 'number' && vp.scrollTop > 0) {
                    return vp.scrollTop;
                }
                // 2. OverlayScrollbars API
                const os = getOsInstance();
                if (os && typeof os.scroll === 'function') {
                    const s = os.scroll();
                    if (s && s.position && typeof s.position.y === 'number' && s.position.y > 0) {
                        return s.position.y;
                    }
                }
                // 3. Raw sidebar element
                const sb = document.querySelector('.main-sidebar .sidebar');
                if (sb && typeof sb.scrollTop === 'number') {
                    return sb.scrollTop;
                }
            } catch(e) {}
            return null;
        }

        function saveSidebarScroll() {
            const pos = readSidebarScroll();
            if (pos !== null && !isNaN(pos)) {
                try {
                    sessionStorage.setItem(SIDEBAR_SCROLL_KEY, Math.round(pos));
                } catch(e) {}
            }
        }

        // Apply scroll synchronously with ZERO animation (duration: 0)
        function applyScrollY(y) {
            if (y === null || isNaN(y) || y < 0) return;
            try {
                // Direct DOM viewports
                const vp = document.querySelector('.main-sidebar .sidebar .os-viewport');
                if (vp) vp.scrollTop = y;
                const sb = document.querySelector('.main-sidebar .sidebar');
                if (sb) sb.scrollTop = y;

                // OverlayScrollbars instant scroll (0ms duration)
                const os = getOsInstance();
                if (os && typeof os.scroll === 'function') {
                    os.scroll({ y: y }, 0);
                }
            } catch(e) {}
        }

        function syncTreeviews() {
            const $sidebar = getSidebar();
            if (!$sidebar.length) return;

            const isMini = document.body.classList.contains('sidebar-collapse') ||
                           document.documentElement.classList.contains('sidebar-collapse');

            if (isMini) {
                // Mini mode: collapse ALL treeviews — no dangling submenus
                $sidebar.find('.nav-sidebar .nav-item.menu-open, .nav-sidebar .nav-item.menu-is-opening')
                    .removeClass('menu-open menu-is-opening');
                $sidebar.find('.nav-sidebar .nav-treeview').each(function () {
                    this.style.removeProperty('display');
                    this.style.removeProperty('height');
                    this.style.display = 'none';
                });
            } else {
                // Expanded mode: open treeview that contains the active link
                const $active = $sidebar.find('.nav-sidebar .nav-link.active').first();
                if ($active.length) {
                    const $tv = $active.closest('.nav-treeview');
                    if ($tv.length) {
                        const $parentItem = $tv.closest('.nav-item');
                        if ($parentItem.length && !$parentItem.hasClass('menu-open')) {
                            $parentItem.addClass('menu-open');
                            $parentItem.children('.nav-treeview').css('display', 'block');
                        }
                    }
                }
            }
        }

        function restoreSidebarState() {
            syncSidebarTheme();
            syncTreeviews();

            const $sidebar = getSidebar();
            if (!$sidebar.length) return;

            let savedScroll = null;
            const curPath   = window.location.pathname;

            try {
                savedScroll = sessionStorage.getItem(SIDEBAR_SCROLL_KEY);
                sessionStorage.setItem(SIDEBAR_PATH_KEY, curPath);
            } catch(e) {}

            if (savedScroll !== null) {
                const targetY = parseInt(savedScroll, 10);
                if (!isNaN(targetY) && targetY >= 0) {
                    applyScrollY(targetY);
                    return;
                }
            }

            // ONLY if user has NEVER scrolled (first arrival on site without saved scroll)
            const activeItem = document.querySelector('.main-sidebar .nav-sidebar .nav-link.active');
            if (activeItem) {
                activeItem.scrollIntoView({ block: 'nearest' });
                saveSidebarScroll();
            }
        }

        function initAndRestore() {
            const $sidebar = getSidebar();
            if (!$sidebar.length) return;

            if (typeof $.fn.overlayScrollbars === 'function' && !$sidebar.hasClass('os-host')) {
                const isLight = $('.main-sidebar').is('[class*="sidebar-light-"]');
                $sidebar.overlayScrollbars({
                    className: isLight ? 'os-theme-dark' : 'os-theme-light',
                    overflowBehavior: { x: 'hidden', y: 'scroll' },
                    scrollbars: {
                        visibility: 'auto',
                        autoHide: 'leave',
                        autoHideDelay: 800,
                        dragScrolling: true,
                        clickScrolling: true,
                        touchSupport: true
                    },
                    callbacks: {
                        onScroll: function() {
                            saveSidebarScroll();
                        }
                    }
                });
            }

            restoreSidebarState();
        }

        $(document).ready(function () {
            initAndRestore();
        });

        $(window).on('load', function () {
            let saved = null;
            try { saved = sessionStorage.getItem(SIDEBAR_SCROLL_KEY); } catch(e) {}
            if (saved !== null) {
                const y = parseInt(saved, 10);
                if (!isNaN(y) && y > 0) {
                    applyScrollY(y);
                }
            }
        });

        // 1. Capture scroll event continuously using capture phase (since scroll does not bubble)
        document.addEventListener('scroll', function (e) {
            var t = e.target;
            if (t && (
                (t.classList && (t.classList.contains('os-viewport') || t.classList.contains('sidebar'))) ||
                (t.closest && t.closest('.main-sidebar'))
            )) {
                saveSidebarScroll();
            }
        }, true);

        // 2. Save scroll position on any click or pointerdown in the sidebar
        document.addEventListener('pointerdown', function (e) {
            if (e.target && e.target.closest && e.target.closest('.main-sidebar')) {
                saveSidebarScroll();
            }
        }, true);

        // 3. Save scroll on page navigation
        window.addEventListener('pagehide',    saveSidebarScroll, { passive: true });
        window.addEventListener('beforeunload', saveSidebarScroll, { passive: true });

        // 4. Click on nav links: save scroll, update active state, and show overlay
        $(document).on('click', '.main-sidebar .sidebar .nav-link', function (e) {
            if (e.ctrlKey || e.metaKey || e.shiftKey || $(this).attr('target') === '_blank') return;
            const href = $(this).attr('href');
            if (!href || href === '#' || href.startsWith('javascript:')) return;

            saveSidebarScroll();

            if (window.location.pathname === href || window.location.href === href) return;

            // Instant active highlight
            $('.main-sidebar .sidebar .nav-link').removeClass('active');
            $(this).addClass('active');
            showOverlay();
        });

        // 5. Treeview animation finished: re-save scroll and update OS
        $(document).on('expanded.lte.treeview collapsed.lte.treeview', function () {
            setTimeout(function () {
                const os = getOsInstance();
                if (os && typeof os.update === 'function') os.update();
                saveSidebarScroll();
            }, 320);
        });

        // Expose globals
        window.syncSidebarScrollbarTheme   = () => syncSidebarTheme(true);
        window.syncSidebarSelectedPosition  = restoreSidebarState;
        window.saveCurrentSidebarScroll    = saveSidebarScroll;
    })();
</script>

<!-- jQuery UI 1.11.4 -->
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Timepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<!-- Select2 -->
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Moment.js -->
<script src="/assets/plugins/moment/moment.min.js"></script>
<!-- Date Range Picker -->
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Bootstrap Switch -->
<script src="/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- DataTables & Plugins (Deferred for maximum responsiveness) -->
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script defer src="/assets/plugins/jszip/jszip.min.js"></script>
<script defer src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script defer src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

{{--<!-- AdminLTE dashboard demo (This is only for demo purposes) -->--}}
{{--<script src="/assets/dist/js/pages/dashboard2.js"></script>--}}

{{--<script type="text/javascript">--}}
{{--    function previewFile() {--}}
{{--        const preview = document.getElementById('imgshow');--}}
{{--        const file = document.querySelector('input[type=file]').files[0];--}}
{{--        const reader = new FileReader();--}}

{{--        reader.addEventListener("load", function () {--}}
{{--            // convert image file to base64 string--}}
{{--            preview.src = reader.result;--}}
{{--        }, false);--}}

{{--        if (file) {--}}
{{--            reader.readAsDataURL(file);--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}


<!-- preview image script -->
<script>
    function previewFile() {
        const file = document.getElementById("exampleInputFile").files[0];
        const preview = document.getElementById("previewImage");

        if (file) {
            const reader = new FileReader();

            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = "block"; // Show preview
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            preview.style.display = "none"; // Hide if no file selected
        }
    }
</script>

<!-- sweet alert script -->
<script>
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Handle Add button click
    $(document).on('click', '.add-btn', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        Swal.fire({
            title: "Add New data",
            text: "Are you sure you want to add a new data?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!",
            inputValidator: (value) => {
                // Validate the input
                if (!value) {
                    return "You need to enter something!";
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr("action"),
                    method: form.attr("method"),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: "Data added successfully!",
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        }).then(() => {
                            // Redirect or reload the page
                            window.history.back(); // Go back to the previous page
                            setTimeout(() => {
                                window.location.reload(); // Reload after going back
                            }, 500); // Add a delay to allow navigation before reloading

                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "Error",
                            text: "An error occurred while adding the data.",
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                        });
                    }
                });
                // Redirect to the add page or perform the add action
                //window.location.href = "/add-item"; // Replace with your actual URL
            }
        });
    });

    // Handle logout button click
    $(document).on('click', '.logout-btn', function (e) {
        e.preventDefault(); // Prevent default navigation
        let logoutUrl = $(this).attr('href'); // Get the logout route from href

        Swal.fire({
            title: "Are you sure you want to log out?",
            text: "You will need to log in again to access your account.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, log out!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutUrl; // Redirect to logout route
            }
        });
    });

</script>

<!-- Overlay script -->
<script>
    function showOverlay() {
        const wrapper = document.getElementById("mainOverlayWrapper") || document.querySelector(".content-wrapper .overlay-wrapper") || document.querySelector(".overlay-wrapper");
        if (!wrapper) return;

        let overlay = document.getElementById("contentOverlay");
        if (!overlay) {
            overlay = document.createElement("div");
            overlay.id = "contentOverlay";
            overlay.className = "overlay";
            overlay.innerHTML = `
                <div class="overlay-content">
                    <i class="fas fa-2x fa-spinner fa-spin"></i>
                    <div class="text-bold pt-2 font-weight-normal" style="font-size: 0.92rem; letter-spacing: 0.5px;">Loading...</div>
                </div>
            `;
            wrapper.appendChild(overlay);
        } else {
            overlay.style.display = "flex";
        }
    }

    function hideOverlay() {
        const overlay = document.getElementById("contentOverlay");
        if (overlay) {
            overlay.style.display = "none";
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }
    }
    window.hideOverlay = hideOverlay;

    // Listen for the "pageshow" event to handle back/forward navigation
    window.addEventListener('pageshow', (event) => {
        hideOverlay();
    });
</script>

<!-- Page specific script -->
<script>

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        @if(app()->getLocale() === 'km')
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                search: "ស្វែងរក:",
                searchPlaceholder: "ស្វែងរក...",
                lengthMenu: "បង្ហាញ _MENU_ ទិន្នន័យ",
                info: "បង្ហាញពី _START_ ដល់ _END_ នៃ _TOTAL_ ទិន្នន័យ",
                infoEmpty: "បង្ហាញពី 0 ដល់ 0 នៃ 0 ទិន្នន័យ",
                infoFiltered: "(ត្រងចេញពីទិន្នន័យសរុប _MAX_)",
                zeroRecords: "រកមិនឃើញទិន្នន័យដែលត្រូវគ្នាទេ",
                emptyTable: "គ្មានទិន្នន័យក្នុងតារាងទេ",
                paginate: {
                    first: "ដំបូង",
                    previous: "ថយក្រោយ",
                    next: "បន្ទាប់",
                    last: "ចុងក្រោយ"
                },
                buttons: {
                    copy: "ចម្លង",
                    csv: "CSV",
                    excel: "Excel",
                    pdf: "PDF",
                    print: "បោះពុម្ព",
                    colvis: "បង្ហាញជួរឈរ"
                }
            }
        });
        @endif

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "paging": true,
            "pageLength": 10, // Set the number of rows per page
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#classTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "paging": true,
            "pageLength": 10, // Set the number of rows per page
            "buttons": [
                "copy", "csv", "excel","pdf",
                "print", "colvis"
            ]
        }).buttons().container().appendTo('#classTable_wrapper .col-md-6:eq(0)');

    });
</script>



<script>
    // Bottom-of-page immediate preloader dismissal: ensures preloader is never stuck after scripts execute
    (function() {
        if (typeof window.dismissPreloader === 'function') {
            window.dismissPreloader();
        } else {
            var p = document.getElementById('systemPreloader') || document.querySelector('.system-preloader');
            if (p) {
                p.classList.add('preloader-hidden');
                setTimeout(function() { if (p && p.parentNode) p.remove(); }, 350);
            }
        }
    })();
</script>

<!-- PC Desktop Productivity & Responsiveness Engine -->
<script>
    (function() {
        // 1. Sidebar Collapse State Persistence on Desktop PC (>= 992px only)
        function saveSidebarCollapseState(isCollapsed) {
            // Strictly guard: never persist desktop collapse state on mobile screens
            if (window.innerWidth < 992) return;
            try {
                localStorage.setItem('sidebar_collapsed', isCollapsed ? '1' : '0');
                document.cookie = "sidebar_collapsed=" + (isCollapsed ? "1" : "0") + "; path=/; max-age=31536000; SameSite=Lax";
                if (isCollapsed) {
                    document.documentElement.classList.add('sidebar-is-collapsed', 'sidebar-collapse');
                } else {
                    document.documentElement.classList.remove('sidebar-is-collapsed', 'sidebar-collapse');
                }
            } catch(e) {}
        }

        $(document).on('collapsed.lte.pushmenu', function() {
            saveSidebarCollapseState(true);
            if (window.innerWidth >= 992) {
                // Purge all open treeviews in mini mode so nothing dangles
                $('.main-sidebar .nav-sidebar .nav-item.menu-open, .main-sidebar .nav-sidebar .nav-item.menu-is-opening').each(function () {
                    $(this).removeClass('menu-open menu-is-opening');
                });
                $('.main-sidebar .nav-sidebar .nav-treeview').each(function () {
                    this.style.removeProperty('display');
                    this.style.removeProperty('height');
                    $(this).hide();
                });
            }
        });

        $(document).on('shown.lte.pushmenu', function() {
            saveSidebarCollapseState(false);
            if (window.innerWidth >= 992) {
                // Restore active parent treeview when sidebar expands
                const $active = $('.main-sidebar .nav-sidebar .nav-link.active').first();
                if ($active.length) {
                    const $parentItem = $active.closest('.nav-treeview').closest('.nav-item');
                    if ($parentItem.length) {
                        $parentItem.addClass('menu-open');
                        $parentItem.children('.nav-treeview').slideDown(180);
                    }
                }
            }
        });

        // Pushmenu click fallback
        $(document).on('click', '[data-widget="pushmenu"]', function() {
            setTimeout(function() {
                if (window.innerWidth >= 992) {
                    var isCollapsed = $('body').hasClass('sidebar-collapse');
                    saveSidebarCollapseState(isCollapsed);
                }
            }, 300);
        });

        // Smart behavior: if sidebar is in collapsed mini-mode on PC, clicking a menu with submenus smoothly expands it
        $(document).on('click', '.sidebar-collapse .main-sidebar .nav-sidebar .nav-item > .nav-link', function (e) {
            if (window.innerWidth < 992) return;
            const $item = $(this).closest('.nav-item');
            if ($item.find('.nav-treeview').length) {
                e.preventDefault();
                e.stopPropagation();
                $('[data-widget="pushmenu"]').first().trigger('click');
                setTimeout(() => {
                    $item.addClass('menu-open');
                    $item.children('.nav-treeview').slideDown(180);
                }, 160);
            }
        });

        // 2. PC Table Density Toggle (Compact vs Comfortable)
        function togglePcCompactMode() {
            const isCompact = document.body.classList.toggle('pc-compact-mode');
            document.documentElement.classList.toggle('pc-compact-mode', isCompact);
            try {
                localStorage.setItem('pc_compact_mode', isCompact ? '1' : '0');
                document.cookie = "pc_compact_mode=" + (isCompact ? "1" : "0") + "; path=/; max-age=31536000; SameSite=Lax";
            } catch(e) {}

            const btn = document.getElementById('navbarPcDensityToggle');
            const icon = document.getElementById('pcDensityIcon');
            if (btn) btn.classList.toggle('active', isCompact);
            if (icon) {
                if (isCompact) {
                    icon.classList.remove('fa-compress-arrows-alt');
                    icon.classList.add('fa-expand-arrows-alt');
                    if (btn) btn.setAttribute('title', '{{ __("Switch to Comfortable display (Alt + C)") }}');
                } else {
                    icon.classList.remove('fa-expand-arrows-alt');
                    icon.classList.add('fa-compress-arrows-alt');
                    if (btn) btn.setAttribute('title', '{{ __("Switch to Compact display (Alt + C)") }}');
                }
            }
            if (typeof toastr !== 'undefined') {
                toastr.clear();
                toastr.info(isCompact ? '{{ __("Compact table density enabled") }}' : '{{ __("Comfortable table density enabled") }}');
            }
        }
        window.togglePcCompactMode = togglePcCompactMode;

        // 3. Global PC Productivity Keyboard Shortcuts
        document.addEventListener('keydown', function(e) {
            const isInput = ['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName) || e.target.isContentEditable;

            // Esc: Close Command Palette or Shortcuts Modal
            if (e.key === 'Escape') {
                if (typeof closePcCommandPalette === 'function') closePcCommandPalette();
                if (typeof closePcShortcutsModal === 'function') closePcShortcutsModal();
                return;
            }

            // Ctrl + K or Cmd + K: Open Command Palette
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                if (typeof togglePcCommandPalette === 'function') togglePcCommandPalette();
                return;
            }

            // '/' key outside of input: Focus Smart Filter or Open Command Palette
            if (!isInput && e.key === '/') {
                e.preventDefault();
                const isCollapsed = document.body.classList.contains('sidebar-collapse');
                const sbInput = document.getElementById('smartSidebarSearchInput');
                if (!isCollapsed && sbInput) {
                    sbInput.focus();
                    sbInput.select();
                } else if (typeof openPcCommandPalette === 'function') {
                    openPcCommandPalette();
                }
                return;
            }

            // Alt + S or Alt + B: Toggle Sidebar Collapse (Maximize table view)
            if (e.altKey && (e.key.toLowerCase() === 's' || e.key.toLowerCase() === 'b')) {
                e.preventDefault();
                $('[data-widget="pushmenu"]').first().trigger('click');
                return;
            }

            // Alt + T: Toggle Theme
            if (e.altKey && e.key.toLowerCase() === 't') {
                e.preventDefault();
                const isDark = document.documentElement.classList.contains('dark-mode');
                if (typeof window.toggleTheme === 'function') window.toggleTheme(!isDark);
                return;
            }

            // Alt + C: Toggle Compact Mode
            if (e.altKey && e.key.toLowerCase() === 'c') {
                e.preventDefault();
                togglePcCompactMode();
                return;
            }

            // Alt + D or Alt + H: Jump to Dashboard
            if (e.altKey && (e.key.toLowerCase() === 'd' || e.key.toLowerCase() === 'h')) {
                e.preventDefault();
                if (typeof showOverlay === 'function') showOverlay();
                window.location.href = '/dashboard';
                return;
            }

            // Alt + F: Toggle Fullscreen
            if (e.altKey && e.key.toLowerCase() === 'f') {
                e.preventDefault();
                $('[data-widget="fullscreen"]').first().trigger('click');
                return;
            }

            // '?' (Shift + /) or Ctrl + /: Open Shortcuts Cheat Sheet
            if ((!isInput && e.key === '?') || ((e.ctrlKey || e.metaKey) && e.key === '/')) {
                e.preventDefault();
                if (typeof openPcShortcutsModal === 'function') openPcShortcutsModal();
                return;
            }
        });

        // 4. Smart Sidebar Suite: In-Tree Live Filter, Auto-Scroll & Collapsed Floating Tooltips
        (function() {
            const input = document.getElementById('smartSidebarSearchInput');
            const clearBtn = document.getElementById('smartSearchClearBtn');
            const countBadge = document.getElementById('smartSearchCount');
            const emptyState = document.getElementById('smartSearchEmpty');
            const sidebarNav = document.querySelector('.main-sidebar .nav-sidebar');



            // B. Smart In-Tree Live Filtering
            if (input && sidebarNav) {
                let originalStates = [];
                function snapshotTree() {
                    originalStates = [];
                    sidebarNav.querySelectorAll('.nav-item').forEach(function(item) {
                        originalStates.push({
                            item: item,
                            isOpen: item.classList.contains('menu-open') || item.classList.contains('menu-is-opening')
                        });
                    });
                }
                snapshotTree();

                function filterSidebar(query) {
                    query = (query || '').trim().toLowerCase();

                    // Remove existing highlights
                    sidebarNav.querySelectorAll('.smart-search-hl').forEach(function(hl) {
                        const parent = hl.parentNode;
                        if (parent) {
                            parent.replaceChild(document.createTextNode(hl.textContent), hl);
                            parent.normalize();
                        }
                    });

                    if (!query) {
                        if (clearBtn) clearBtn.classList.add('d-none');
                        if (countBadge) countBadge.classList.add('d-none');
                        if (emptyState) emptyState.classList.add('d-none');

                        sidebarNav.querySelectorAll('.nav-item').forEach(function(item) {
                            item.classList.remove('d-none', 'smart-match-item');
                        });
                        sidebarNav.querySelectorAll('.nav-header').forEach(function(h) {
                            h.classList.remove('d-none');
                        });

                        // Restore original open state
                        originalStates.forEach(function(s) {
                            if (s.isOpen) {
                                s.item.classList.add('menu-open');
                                const tv = s.item.querySelector(':scope > .nav-treeview');
                                if (tv) tv.style.display = 'block';
                            } else {
                                s.item.classList.remove('menu-open');
                                const tv = s.item.querySelector(':scope > .nav-treeview');
                                if (tv) tv.style.display = 'none';
                            }
                        });
                        return;
                    }

                    if (clearBtn) clearBtn.classList.remove('d-none');

                    let matchCount = 0;
                    const allItems = Array.from(sidebarNav.querySelectorAll('.nav-item'));

                    allItems.forEach(function(item) {
                        const link = item.querySelector(':scope > .nav-link');
                        const p = link ? link.querySelector('p') : null;
                        if (!p) return;

                        // Get text without right badges/icons
                        let text = '';
                        p.childNodes.forEach(function(node) {
                            if (node.nodeType === Node.TEXT_NODE) text += node.textContent;
                        });
                        text = text.trim().toLowerCase();
                        if (!text) text = p.innerText.trim().toLowerCase();

                        if (text.includes(query)) {
                            matchCount++;
                            item.classList.remove('d-none');
                            item.classList.add('smart-match-item');

                            // Highlight text
                            highlightInElement(p, query);

                            // Expand ancestors
                            let parent = item.parentElement;
                            while (parent && parent !== sidebarNav) {
                                if (parent.classList.contains('nav-item')) {
                                    parent.classList.remove('d-none');
                                    parent.classList.add('menu-open');
                                    const tv = parent.querySelector(':scope > .nav-treeview');
                                    if (tv) tv.style.display = 'block';
                                }
                                if (parent.classList.contains('nav-treeview')) {
                                    parent.style.display = 'block';
                                }
                                parent = parent.parentElement;
                            }
                        } else {
                            item.classList.remove('smart-match-item');
                        }
                    });

                    // Hide non-matching leaf items
                    allItems.forEach(function(item) {
                        const isMatch = item.classList.contains('smart-match-item');
                        const hasChildMatch = item.querySelector('.smart-match-item');
                        if (!isMatch && !hasChildMatch) {
                            item.classList.add('d-none');
                        } else {
                            item.classList.remove('d-none');
                        }
                    });

                    // Hide empty headers
                    const headers = sidebarNav.querySelectorAll('.nav-header');
                    headers.forEach(function(h) {
                        let next = h.nextElementSibling;
                        let hasVisible = false;
                        while (next && !next.classList.contains('nav-header')) {
                            if (!next.classList.contains('d-none')) {
                                hasVisible = true;
                                break;
                            }
                            next = next.nextElementSibling;
                        }
                        if (!hasVisible) {
                            h.classList.add('d-none');
                        } else {
                            h.classList.remove('d-none');
                        }
                    });

                    if (countBadge) {
                        countBadge.innerText = matchCount;
                        countBadge.classList.remove('d-none');
                    }
                    if (emptyState) {
                        if (matchCount === 0) {
                            emptyState.classList.remove('d-none');
                        } else {
                            emptyState.classList.add('d-none');
                        }
                    }
                }

                function highlightInElement(el, query) {
                    const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT, null, false);
                    const textNodes = [];
                    while (walker.nextNode()) {
                        const parent = walker.currentNode.parentElement;
                        if (!parent.classList.contains('badge') && !parent.classList.contains('right')) {
                            textNodes.push(walker.currentNode);
                        }
                    }
                    textNodes.forEach(function(node) {
                        const val = node.nodeValue;
                        const idx = val.toLowerCase().indexOf(query);
                        if (idx >= 0) {
                            const frag = document.createDocumentFragment();
                            const before = document.createTextNode(val.substring(0, idx));
                            const mark = document.createElement('mark');
                            mark.className = 'smart-search-hl';
                            mark.textContent = val.substring(idx, idx + query.length);
                            const after = document.createTextNode(val.substring(idx + query.length));

                            frag.appendChild(before);
                            frag.appendChild(mark);
                            frag.appendChild(after);
                            node.parentNode.replaceChild(frag, node);
                        }
                    });
                }

                input.addEventListener('input', function() {
                    filterSidebar(this.value);
                });

                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        input.value = '';
                        filterSidebar('');
                        input.focus();
                    });
                }

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        input.value = '';
                        filterSidebar('');
                        input.blur();
                    } else if (e.key === 'Enter') {
                        const topLink = sidebarNav.querySelector('.smart-match-item > .nav-link, .nav-item:not(.d-none) > .nav-link');
                        if (topLink) {
                            e.preventDefault();
                            topLink.click();
                        }
                    }
                });

                // Click on search pill in mini mode triggers Command Palette
                const pillWrapper = document.getElementById('smartSidebarSearchWrapper');
                if (pillWrapper) {
                    pillWrapper.addEventListener('click', function(e) {
                        const isCollapsed = document.body.classList.contains('sidebar-collapse') || document.documentElement.classList.contains('sidebar-collapse');
                        if (isCollapsed) {
                            e.preventDefault();
                            if (typeof openPcCommandPalette === 'function') openPcCommandPalette();
                        }
                    });
                }
            }

            // C. Smart Floating Tooltips in Collapsed Mini Mode
            let miniTooltip = null;
            function getOrCreateTooltip() {
                if (!miniTooltip) {
                    miniTooltip = document.createElement('div');
                    miniTooltip.className = 'smart-sidebar-tooltip';
                    document.body.appendChild(miniTooltip);
                }
                return miniTooltip;
            }

            $(document).on('mouseenter', '.main-sidebar .nav-sidebar .nav-link', function() {
                const isCollapsed = document.body.classList.contains('sidebar-collapse') || document.documentElement.classList.contains('sidebar-collapse');
                if (!isCollapsed) return;

                const p = this.querySelector('p');
                if (!p) return;

                let title = '';
                p.childNodes.forEach(function(n) {
                    if (n.nodeType === Node.TEXT_NODE) title += n.textContent;
                });
                title = title.trim();
                if (!title) title = p.innerText.trim();
                if (!title) return;

                const tip = getOrCreateTooltip();
                tip.innerHTML = '<span>' + title + '</span>';

                const badge = p.querySelector('.badge');
                if (badge) {
                    tip.innerHTML += '<span class="badge ' + badge.className.replace('right', '') + ' ml-2">' + badge.innerText + '</span>';
                }

                const rect = this.getBoundingClientRect();
                tip.style.top = (rect.top + (rect.height / 2)) + 'px';
                tip.style.left = (rect.right + 12) + 'px';
                tip.classList.add('show');
            });

            $(document).on('mouseleave', '.main-sidebar .nav-sidebar .nav-link', function() {
                if (miniTooltip) miniTooltip.classList.remove('show');
            });

            window.addEventListener('scroll', function() {
                if (miniTooltip) miniTooltip.classList.remove('show');
            }, true);
        })();
    })();
</script>

{{--@stack('scripts')--}}

</body>
</html>


