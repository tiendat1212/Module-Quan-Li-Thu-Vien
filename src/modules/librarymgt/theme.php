<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

function nv_theme_books_list($books, $categories, $current_catid, $generate_page, $page_title = '', $q = '')

{
    [$template, $dir] = get_module_tpl_dir('books_list.tpl', true);
    $xtpl = new XTemplate('books_list.tpl', $dir);

    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);
    $xtpl->assign('PAGE_TITLE', $page_title);
    $xtpl->assign('Q', $q);
    $xtpl->assign('CURRENT_CATID', (int) $current_catid);

    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('MODULE_NAME', $GLOBALS['module_name']);



    $module_name = $GLOBALS['module_name'];

    // URL all books
    $xtpl->assign('URL_ALL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);

    // Category buttons
    if (!empty($categories)) {
        foreach ($categories as $id => $name) {
            $xtpl->assign('CAT', [
                'id' => (int) $id,
                'name' => $name,
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=category&catid=' . (int) $id,
                'active' => ((int) $current_catid === (int) $id) ? 1 : 0
            ]);

            if ((int) $current_catid === (int) $id) {
                $xtpl->parse('main.cat_loop.active');
            }
            $xtpl->parse('main.cat_loop');
        }
    }

    // Borrowed link only when logged in
    if (defined('NV_IS_USER')) {
        $xtpl->assign('URL_BORROWED', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=borrowed');
        $xtpl->parse('main.borrowed_link');
    }

    // Books list
    if (!empty($books)) {
        foreach ($books as $row) {
            $book_id = (int) $row['id'];

            // Build borrow link (op=borrow handled by other teammate)
            $checkss = md5($book_id . NV_CHECK_SESSION);
            $row['borrow_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA
                . '&' . NV_NAME_VARIABLE . '=' . $module_name
                . '&' . NV_OP_VARIABLE . '=borrow&book_id=' . $book_id
                . '&checkss=' . $checkss;

            // Borrow button status
            $can_borrow = false;
            $row['borrow_reason'] = 'Vui lòng đăng nhập để mượn';

            if (defined('NV_IS_USER')) {
                if ((int) $row['quantity'] > 0) {
                    $can_borrow = true;
                    $row['borrow_reason'] = '';
                } else {
                    $row['borrow_reason'] = 'Sách hiện không có sẵn';
                }
            }

            // Assign row once
            $xtpl->assign('ROW', $row);

            // Cover image
            if (!empty($row['image'])) {
                $xtpl->parse('main.has_books.loop.has_image');
            } else {
                $xtpl->parse('main.has_books.loop.no_image');
            }

            // Borrow button
            if ($can_borrow) {
                $xtpl->parse('main.has_books.loop.borrow_enable');
            } else {
                $xtpl->parse('main.has_books.loop.borrow_disable');
            }

            // Parse 1 card
            $xtpl->parse('main.has_books.loop');
        }

        // Pagination
        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.gp');
        }

        // Wrapper block
        $xtpl->parse('main.has_books');
    } else {
        $xtpl->parse('main.empty');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
