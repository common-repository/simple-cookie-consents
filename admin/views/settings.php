<?php defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access'); ?>

<div class="wrap">


    <form method="post" action="admin.php?page=<?php echo SIMPLETOOL_NL_ADMIN_FILE_NAME;?>">

        <input type="hidden" name="task" value="save_settings">
	    <?php  wp_nonce_field("save_settings.php",'simpletools_nl_admin_save_settins');  ?>

        <h2>Simple GDPR Cookie Settings</h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="post_format">Cookie Information Text</label></th>
                <td><textarea name="simple_gdpr_cookie_text" id="simple_gdpr_cookie_text" STYLE="width: 100%;" cols="20"
                              rows="5"><?php echo $simple_gdpr_cookie_text; ?></textarea>

                    <p>HTML is allowed. Default: <i><?php echo htmlentities('We use cookies to improve our service for you. You can find more information from our <a href="CHANGE_THIS_WITH_YOUR_PRIVACY_POLICY_URL">privacy policy</a>');?></i></p>

                </td>
            </tr>


            <tr>
                <th scope="row"><label for="lknsuite_api_user_id">Cookie Confirmation Button Text</label></th>
                <td><textarea name="simple_gdpr_cookie_button_text" id="simple_gdpr_cookie_button_text" STYLE="width: 100%;" cols="20"
                              rows="1"><?php echo $simple_gdpr_cookie_button_text; ?></textarea>

                    <p>User will click on that button that he/he accepts your cookie policy. (HTML is not allowed). Default: <i>OK</i>
                    </p>
                </td>
            </tr>


            </tbody>
        </table>


        <p class="submit"><input name="submit" class="button button-primary" value="Save"
                                 type="submit"></p></form>

</div>