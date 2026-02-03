<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_LIBRARYMGT')) {
    exit('Stop!!!');
}

/**
 * nv_theme_detail()
 * Hiển thị chi tiết sách và xử lý logic mượn sách
 */
function nv_theme_detail($array_data, $allow_borrow, $error_message)
{
    [$template, $dir] = get_module_tpl_dir('detail.tpl', true);
    $xtpl = new XTemplate('detail.tpl', $dir);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);

    // Gán dữ liệu sách vào biến CONTENT để khớp với file detail.tpl đã hướng dẫn
    $xtpl->assign('CONTENT', $array_data);

    // Xử lý hiển thị nút mượn sách hoặc thông báo lỗi (Tooltip)
    if ($allow_borrow) {
        $xtpl->parse('main.allow_borrow');
    } else {
        $xtpl->assign('ERROR_MESSAGE', $error_message);
        $xtpl->parse('main.error_borrow');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_history()
 * Hiển thị lịch sử mượn sách của người dùng
 */
function nv_theme_history($array_data)
{
    [$template, $dir] = get_module_tpl_dir('history.tpl', true);
    $xtpl = new XTemplate('history.tpl', $dir);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);

    if (!empty($array_data)) {
        foreach ($array_data as $value) {
            $xtpl->assign('ROW', $value);
            $xtpl->parse('main.row');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_list()
 */
function nv_theme_list($array_data, $generate_page)
{
    [$template, $dir] = get_module_tpl_dir('main.tpl', true);
    $xtpl = new XTemplate('main.tpl', $dir);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);

    if (!empty($array_data)) {
        foreach ($array_data as $value) {
            $xtpl->assign('LOOP', $value);
            $xtpl->parse('main.loop');
        }

        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.gp');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}