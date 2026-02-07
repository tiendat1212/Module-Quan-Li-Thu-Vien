<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM') && !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

define('NV_IS_MOD_LIBRABYMGT', true);

// list các mảng dùng chung, hoặc hàm dùng chung cho ngoài site

function nv_librarymgt_get_books_list($page = 1, $per_page = 10, $filters = [])
{
    global $db;
    $page = max(1, (int) $page);
    $per_page = max(1, (int) $per_page);
    $offset = ($page - 1) * $per_page;

    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';

    $where = ['1=1'];

    if (isset($filters['status']) && $filters['status'] !== '') {
        $where[] = 'b.status = ' . (int) $filters['status'];
    }

    if (!empty($filters['cat_id'])) {
        $where[] = 'b.cat_id = ' . (int) $filters['cat_id'];
    }

    if (!empty($filters['search'])) {
        $search = '%' . $filters['search'] . '%';
        $search = $db->quote($search);
        $where[] = '(b.title LIKE ' . $search . ' OR b.author LIKE ' . $search . ' OR b.isbn LIKE ' . $search . ')';
    }

    $where_str = implode(' AND ', $where);

    $result = $db->query('SELECT COUNT(*) as count FROM ' . $tb_books . ' b WHERE ' . $where_str);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $total = (int) $row['count'];

    $sort_order = (!empty($filters['sort']) && $filters['sort'] === 'DESC') ? 'DESC' : 'ASC';

    $sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
            LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
            WHERE ' . $where_str . '
            ORDER BY b.id ' . $sort_order . '
            LIMIT ' . $offset . ', ' . $per_page;

    $result = $db->query($sql);
    $books = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $books[] = $row;
    }

    return [
        'total' => $total,
        'books' => $books,
        'page' => $page,
        'per_page' => $per_page
    ];
}

function nv_librarymgt_get_book($book_id)
{
    global $db;
    $book_id = (int) $book_id;

    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';

    $sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
            LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
            WHERE b.id = ' . $book_id;

    $result = $db->query($sql);
    return $result->fetch(PDO::FETCH_ASSOC);
}

function nv_librarymgt_get_categories_list($only_active = true)
{
    global $db;

    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';
    $where = $only_active ? ' WHERE status = 1' : '';
    $sql = 'SELECT id, title FROM ' . $tb_categories . $where . ' ORDER BY weight ASC, id ASC';

    $result = $db->query($sql);
    $categories = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $categories[(int) $row['id']] = $row['title'];
    }

    return $categories;
}