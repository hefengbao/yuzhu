@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script><!-- Header -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script><!-- Image -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script><!-- Delimiter -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script><!-- List -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script><!-- Checklist -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script><!-- Quote -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script><!-- Code -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script><!-- Embed -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script><!-- Table -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script><!-- Link -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script><!-- Warning -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script><!-- Marker -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script><!-- Inline Code -->
    <!-- Load Editor.js's Core -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tags").select2({
                tags: true
            });

            $("#publish").datetimepicker({
                locale: 'zh_CN',
                icons: {time: 'far fa-clock'}
            });

            let _publishSetting = $('#publish_setting')
            let _publishedAt = $('#published_at')
            @if(isset($article) && $article && $article->status == 'future')
            _publishSetting.show()
            _publishedAt.prop("required", true);
            @else
            _publishSetting.hide()
            _publishedAt.prop("required", false);
            @endif

            let _status = $('#status');
            _status.on('change', function () {
                if ($(this).val() === 'future') {
                    _publishSetting.show()
                } else {
                    _publishSetting.hide()
                    $('#published_at').val(null)
                }
            })

            /*$('#title').on('blur',function (){
                $.get('?title='+$(this).val(), function (data,status){
                    $('#slug').val(data)
                })
            });*/
        });

        const editor = new EditorJS({
            holder: 'editor',
            placeholder: '开始写作...',
            tools: {
                header: {
                    class: Header,
                    config: {
                        placeholder: '请输入标题',
                        levels: [2, 3, 4, 5],
                        defaultLevel: 2
                    },
                    shortcut: 'CMD+SHIFT+H'
                },

                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    config: {
                        quotePlaceholder: '输入引语',
                        captionPlaceholder: '输入引语作者等信息',
                    },
                    shortcut: 'CMD+SHIFT+O'
                },

                delimiter: {
                    class: Delimiter,
                    shortcut: 'CMD+SHIFT+D'
                },

                list: {
                    class: List,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+L'
                },

                checklist: {
                    class: Checklist,
                    inlineToolbar: true
                },

                warning: {
                    class: Warning,
                    inlineToolbar: true,
                    config: {
                        titlePlaceholder: '标题',
                        messagePlaceholder: '内容',
                    },
                },

                marker: {
                    class: Marker,
                    shortcut: 'CMD+SHIFT+M'
                },

                code: {
                    class: CodeTool,
                    shortcut: 'CMD+SHIFT+C'
                },

                inlineCode: {
                    class: InlineCode,
                    shortcut: 'CMD+SHIFT+C'
                },

                linkTool: {
                    class: LinkTool,
                    config: {
                        endpoint: '{{ route('admin.editorjs.fetchurl') }}'
                    },
                },

                embed: Embed,

                table: {
                    class: Table,
                    inlineToolbar: true,
                    shortcut: 'CMD+ALT+T'
                },

                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: '{{ route('admin.upload.image') }}', // Your backend file uploader endpoint
                            byUrl: '', // Your endpoint that provides uploading by Url
                        },
                        additionalRequestData: {
                            '_token': '{{ csrf_token() }}',
                        }
                    },
                    shortcut: 'CMD+SHIFT+I'
                },
            },
            i18n: {
                messages: {
                    "ui": {
                        "blockTunes": {
                            "toggler": {
                                "Click to tune": "点击转换",
                                "or drag to move": "拖动调整"
                            },
                        },
                        "inlineToolbar": {
                            "converter": {
                                "Convert to": "转换成"
                            }
                        },
                        "toolbar": {
                            "toolbox": {
                                "Add": "添加",
                                "Filter": "过滤",
                                "Nothing found": "没有找到"
                            },
                        }
                    },
                    "toolNames": {
                        "Text": "段落",
                        "Heading": "标题",
                        "List": "列表",
                        "Warning": "警告",
                        "Checklist": "清单",
                        "Quote": "引用",
                        "Code": "代码",
                        "Delimiter": "分割线",
                        "Table": "表格",
                        "Link": "链接",
                        "Marker": "突出显示",
                        "Bold": "加粗",
                        "Italic": "倾斜",
                        "Image": "图片"
                    },
                    "tools": {
                        "link": {
                            "Add a link": "添加链接"
                        },
                        "stub": {
                            'The block can not be displayed correctly.': '该模块不能放置在这里'
                        },
                        "image": {
                            "Caption": "图片说明",
                            "Select an Image": "选择图片",
                            "With border": "添加边框",
                            "Stretch image": "拉伸图像",
                            "With background": "添加背景",
                        },
                        "code": {
                            "Enter a code": "输入代码",
                        },
                        "linkTool": {
                            "Link": "请输入链接地址",
                            "Couldn't fetch the link data": "获取链接数据失败",
                            "Couldn't get this link data, try the other one": "该链接不能访问，请修改",
                            "Wrong response format from the server": "错误响应",
                        },
                        "header": {
                            "Header": "标题",
                            "Heading 2": "二级标题",
                            "Heading 3": "三级标题",
                            "Heading 4": "四级标题",
                            "Heading 5": "五级标题",
                        },
                        "paragraph": {
                            "Enter something": "请输入",
                        },
                        "list": {
                            "Ordered": "有序列表",
                            "Unordered": "无序列表",
                        },
                        "table": {
                            "Heading": "标题",
                            "Add column to left": "在左侧插入列",
                            "Add column to right": "在右侧插入列",
                            "Delete column": "删除列",
                            "Add row above": "在上方插入行",
                            "Add row below": "在下方插入行",
                            "Delete row": "删除行",
                            "With headings": "有标题",
                            "Without headings": "无标题",
                        },
                        "quote": {
                            "Align Left": "左对齐",
                            "Align Center": "居中对齐",
                        }
                    },
                    "blockTunes": {
                        "delete": {
                            "Delete": "删除",
                            'Click to delete': "点击删除"
                        },
                        "moveUp": {
                            "Move up": "向上移"
                        },
                        "moveDown": {
                            "Move down": "向下移"
                        },
                        "filter": {
                            "Filter": "过滤"
                        }
                    }
                }
            },
            data: @if(old('body'))JSON.parse({!! json_encode(old('body')) !!})
            @elseif(isset($article) && $article && $article->body) JSON
            .parse({!! json_encode($article->body) !!})
            @else{{ json_encode([]) }}@endif,
            onReady: () => {
                console.log('Editor.js is ready to work!')
            },
            onChange: (api, event) => {
                editor.save().then((savedData) => {
                    document.getElementById("body").value = JSON.stringify(savedData)
                    if (savedData.blocks.length > 0) {
                        document.getElementById("submit").disabled = false
                    }
                }).catch((error) => {
                    console.error('Saving error', error);
                });
            }
        });
    </script>
@endsection
