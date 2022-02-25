<?php demo_load_css(array("assets/css/demo_styles.css")); ?>
<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "demo";
            echo view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="card">

                <div class="card-header">
                    <h4>Demo settings</h4>
                </div>

                <?php echo form_open(get_uri("demo_settings/save"), array("id" => "demo-settings-form", "class" => "general-form dashed-row", "role" => "form")); ?>

                <div class="card-body post-dropzone">
                    <div class="form-group">
                        <div class="row">
                            <label for="setting_demo" class=" col-md-3">Setting demo: </label>
                            <div class=" col-md-9">
                                <?php
                                echo form_input(array(
                                    "id" => "setting_demo",
                                    "name" => "setting_demo",
                                    "value" => get_demo_setting("setting_demo"),
                                    "class" => "form-control",
                                    "placeholder" => "Setting demo"
                                ));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class=" col-md-3">File uploading demo (upload, render and delete old file after change): </label>
                            <div class=" col-md-9">
                                <div class="float-start mr15">
                                    <?php
                                    $file_src = demo_get_source_url(get_demo_setting("file_demo"));
                                    if ($file_src) {
                                        ?>
                                        <img class="demo-file-preview" src="<?php echo demo_get_source_url(get_demo_setting("file_demo")); ?>" alt="..." />
                                    <?php } ?>
                                </div>
                                <div class="float-start mr15">
                                    <?php echo view("includes/dropzone_preview"); ?>    
                                </div>
                                <div class="float-start upload-file-button btn btn-default btn-sm">
                                    <span><i data-feather="upload" class="icon-14"></i> <?php echo app_lang("upload"); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#demo-settings-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });

        var uploadUrl = "<?php echo get_uri("demo_settings/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("demo_settings/validate_demo_file"); ?>";

        var dropzone = attachDropzoneWithForm("#demo-settings-form", uploadUrl, validationUrl, {maxFiles: 1});
    });
</script>