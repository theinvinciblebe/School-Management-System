@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.success("{{ __(session('success')) }}");
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.error("{{ __(session('error')) }}");
        });
    </script>
@endif

@if(session('info'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.info("{{ __(session('info')) }}");
        });
    </script>
@endif

@if(session('warning'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.warning("{{ __(session('warning')) }}");
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
