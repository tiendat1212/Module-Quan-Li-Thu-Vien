<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRARYMGT')) {
    exit('Stop!!');
}


// Ensure AJAX borrow requests sent directly to index.php are handled even if module funcs cache not updated
$requestedOp = $_REQUEST[NV_OP_VARIABLE] ?? null;
if ($requestedOp === 'borrow') {
    include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/borrow.php';
    exit();
}

// If URL is like /librarymgt/<alias>/ treat it as a request for detail page
if (!empty($array_op) && !empty($array_op[0])) {
    // Only forward to detail if alias exists in books table (safer routing)
    $alias_check = $array_op[0];
    $sql_check = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_books WHERE alias = ' . $db->quote($alias_check) . ' AND status = 1 LIMIT 1';
    if ($db->query($sql_check)->fetchColumn()) {
        // Include detail handler which expects $array_op[0] to contain the alias
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/detail.php';
        exit();
    }
}

// If front-controller did not register custom funcs yet (cache), allow direct handling of borrow op
if (isset($op) && $op === 'borrow') {
    include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/borrow.php';
    exit();
}

$page_title = $module_info['site_title'];
$array_data = [];
$per_page = 12; // Nên để 12 sách mỗi trang thay vì 1 [cite: 58]
$page = $nv_Request->get_page('page', 'post, get', 1);
$offset = ($page - 1) * $per_page;

// Truy vấn đúng bảng _books đã tạo trong action_mysql.php
$sql = "SELECT * FROM " . NV_PREFIXLANG . '_' . $module_data . "_books WHERE status = 1 LIMIT " . $offset . ", " . $per_page;
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $array_data[] = $row;
}

$num_items = $db->query("SELECT COUNT(*) FROM " . NV_PREFIXLANG . '_' . $module_data . "_books WHERE status = 1")->fetchColumn();
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$generate_page = nv_generate_page($page_url, $num_items, $per_page, $page);

// Gọi hàm render danh sách từ theme.php
$contents = nv_theme_list($array_data, $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';