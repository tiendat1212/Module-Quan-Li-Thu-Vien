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

$menu_sub = [];
$menu_sub['main'] = $nv_Lang->getModule('books_manager');
$menu_sub['book_add'] = $nv_Lang->getModule('book_add');
$menu_sub['book_edit'] = $nv_Lang->getModule('book_edit');

$submenu['main'] = [
    'title' => $nv_Lang->getModule('library_manager'),
    'submenu' => $menu_sub
];

// bla bla