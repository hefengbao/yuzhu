<style>
    .md-image-upload-modal .modal {
        z-index: 10001;
    }
</style>
<link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
<div class="md-image-upload-modal">
    <div class="modal" id="md-image-upload">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">插入图片</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>图片格式为 png、jpg、jpeg、gif，大小在1M内</p>
                    </div>
                    <div class="form-group">
                        <span class="btn btn-success fileinput-button">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span>请选择图片...</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload" type="file" name="file">
                        </span>
                    </div>
                    <div class="form-group">
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-warning"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p id="msg_upload" style="color: red;"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="image_url"
                               placeholder="请输入图片地址">
                    </div>
                    <p id="msg" style="color: red;"></p>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary done-btn" id="btn-insert">插入</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.example-modal -->
