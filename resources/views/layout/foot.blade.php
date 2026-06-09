<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Timepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<!-- BS-Stepper -->
<script src="/assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="/assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="/assets/plugins/raphael/raphael.min.js"></script>
<script src="/assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="/assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- Select2 -->
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Sparkline -->
<script src="/assets/plugins/sparklines/sparkline.js"></script>
<!-- Moment.js -->
<script src="/assets/plugins/moment/moment.min.js"></script>
<!-- Date Range Picker -->
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Bootstrap Switch -->
<script src="/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- dropzonejs -->
<script src="/assets/plugins/dropzone/min/dropzone.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/plugins/jszip/jszip.min.js"></script>
<script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Summernote -->
<script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>


<!-- AdminLTE for demo purposes -->
<script src="/assets/dist/js/demo.js"></script>

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
{{--<script>--}}
{{--    function showOverlay() {--}}
{{--        let overlay = document.getElementById("div");--}}

{{--        // Check if the element exists, if not, create it--}}
{{--        if (!overlay) {--}}
{{--            overlay = document.createElement("div");--}}
{{--            overlay.id = "div";--}}
{{--            document.body.appendChild(overlay);--}}
{{--        }--}}

{{--        overlay.className = "overlay";--}}
{{--        overlay.innerHTML = `--}}
{{--        <i class="fas fa-3x fa-sync-alt fa-spin"></i>--}}
{{--        <div class="text-bold pt-2">Loading...</div>--}}
{{--    `;--}}
{{--        document.body.appendChild(overlay);--}}
{{--    }--}}

{{--    // Listen for the "pageshow" event to handle back/forward navigation--}}
{{--    window.addEventListener('pageshow', (event) => {--}}
{{--        // Check if the page is being restored from the cache--}}
{{--        if (event.persisted) {--}}
{{--            // Remove the overlay if it exists--}}
{{--            const overlay = document.querySelector('.overlay');--}}
{{--            if (overlay) {--}}
{{--                document.body.removeChild(overlay);--}}
{{--            }--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}

{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", () => {--}}
{{--        showOverlay();--}}
{{--    });--}}
{{--</script>--}}

<!-- Flatpickr JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>--}}

{{--<script>--}}
{{--    flatpickr("#datepicker", {--}}
{{--        dateFormat: "d/m/Y", // Example format: "DD/MM/YYYY"--}}
{{--    });--}}
{{--</script>--}}

<!-- Page specific script -->
<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });

    $(document).ready(function() {
        $('#notificationDropdown').dropdown();
    });

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

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

{{--@stack('scripts')--}}

</body>
</html>


