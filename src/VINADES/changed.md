# 04/02/2026 by Thế Anh: 

2:53 PM: Cập nhật librarymgt schema docs và admin routing/menu/lang
- src/modules/librarymgt/admin.functions.php: sửa admin func và thêm 'books', 'book_add', 'book_edit', 'book_delete', 'api'
- src/modules/librarymgt/admin.menu.php: sửa submenu
- src/modules/librarymgt/version.php: sửa version
- src/modules/librarymgt/language/vi.php: thêm định nghĩa $lang_moudule cơ bản
- src/modules/librarymgt/admin/main.php: định nghĩa Trang quản lý chính bao gồm: hiển thị danh sách sách, xử lý bộ lọc và tìm kiếm, xử lý phân trang, các hành động (xóa, sửa, thêm sách), render giao diện

7:10 PM: Tạo CRUD sách
- src/modules/librarymgt/admin.functions.php: thêm các hàm lấy danh sách sách với phân trang, lọc, chi tiết sách, Validate dữ liệu sách, Tạo alias từ tiêu đề, Thêm sách mới, cập nhật sách, xóa sách.

Thêm 2 file docx Phân tích chức năng module và Phân chia công việc

7:18 PM: Gỡ 2 file docx

9:06 - 10:28 PM: Sửa các vấn đề trong module - Thêm URLs đầy đủ trong book_edit.php - Thêm nút 'Nhập thêm' và 'Thêm sách' trong template - Thêm menu item book_edit - Thêm dữ liệu mẫu để test hiển thị và cập nhật Trang quản lý sách
- src/modules/librarymgt/admin.menu.php: sửa submenu
- src/modules/librarymgt/language/vi.php: thêm định nghĩa $lang_moudule cho Trang quản lý sách và thêm sách
- src/modules/librarymgt/admin.functions.php: sửa lỗi hiện thị thông tin và hiển thị dữ liệu mẫu

# 05/02/2026 by Thế Anh: Tái cấu trúc admin

12:14 AM: Chỉnh sửa lại cấu trúc thư mục để đồng bộ UI (do lỗi không hiện thị tên trường nên nghỉ để dành thời gian sáng họp hỏi chị Ngân)

11:04 AM: Chỉnh sửa cấu trúc thư mục, thêm dữ liệu mẫu cho trang quản lý sách để nhập trên phpmyadmin nhưng không thành công 
- src/modules/librarymgt/admin.functions.php: viết lại các hàm theo định dạng nv_ ('nv_get_books_list', 'nv_get_categories_list', 'nv_validate_book', 'nv_create_alias', 'nv_insert_book', 'nv_update_book', 'nv_delete_book')
- src/modules/librarymgt/admin.menu.php: đồng bộ logic trang chính admin module với submenu Quản lý sách

Gỡ bỏ dữ liệu mẫu trên phpmyadmin

11:15 - 11:21 AM: Thêm trang thêm sách và tích hợp thêm điều hướng cho trang quản lý sách - Chỉnh sửa thứ tự id chuẩn khi thêm mới sách
$sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
            LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
            WHERE ' . $where_str . '
            ORDER BY b.add_time DESC -> ORDER BY b.id ASC
            LIMIT ' . $offset . ', ' . $per_page;

11:27 AM: Thêm khả năng xem sách theo thứ tự id
    $sort_order = (!empty($filters['sort']) && $filters['sort'] === 'DESC') ? 'DESC' : 'ASC';
ORDER BY b.id ASC -> ORDER BY b.id ' . $sort_order . '

11:34 AM: feat: add book edit page with form and template - thêm trang sửa sách
- src/modules/librarymgt/admin.functions.php: thêm hàm lấy thông tin chi tiết sách 'nv_get_book' - điều hướng sang trang sửa sách khi nhấn nút "sửa" trong trang quan lý sách của mỗi sách
- src/modules/librarymgt/admin/book_edit.php: tạo form cho trang sửa sách 
- src/themes/admin_default/modules/librarymgt/book_edit.tpl: UI cho trang sửa sách

Cập nhật thêm $lang_module cho trang sửa sách

11:49 AM: Thêm logic cho trang sửa sách
- src/modules/librarymgt/admin/book_edit.php: thêm tính năng chọn sách để sửa và có thể chọn dến trực tiếp trang sửa sách trong submenu
- src/themes/admin_default/modules/librarymgt/book_edit.tpl: cập nhật thêm UI chọn sách để sửa

10:37 PM: Chuẩn hóa dữ liệu và thêm API khung
- src/modules/librarymgt/admin.functions.php: thêm hàm chuẩn hóa dữ liệu 'nv_normalize_book_template_data'

Thực hiện chuẩn hóa dữ liệu với các trường ở trong các trang và tạp thêm file api.php - khung API

# 06/02/2026 by Thế Anh: Cập nhật hàm riêng và dùng chung của admin và ngoài site
Các hàm dung chung có định dạng: nv_librarymgt_
Các hàm dùng riêng cho admin có định dạng: nv_admin_

# 08/02/2026 by Thế Anh: Sửa lỗi không push trang thêm sách
- Sửa file .gitignore do thêm "/src" trong ngày 04/02/2026 7:18 PM (không rõ tại sao các file khác vẫn push được)
- Push src/modules/librarymgt/admin/book_add.php, src/themes/admin_default/modules/librarymgt/book_add.tpl,  src/themes/admin_default/modules/librarymgt/main.tpl,
src/modules/librarymgt/funcs/api.php và file dữ liệu mẫu sample_data.sql

# 08/02/2026 by Thế Anh: Tổng quan module Quản lý thư viện (librarymgt)

Phân hệ module
- src/modules/librarymgt/action_mysql.php: tạo/xóa bảng (thể loại, sách, mượn trả) và dữ liệu mẫu.
- src/modules/librarymgt/functions.php: hàm dùng chung lấy danh sách sách, chi tiết sách, danh sách thể loại (có filter).
- src/modules/librarymgt/version.php: thông tin module (chức năng, phiên bản, uploads, icon).
- src/modules/librarymgt/theme.php: render danh sách sách, lọc thể loại, phân trang.
- src/modules/librarymgt/language/vi.php: ngôn ngữ module (VI).
- src/modules/librarymgt/sample_data.sql: dữ liệu mẫu cho thể loại và sách.
- src/modules/librarymgt/index.html: bảo vệ thư mục.

Frontend (site)
- src/modules/librarymgt/funcs/main.php: trang danh sách sách có tìm kiếm, lọc thể loại, phân trang, link chi tiết.
- src/modules/librarymgt/funcs/api.php: API JSON (list/detail) có filter, phân trang, image_url.
- src/modules/librarymgt/funcs/index.html: bảo vệ thư mục.

Admin
- src/modules/librarymgt/admin.functions.php: helper cho admin (list/get, validate, tạo alias, insert/update/delete).
- src/modules/librarymgt/admin.menu.php: menu admin (quản lý sách/thêm/sửa).
- src/modules/librarymgt/admin/main.php: danh sách admin (lọc, xóa, phân trang).
- src/modules/librarymgt/admin/book_add.php: form thêm sách, validate, upload ảnh.
- src/modules/librarymgt/admin/book_edit.php: form sửa sách, thay ảnh, chọn sách.
- src/modules/librarymgt/admin/index.html: bảo vệ thư mục.

Templates - site
- src/themes/default/modules/librarymgt/books_list.tpl: UI danh sách sách (thể loại, bảng, phân trang).
- src/themes/default/modules/librarymgt/main.tpl: layout trang chính.
- src/themes/default/modules/librarymgt/detail.tpl: layout chi tiết.
- src/themes/default/modules/librarymgt/index.html: bảo vệ thư mục.

Templates - admin
- src/themes/admin_default/modules/librarymgt/main.tpl: UI danh sách admin.
- src/themes/admin_default/modules/librarymgt/book_add.tpl: UI form thêm.
- src/themes/admin_default/modules/librarymgt/book_edit.tpl: UI form sửa.
- src/themes/admin_default/modules/librarymgt/detail.tpl: UI chi tiết admin.
- src/themes/admin_default/modules/librarymgt/index.html: bảo vệ thư mục.
- src/themes/admin_future/modules/librarymgt/main.tpl: UI danh sách admin (admin_future).


