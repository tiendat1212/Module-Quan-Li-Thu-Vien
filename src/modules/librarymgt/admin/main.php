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

$page_title = $nv_Lang->getModule('books_manager');

$page = $nv_Request->get_page('page', 'get', 1);
$per_page = 20;
$search = $nv_Request->get_title('search', 'get', '');
$cat_id = $nv_Request->get_int('cat_id', 'get', 0);
$status = $nv_Request->get_int('status', 'get', -1);
$sort = $nv_Request->get_title('sort', 'get', 'ASC');
$sort = ($sort === 'DESC') ? 'DESC' : 'ASC';

$op_delete = $nv_Request->get_title('op_delete', 'get', '');
$book_id = $nv_Request->get_int('book_id', 'get', 0);
$checkss = $nv_Request->get_title('checkss', 'get', '');

if ($op_delete === 'delete' && $book_id > 0) {
    if ($checkss === md5($book_id . NV_CHECK_SESSION)) {
        $delete_result = nv_delete_book($book_id);
        if ($delete_result['success']) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
        }
    }
}

$filters = [
    'search' => $search,
    'cat_id' => $cat_id,
    'sort' => $sort
];
if ($status >= 0) {
    $filters['status'] = $status;
}

$list = nv_get_books_list($page, $per_page, $filters);
$categories = nv_get_categories_list(false);

$rows = [];
foreach ($list['books'] as $row) {
    $rows[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'author' => $row['author'],
        'cat_title' => $row['cat_title'],
        'quantity' => $row['quantity'],
        'status_text' => $row['status'] ? $nv_Lang->getModule('status_active') : $nv_Lang->getModule('status_inactive'),
        'status_class' => $row['status'] ? 'success' : 'danger',
        'add_date' => nv_date('d/m/Y', $row['add_time']),
        'edit_url' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=book_edit&amp;book_id=' . $row['id'],
        'delete_url' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main&amp;op_delete=delete&amp;book_id=' . $row['id'] . '&amp;checkss=' . md5($row['id'] . NV_CHECK_SESSION)
    ];
}

[$template, $dir] = get_module_tpl_dir('main.tpl', true);
$xtpl = new XTemplate('main.tpl', $dir);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('SEARCH', $search);
$xtpl->assign('CAT_ID', $cat_id);
$xtpl->assign('STATUS', $status);
$xtpl->assign('SORT', $sort);
$xtpl->assign('SORT_TOGGLE', ($sort === 'ASC') ? 'DESC' : 'ASC');
$xtpl->assign('SORT_ASC_SELECTED', ($sort === 'ASC') ? 'selected="selected"' : '');
$xtpl->assign('SORT_DESC_SELECTED', ($sort === 'DESC') ? 'selected="selected"' : '');
$xtpl->assign('ADD_BOOK_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=book_add');

foreach ($categories as $id => $title) {
    $xtpl->assign('CATEGORY_OPTION', [
        'id' => $id,
        'name' => $title,
        'selected' => ($cat_id == $id) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.category_option');
}

$status_options = [
    ['value' => -1, 'label' => $nv_Lang->getModule('all_status')],
    ['value' => 1, 'label' => $nv_Lang->getModule('status_active')],
    ['value' => 0, 'label' => $nv_Lang->getModule('status_inactive')]
];
foreach ($status_options as $item) {
    $xtpl->assign('STATUS_OPTION', [
        'value' => $item['value'],
        'label' => $item['label'],
        'selected' => ((int) $status === (int) $item['value']) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.status_option');
}

if (!empty($rows)) {
    foreach ($rows as $row) {
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }
} else {
    $xtpl->parse('main.no_books');
}

$generate_page = '';
if ($list['total'] > $per_page) {
    $page_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main&amp;search=' . urlencode($search) . '&amp;cat_id=' . $cat_id . '&amp;status=' . $status . '&amp;sort=' . $sort;
    $generate_page = nv_generate_page($page_url, $list['total'], $per_page, $page);
}
if (!empty($generate_page)) {
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.gp');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
