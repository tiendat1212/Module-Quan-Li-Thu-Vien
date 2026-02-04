<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

$allow_func = array('main', 'config', 'add', 'edit', 'delete');
define('NV_IS_FILE_ADMIN', true);

// list các function dùng chung cho admin
function nv_playlist_format_duration($seconds) {
    if (empty($seconds)) {
        return '--:--';
    }
    $minutes = intval($seconds / 60);
    $secs = $seconds % 60;
    return sprintf('%02d:%02d', $minutes, $secs);
}
