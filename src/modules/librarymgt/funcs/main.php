<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';

$page_title = $module_info['site_title'];

$per_page = 10;
$page = $nv_Request->get_page('page', 'post,get', 1);
$page = max(1, (int) $page);
$offset = ($page - 1) * $per_page;

$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
$tb_categories = NV_PREFIXLANG . '_' . $module_data . '_categories';

$current_catid = 0; // Trang main = tất cả sách


//Phân trang
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$generate_page = ($num_items > $per_page) ? nv_generate_page($page_url, $num_items, $per_page, $page) : '';

$contents = nv_theme_books_list($books, $categories, $current_catid, $generate_page, $page_title);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
