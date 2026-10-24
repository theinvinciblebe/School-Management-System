
<!-- Bootstrap 4 (Includes Popper.js) -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>

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

<!-- Sidebar Scroll Position & OverlayScrollbars Consistency Script -->
<script>
    (function () {
        const SIDEBAR_SCROLL_KEY = 'adminlte_sidebar_scroll_pos';
        const SIDEBAR_PATH_KEY = 'adminlte_sidebar_last_path';

        function getSidebar() {
            return $('.main-sidebar .sidebar');
        }

        function getOsInstance() {
            const $sidebar = getSidebar();
            if ($sidebar.length && typeof $sidebar.overlayScrollbars === 'function') {
                return $sidebar.overlayScrollbars();
            }
            return null;
        }

        function syncSidebarTheme() {
            const $mainSidebar = $('.main-sidebar');
            const $sidebar = getSidebar();
            if (!$sidebar.length) return;

            const isLightSidebar = $mainSidebar.is('[class*="sidebar-light-"]');
            const targetTheme = isLightSidebar ? 'os-theme-dark' : 'os-theme-light';
            if (isLightSidebar) {
                $sidebar.removeClass('os-theme-light').addClass('os-theme-dark');
            } else {
                $sidebar.removeClass('os-theme-dark').addClass('os-theme-light');
            }

            const os = getOsInstance();
            if (os && typeof os.options === 'function') {
                os.options({
                    className: targetTheme,
                    overflowBehavior: {
                        x: 'hidden',
                        y: 'scroll'
                    },
                    scrollbars: {
                        visibility: 'auto',
                        autoHide: 'leave',
                        autoHideDelay: 600,
                        dragScrolling: true,
                        clickScrolling: true,
                        touchSupport: true
                    }
                });
            }
        }

        function saveSidebarScroll() {
            try {
                const os = getOsInstance();
                let pos = null;
                if (os && typeof os.scroll === 'function') {
                    const s = os.scroll();
                    if (s && s.position) {
                        pos = s.position.y;
                    }
                } else {
                    const $vp = getSidebar().find('.os-viewport');
                    if ($vp.length) {
                        pos = $vp.scrollTop();
                    } else if (getSidebar().length) {
                        pos = getSidebar()[0].scrollTop;
                    }
                }
                if (pos !== null && !isNaN(pos)) {
                    sessionStorage.setItem(SIDEBAR_SCROLL_KEY, pos);
                }
            } catch (e) {}
        }

        function syncSidebarSelectedPosition() {
            const $sidebar = getSidebar();
            if (!$sidebar.length) return;

            syncSidebarTheme();

            const os = getOsInstance();
            let currentPath = window.location.pathname;
            let lastPath = null;
            let savedScroll = null;

            try {
                lastPath = sessionStorage.getItem(SIDEBAR_PATH_KEY);
                savedScroll = sessionStorage.getItem(SIDEBAR_SCROLL_KEY);
                sessionStorage.setItem(SIDEBAR_PATH_KEY, currentPath);
            } catch (e) {}

            const $active = $sidebar.find('.nav-sidebar .nav-link.active').first();

            // Ensure parent treeview menu is opened if active item is inside a treeview
            if ($active.length) {
                const $parentItem = $active.closest('.nav-treeview').closest('.nav-item');
                if ($parentItem.length && !$parentItem.hasClass('menu-open')) {
                    $parentItem.addClass('menu-open');
                    $parentItem.children('.nav-treeview').show();
                }
            }

            // If navigating within the session, restore exact scroll across route changes (no jumping)
            if (savedScroll !== null) {
                const targetY = parseInt(savedScroll, 10);
                if (!isNaN(targetY)) {
                    if (os && typeof os.scroll === 'function') {
                        os.scroll({ y: targetY }, 0);
                    } else {
                        $sidebar.find('.os-viewport').scrollTop(targetY);
                    }
                    return;
                }
            }

            // If no saved scroll exists (initial direct URL visit), scroll active item into view
            if ($active.length) {
                if (os && typeof os.scroll === 'function') {
                    os.scroll({ el: $active[0], block: 'center', scroll: 'ifneeded' }, 0);
                } else {
                    $active[0].scrollIntoView({ block: 'center', inline: 'nearest' });
                }
            }
        }

        // Run when DOM and AdminLTE are ready
        $(document).ready(function () {
            syncSidebarTheme();
            syncSidebarSelectedPosition();

            // Save on beforeunload
            window.addEventListener('beforeunload', saveSidebarScroll);

            // Continuously save scroll on os-viewport scroll
            $(document).on('scroll', '.main-sidebar .sidebar .os-viewport', function () {
                saveSidebarScroll();
            });

            // Proactive link prefetching for buttery smooth page navigation
            const prefetchedLinks = new Set();
            function prefetchNav(href) {
                if (!href || href === '#' || href.startsWith('javascript:') || prefetchedLinks.has(href)) return;
                try {
                    const targetUrl = new URL(href, window.location.origin);
                    if (targetUrl.origin !== window.location.origin) return;
                    if (targetUrl.pathname === window.location.pathname) return;
                    if (targetUrl.pathname.includes('logout') || targetUrl.pathname.includes('delete')) return;

                    prefetchedLinks.add(href);
                    const prefetchTag = document.createElement('link');
                    prefetchTag.rel = 'prefetch';
                    prefetchTag.href = targetUrl.href;
                    prefetchTag.as = 'document';
                    document.head.appendChild(prefetchTag);
                } catch (e) {}
            }

            $(document).on('mouseenter pointerdown', '.main-sidebar .sidebar .nav-link', function () {
                const href = $(this).attr('href');
                if (href) prefetchNav(href);
            });

            // Listen to click on nav-links: immediately save position, update active highlight, and show overlay inside overlay-wrapper
            $(document).on('click', '.main-sidebar .sidebar .nav-link', function (e) {
                if (e.ctrlKey || e.metaKey || e.shiftKey || $(this).attr('target') === '_blank') {
                    return;
                }
                const href = $(this).attr('href');
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    saveSidebarScroll();
                    // Avoid showing loader if already on current URL
                    if (window.location.pathname === href || window.location.href === href) {
                        return;
                    }
                    $('.main-sidebar .sidebar .nav-link').removeClass('active');
                    $(this).addClass('active');
                    showOverlay();
                }
            });

            // Handle treeview animation finishes
            $(document).on('expanded.lte.treeview collapsed.lte.treeview', function () {
                setTimeout(function () {
                    const os = getOsInstance();
                    if (os && typeof os.update === 'function') {
                        os.update();
                    }
                    saveSidebarScroll();
                }, 350);
            });
        });

        $(window).on('load', function () {
            syncSidebarSelectedPosition();
        });

        // Expose globally so customize page swatch changes can call it
        window.syncSidebarScrollbarTheme = syncSidebarTheme;
        window.syncSidebarSelectedPosition = syncSidebarSelectedPosition;
    })();
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

{{--@stack('scripts')--}}

</body>
</html>


