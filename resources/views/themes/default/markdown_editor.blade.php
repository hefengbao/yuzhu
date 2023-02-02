<link rel="stylesheet" href="{{ asset('libs/easymde/dist/easymde.min.css') }}">
<script src="{{ asset('libs/easymde/dist/easymde.min.js') }}"></script>
<script>
    let mde = new EasyMDE({
        element: document.getElementById("editor"),
        unorderedListStyle: "-",
        minHeight: "150px",
        spellChecker: false,
        autoDownloadFontAwesome: false,
        status: false,
        toolbar: false
    });
</script>
