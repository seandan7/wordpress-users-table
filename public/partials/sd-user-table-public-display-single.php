<?php

/**
 * Provide a public-facing view for the single items within the  plugin
 *
 * This file is used to markup the public-facing single aspects of the plugin.
 *

 * @since      1.0.0
 *
 * @package    SD_User_Table
 * @subpackage SD_User_Table/public/partials
 */
?>

<tr>
    <td>
        <?php _e($user->user_login, 'sd-user-table'); ?>
    </td>
    <td>
        <?php _e($user->display_name, 'sd-user-table'); ?>
    </td>
    <td>
        <?php _e($user->roles[0], 'sd-user-table'); ?>
    </td>
</tr>