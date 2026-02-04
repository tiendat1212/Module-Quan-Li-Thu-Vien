<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('playlist_manager');

if ($nv_Request->get_string('action', 'get', '') === 'add') {
    $page_title = $nv_Lang->getModule('add_new_music');
    $contents = $nv_Lang->getModule('add_new_music') . ' (Coming Soon)';
} else {
    // Hiển thị danh sách
    $sql = "SELECT * FROM " . NV_PREFIXLANG . '_' . $module_data . "_rows ORDER BY id DESC";
    $result = $db->query($sql);
    
    $contents = '<div class="card"><div class="card-body"><h5 class="card-title">' . $nv_Lang->getModule('list_music') . '</h5>';
    $contents .= '<table class="table table-striped">';
    $contents .= '<thead><tr><th>#</th><th>' . $nv_Lang->getModule('title') . '</th><th>' . $nv_Lang->getModule('duration') . '</th><th>' . $nv_Lang->getModule('status') . '</th><th>' . $nv_Lang->getModule('actions') . '</th></tr></thead>';
    $contents .= '<tbody>';
    
    while ($row = $result->fetch()) {
        $status_badge = $row['status'] == 1 ? '<span class="badge bg-success">' . $nv_Lang->getModule('active') . '</span>' : '<span class="badge bg-danger">' . $nv_Lang->getModule('inactive') . '</span>';
        $contents .= '<tr>';
        $contents .= '<td>' . $row['id'] . '</td>';
        $contents .= '<td>' . $row['title'] . '</td>';
        $contents .= '<td>' . $row['duration'] . '</td>';
        $contents .= '<td>' . $status_badge . '</td>';
        $contents .= '<td><a href="#" class="btn btn-sm btn-primary">' . $nv_Lang->getModule('edit') . '</a></td>';
        $contents .= '</tr>';
    }
    
    $contents .= '</tbody>';
    $contents .= '</table>';
    $contents .= '</div></div>';
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
