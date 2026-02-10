<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC.
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '01/01/2026, 07:15';
$lang_translator['copyright'] = '@Copyright (C) 2010 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

/**
 * Menu / Admin
 */
$lang_module['menu_manager'] = 'Module Library';
$lang_module['library_manager'] = 'Quản lý module thư viện';

$lang_module['config'] = 'Cấu hình';
$lang_module['cat_manager'] = 'Quản lý thể loại';
$lang_module['borrows_manager'] = 'Quản lý mượn trả';

$lang_module['books_manager'] = 'Quản lý sách';
$lang_module['book_add'] = 'Thêm sách';
$lang_module['book_edit'] = 'Sửa sách';
$lang_module['book_delete'] = 'Xóa sách';
$lang_module['api'] = 'API';

// Giữ lại key cũ (nếu chỗ khác còn dùng)
$lang_module['add_new'] = 'Thêm sách';

/**
 * Danh sách / form sách
 */
$lang_module['title'] = 'Tiêu đề';
$lang_module['author'] = 'Tác giả';
$lang_module['category'] = 'Thể loại';
$lang_module['quantity'] = 'Số lượng';
$lang_module['date'] = 'Ngày tạo';
$lang_module['actions'] = 'Thao tác';
$lang_module['search'] = 'Tìm kiếm';
$lang_module['search_books'] = 'Tìm kiếm sách...';
$lang_module['all_categories'] = 'Tất cả thể loại';
$lang_module['all_status'] = 'Tất cả trạng thái';
$lang_module['no_books'] = 'Không có sách nào';
$lang_module['confirm_delete'] = 'Bạn có chắc muốn xóa sách này không?';
$lang_module['image'] = 'Ảnh bìa';
$lang_module['description'] = 'Mô tả';
$lang_module['publisher'] = 'Nhà xuất bản';
$lang_module['isbn_label'] = 'ISBN';
$lang_module['publish_year'] = 'Năm xuất bản';
$lang_module['status'] = 'Trạng thái';
$lang_module['back'] = 'Quay lại';

/**
 * Mượn trả / lịch sử
 */
$lang_module['history'] = 'Lịch sử mượn trả';
$lang_module['book_name'] = 'Tên sách';
$lang_module['borrow_date'] = 'Ngày mượn';
$lang_module['return_date'] = 'Ngày trả';
$lang_module['quantity_available'] = 'Số lượng còn';
$lang_module['no_image'] = 'Không có ảnh';
$lang_module['confirm_cancel'] = 'Bạn có chắc muốn hủy yêu cầu mượn này?';
$lang_module['cancel'] = 'Hủy';

/**
 * Placeholder / UI text
 */
$lang_module['placeholder_title'] = 'VD: Truyện Kiều';
$lang_module['placeholder_author'] = 'VD: Nguyễn Du';
$lang_module['placeholder_category'] = 'Chọn thể loại';
$lang_module['placeholder_isbn'] = 'VD: 978-604-0-12345-6';
$lang_module['placeholder_publish_year'] = 'VD: 2020';
$lang_module['placeholder_publisher'] = 'VD: NXB Giáo Dục';
$lang_module['placeholder_quantity'] = 'VD: 10';
$lang_module['placeholder_image'] = 'Chọn ảnh bìa (jpg, png, gif)';
$lang_module['placeholder_description'] = 'Mô tả ngắn về sách (tùy chọn)';
$lang_module['placeholder_image_edit'] = 'Chọn ảnh bìa mới (jpg, png, gif) để thay thế';
$lang_module['current_image'] = 'Ảnh bìa hiện tại';
$lang_module['save'] = 'Lưu';
$lang_module['reset_filters'] = 'Bỏ lọc';
$lang_module['select_book'] = 'Chọn sách để sửa';
$lang_module['select_book_prompt'] = 'Sách cần sửa';
$lang_module['edit'] = 'Sửa';
$lang_module['status_active'] = 'Kích hoạt';
$lang_module['status_inactive'] = 'Tạm ngưng';
$lang_module['book_add_stock'] = 'Nhập thêm';
$lang_module['quantity_add'] = 'Số lượng nhập thêm';
$lang_module['current_quantity'] = 'Số lượng hiện tại';
$lang_module['quantity_add_invalid'] = 'Số lượng nhập thêm phải lớn hơn 0';

/**
 * API
 */
$lang_module['api_success'] = 'Thành công';
$lang_module['api_error'] = 'Có lỗi xảy ra';
$lang_module['api_invalid_id'] = 'ID không hợp lệ';
$lang_module['api_not_found'] = 'Không tìm thấy dữ liệu';
$lang_module['api_created'] = 'Tạo mới thành công';
$lang_module['api_updated'] = 'Cập nhật thành công';
$lang_module['api_deleted'] = 'Xóa thành công';
$lang_module['api_validation_failed'] = 'Dữ liệu không hợp lệ';
$lang_module['api_invalid_action'] = 'Hành động không hợp lệ';

/**
 * Mượn sách (nếu site dùng)
 */
$lang_module['borrow_book'] = 'Mượn sách';
$lang_module['confirm_borrow'] = 'Bạn có chắc chắn muốn mượn cuốn sách này?';
$lang_module['error_login_required'] = 'Bạn cần đăng nhập để thực hiện chức năng này';
$lang_module['error_no_quantity'] = 'Rất tiếc, sách này đã hết bản cứng trong kho';
$lang_module['error_not_returned'] = 'Bạn phải trả sách cũ hoặc xử lý yêu cầu quá hạn trước khi mượn mới';

$lang_module['status_0'] = 'Chờ duyệt';
$lang_module['status_1'] = 'Đang mượn';
$lang_module['status_2'] = 'Quá hạn';
$lang_module['status_3'] = 'Đã trả';
$lang_module['status_4'] = 'Đã hủy';
