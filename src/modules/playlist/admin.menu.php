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
$menu_sub['main'] = $nv_Lang->getModule('list_music');
$menu_sub['add'] = $nv_Lang->getModule('add_new_music');
$menu_sub['config'] = $nv_Lang->getModule('config');

$submenu['main'] = [
    'title' => $nv_Lang->getModule('playlist_manager'),
    'submenu' => $menu_sub
];
