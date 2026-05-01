@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.success("{{ session('success') }}");
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.error("{{ session('error') }}");
        });
    </script>
@endif

@if(session('info'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.info("{{ session('info') }}");
        });
    </script>
@endif

@if(session('warning'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.warning("{{ session('warning') }}");
        });
    </script>
@endif

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000" // Auto-close in 5 seconds
    };
</script>
