<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC.
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

/**
 * Submenu admin của module librarymgt
 * Gộp: quản lý sách + thể loại + mượn trả + cấu hình
 */
$menu_sub = [];

// Nhóm quản lý sách (nhánh main)
$menu_sub['books'] = $nv_Lang->getModule('books_manager');
$menu_sub['book_add'] = $nv_Lang->getModule('book_add');
$menu_sub['book_edit'] = $nv_Lang->getModule('book_edit');
// Nếu có file book_delete.php thì giữ, không có thì có thể bỏ
$menu_sub['book_delete'] = $nv_Lang->getModule('book_delete');
// Nếu có api.php thì giữ, không có thì có thể bỏ
$menu_sub['api'] = $nv_Lang->getModule('api');

// Nhóm quản lý chung (nhánh dev-ngan)
$menu_sub['cat'] = $nv_Lang->getModule('cat_manager');
$menu_sub['borrows'] = $nv_Lang->getModule('borrows_manager');
$menu_sub['config'] = $nv_Lang->getModule('config');

// Root menu
$submenu['main'] = [
    'title' => $nv_Lang->getModule('library_manager'),
    'submenu' => $menu_sub
];
