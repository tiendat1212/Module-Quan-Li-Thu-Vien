<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

function nv_theme_books_list($books, $categories, $current_catid, $generate_page, $page_title = '')
{
    [$template, $dir] = get_module_tpl_dir('books_list.tpl', true);
    $xtpl = new XTemplate('books_list.tpl', $dir);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);
    $xtpl->assign('PAGE_TITLE', $page_title);

    $xtpl->assign('URL_ALL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name']);

    foreach ($categories as $id => $name) {
        $xtpl->assign('CAT', [
            'id' => $id,
            'name' => $name,
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name'] . '&' . NV_OP_VARIABLE . '=category&catid=' . (int) $id,
            'active' => ((int) $current_catid === (int) $id) ? 1 : 0
        ]);
        if ((int) $current_catid === (int) $id) {
            $xtpl->parse('main.cat_loop.active');
        }
        $xtpl->parse('main.cat_loop');
    }

    if (defined('NV_IS_USER')) {
        $xtpl->assign('URL_BORROWED', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name'] . '&' . NV_OP_VARIABLE . '=borrowed');
        $xtpl->parse('main.borrowed_link');
    }

if (!empty($books)) {
    foreach ($books as $row) {
        $xtpl->assign('ROW', $row);

        if (!empty($row['image'])) {
            $xtpl->parse('main.has_books.loop.has_image');
        } else {
            $xtpl->parse('main.has_books.loop.no_image');
        }

        $xtpl->parse('main.has_books.loop');
    }

    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.gp');
    }

    $xtpl->parse('main.has_books');
} else {
    $xtpl->parse('main.empty');
}


    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_theme_book_detail($book, $can_borrow, $borrow_disabled_reason)
{
    [$template, $dir] = get_module_tpl_dir('book_detail.tpl', true);
    $xtpl = new XTemplate('book_detail.tpl', $dir);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);
    
    $xtpl->assign('BOOK', $book);
    $xtpl->assign('BACK_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name']);
    $xtpl->assign('BORROW_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name'] . '&' . NV_OP_VARIABLE . '=borrow');
    
    if (!empty($book['image'])) {
        $xtpl->parse('main.has_image');
    } else {
        $xtpl->parse('main.no_image');
    }
    
    if ($can_borrow) {
        $xtpl->parse('main.can_borrow');
    } else {
        $xtpl->assign('DISABLED_REASON', $borrow_disabled_reason);
        $xtpl->parse('main.cannot_borrow');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_theme_borrowed_list($borrow_list, $generate_page, $page_title)
{
    [$template, $dir] = get_module_tpl_dir('borrowed_list.tpl', true);
    $xtpl = new XTemplate('borrowed_list.tpl', $dir);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);
    $xtpl->assign('PAGE_TITLE', $page_title);
    
    $xtpl->assign('BACK_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name']);
    $xtpl->assign('CANCEL_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $GLOBALS['module_name'] . '&' . NV_OP_VARIABLE . '=borrowed');
    
    if (!empty($borrow_list)) {
        foreach ($borrow_list as $row) {
            $xtpl->assign('ROW', $row);
            
            if (!empty($row['image'])) {
                $xtpl->parse('main.has_data.loop.has_image');
            } else {
                $xtpl->parse('main.has_data.loop.no_image');
            }
            
            if ($row['can_cancel']) {
                $xtpl->parse('main.has_data.loop.can_cancel');
            } else {
                $xtpl->parse('main.has_data.loop.cannot_cancel');
            }
            
            $xtpl->parse('main.has_data.loop');
        }
        
        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.has_data.gp');
        }
        
        $xtpl->parse('main.has_data');
    } else {
        $xtpl->parse('main.empty');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}