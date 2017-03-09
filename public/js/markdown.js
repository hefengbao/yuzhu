/**
 * Created by hefengbao on 2017/2/28.
 */
var filename="http://";
var simplemde = new SimpleMDE({
    autofocus: true,
    autosave: {
        enabled: true,
        uniqueId: 'baoblog'
    },
    spellChecker: false,
    element: document.getElementById("post_content"),
    toolbar: [
        "heading",
        "code",
        "quote",
        "horizontal-rule",
        "|",
        "bold",
        "italic",
        "strikethrough",
        "|",
        "unordered-list",
        "ordered-list",
        "|",
        "link",
        {
            name: "image",
            action: function customFunction(editor){
                var cm = editor.codemirror;
                var options = editor.options;
                var _url = '';
                $("#md-image-upload").modal('show');
                $("#btn-insert").on('click',function () {
                    var _val =$('#image_url').val();
                    if (_val == ''){
                        $("#msg").html('请上传图片或输入图片地址');
                    }else {
                        _url = _val;
                        var url = "![]("+_url+")";
                        if(options.promptURLs) {
                            url = prompt(options.promptTexts.image);
                            if(!url) {
                                return false;
                            }
                        }
                        $("#md-image-upload").modal('hide');
                        cm.replaceSelection(url);
                    }
                });
            },
            className: "fa fa-picture-o",
        },
        "table",
        "|",
        "clean-block",
        "preview",
        "side-by-side",
        "fullscreen",
        "|",
        "guide"
    ],
});

var url = APP_URL + "/admin/post/upload";
$('#fileupload').fileupload({
    url: url,
    dataType: 'json',
    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
    maxFileSize: 1024*1024,
    done: function (e, data) {
        $("#msg_upload").text('图片上传成功');
        var arr = APP_URL.split('/');
        if (arr[arr.length-1] == "index.php"){
            APP_URL = APP_URL.substr(0,APP_URL.length - 10);
        }
        $("#image_url").val(APP_URL +'/'+ data.result.filename);
    },
    progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }
}).on('fileuploadfail', function (e, data) {
    console.log(data);
    $("#msg_upload").text('图片上传失败');
}).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');
