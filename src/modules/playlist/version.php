<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$module_version = [
    'name' => 'Playlist', // tên module
    'modfuncs' => 'main, detail', // Danh sách các func
    'submenu' => 'main, detail', // Các funcs hiển thị submenu
    'is_sysmod' => 0, // module hệ thống hay không? 1: hệ thống 0: module thường
    'virtual' => 0, // có phải module ảo không? 1: thật, 0:ảo
    'version' => '5.0.00', // phiên bản của module
    'date' => 'Sunday, January 26, 2026 10:00:00 AM GMT+07:00', // ngày phát hành phiên bản
    'author' => 'VINADES.,JSC <contact@vinades.vn>', // tác giả viết module
    'note' => '',
    'uploads_dir' => [
        $module_upload
    ],
    'icon' => 'fa-solid fa-music'
];
