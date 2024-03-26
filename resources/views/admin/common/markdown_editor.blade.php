<link rel="stylesheet" href="{{ asset('libs/easymde/dist/easymde.min.css') }}">
<script src="{{ asset('libs/easymde/dist/easymde.min.js') }}"></script>
<script>
    let mde = new EasyMDE({
        element: document.getElementById("editor"),
        spellChecker: false,
        autoDownloadFontAwesome: false,
        unorderedListStyle: "-",
        status: ["upload-image", "autosave", "lines", "words", "cursor"],
        uploadImage: true,
        imageUploadEndpoint: "{{ route('admin.markdown.uploadimage') }}",
        imageCSRFToken: "{{ csrf_token() }}",
        imageCSRFName: "_token",
        toolbar: [
            "undo",
            "redo",
            "|",
            "heading",
            "quote",
            "code",
            "unordered-list",
            "ordered-list",
            "link",
            "upload-image",
            "|",
            "bold",
            "italic",
            "strikethrough",
            "|",
            "clean-block",
            "preview",
        ]
    });
</script>
