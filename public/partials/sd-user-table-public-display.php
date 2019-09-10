<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *

 * @since      1.0.0
 *
 * @package    SD_User_Table
 * @subpackage SD_User_Table/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="sd-user-table-container">
    <div class="sd-user--filters">
        
    </div>
    <table class="tablesorter" id="sd-user--table">
        <thead>
            <tr>
                <th class="smpSortableTable--sortable table__username">Username</th>
                <th class="smpSortableTable--sortable table__displayname">Display Name</th>
                <th class="smp-not-sortable">Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($arr as $user) {
                include(plugin_dir_path(__FILE__) . '/sd-user-table-public-display-single.php');
            }
            ?>
        </tbody>
    </table>
</div>