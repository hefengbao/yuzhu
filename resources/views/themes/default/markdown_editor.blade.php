<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
    let mde = new EasyMDE({
        element: document.getElementById("editor"),
        unorderedListStyle: "-",
        status: ["upload-image","autosave", "lines", "words", "cursor"],
        uploadImage: true,
        imageUploadEndpoint: "{{ route('admin.upload.image') }}",
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
