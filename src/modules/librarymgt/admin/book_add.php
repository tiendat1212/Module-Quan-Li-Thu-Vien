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

$page_title = $nv_Lang->getModule('book_add');

$categories = nv_admin_get_categories_list(false);

$data = [
    'title' => '',
    'author' => '',
    'cat_id' => 0,
    'publisher' => '',
    'publish_year' => '',
    'isbn' => '',
    'quantity' => '',
    'image' => '',
    'description' => '',
    'status' => 1
];
$errors = [];

if ($nv_Request->isset_request('submit', 'post')) {
    $data['title'] = $nv_Request->get_title('title', 'post', '');
    $data['author'] = $nv_Request->get_title('author', 'post', '');
    $data['cat_id'] = $nv_Request->get_int('cat_id', 'post', 0);
    $data['publisher'] = $nv_Request->get_title('publisher', 'post', '');
    $data['publish_year'] = $nv_Request->get_int('publish_year', 'post', 0);
    $data['isbn'] = $nv_Request->get_title('isbn', 'post', '');
    $data['quantity'] = $nv_Request->get_int('quantity', 'post', 0);
    $data['image'] = $nv_Request->get_title('image', 'post', '');
    $data['description'] = $nv_Request->get_textarea('description', 'post', '');
    $data['status'] = $nv_Request->get_int('status', 'post', 1);

    if (isset($_FILES['image_file']) and is_uploaded_file($_FILES['image_file']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload([
            'jpg', 'jpeg', 'png', 'gif', 'webp'
        ], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);
        $upload->setLanguage(\NukeViet\Core\Language::$lang_global);
        $upload_info = $upload->save_file($_FILES['image_file'], NV_UPLOADS_REAL_DIR . '/' . $module_upload, false);
        @unlink($_FILES['image_file']['tmp_name']);

        if (!empty($upload_info['error'])) {
            $errors['image'] = $upload_info['error'];
        } else {
            @chmod($upload_info['name'], 0644);
            $data['image'] = $module_upload . '/' . $upload_info['basename'];
        }
    }

    if (empty($errors)) {
        $result = nv_admin_insert_book($data);
        if (!empty($result['success'])) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
        }

        if (!empty($result['errors'])) {
            $errors = $result['errors'];
        }
    }
}

$data = nv_admin_normalize_book_template_data($data);

[$template, $dir] = get_module_tpl_dir('book_add.tpl', true);
$xtpl = new XTemplate('book_add.tpl', $dir);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('DATA', $data);
$xtpl->assign('BACK_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');

foreach ($categories as $id => $title) {
    $xtpl->assign('CATEGORY', [
        'id' => $id,
        'name' => $title,
        'selected' => ($data['cat_id'] == $id) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.category_option');
}

$status_options = [
    ['value' => 1, 'label' => $nv_Lang->getModule('status_active')],
    ['value' => 0, 'label' => $nv_Lang->getModule('status_inactive')]
];
foreach ($status_options as $item) {
    $xtpl->assign('STATUS', [
        'value' => $item['value'],
        'label' => $item['label'],
        'selected' => ((int) $data['status'] === (int) $item['value']) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.status_option');
}

if (!empty($errors)) {
    foreach ($errors as $field => $message) {
        $xtpl->assign('ERROR', [
            'field' => $field,
            'message' => $message
        ]);
        $xtpl->parse('main.error_item');
    }
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
