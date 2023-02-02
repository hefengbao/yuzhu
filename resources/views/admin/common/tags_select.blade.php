<link rel="stylesheet" href="{{ asset('libs/select2/4.0.13/css/select2.min.css') }}"/>
<script src="{{ asset('libs/select2/4.0.13/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tags").select2({
            tags: true
        });
    });
</script>
