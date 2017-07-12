<h1><?php echo __('Riff Chart settings', 'riffchart'); ?></h1>
<br>
<div class ="fdiv">
    <form id="submitForm" method="post" action="options.php" >
        <?php settings_fields('riffchart-options-group'); ?>
        <?php do_settings_sections('riffchart-options-group'); ?>
        <?php
        $options_list = esc_attr(get_option('riffchart_local_remote'));
        $local = $options_list == 'local' ? 'checked' : '';
        $remote = $options_list == 'remote' ? 'checked' : '';
        ?>
        <div class="connection-btn">
            <div class= "radiocol">
                <input type="radio" id="local" name="riffchart_local_remote" value="local" <?php echo $local; ?>  />
                <label for="local"><span></span><b>Local</b></label>
            </div>

            <div class= "radiocol">
                <input type="radio" id="remote" name="riffchart_local_remote" value="remote" <?php echo $remote; ?> />
                <label for="remote"><span></span><b>Remote</b></label>
            </div>
        </div>
        <div id="remote_data">
           
        </div>
        <?php submit_button(__('Save Changes', 'riffchart'), 'primary', 'btnSubmit'); ?>
    </form>
</div>

