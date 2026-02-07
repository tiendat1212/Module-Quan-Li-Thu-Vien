-- Sample data for Library Management module (admin books list)
-- Adjust prefix/lang if your setup differs

-- Categories
INSERT INTO nv5_vi_librarymgt_categories (title, alias, description, weight, status, add_time, edit_time) VALUES
('Văn học', 'van-hoc', 'Sách văn học', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Khoa học', 'khoa-hoc', 'Sách khoa học', 2, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Thiếu nhi', 'thieu-nhi', 'Sách thiếu nhi', 3, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Công nghệ', 'cong-nghe', 'Sách công nghệ', 4, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- Books
INSERT INTO nv5_vi_librarymgt_books (cat_id, title, alias, author, publisher, publish_year, isbn, quantity, description, image, status, add_time, edit_time) VALUES
(1, 'Truyện Kiều', 'truyen-kieu', 'Nguyễn Du', 'NXB Văn Học', 2019, '9786040000001', 12, 'Tác phẩm kinh điển của văn học Việt Nam', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(1, 'Dế Mèn Phiêu Lưu Ký', 'de-men-phieu-luu-ky', 'Tô Hoài', 'NXB Kim Đồng', 2020, '9786040000002', 8, 'Tác phẩm thiếu nhi nổi tiếng', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Lược sử thời gian', 'luoc-su-thoi-gian', 'Stephen Hawking', 'NXB Trẻ', 2018, '9786040000003', 5, 'Khái quát về vũ trụ học', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Vũ trụ trong vỏ hạt dẻ', 'vu-tru-trong-vo-hat-de', 'Stephen Hawking', 'NXB Trẻ', 2017, '9786040000004', 4, 'Tiếp nối Lược sử thời gian', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 'Cây khế', 'cay-khe', 'Dân gian', 'NXB Kim Đồng', 2016, '9786040000005', 15, 'Truyện cổ tích Việt Nam', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 'Tấm Cám', 'tam-cam', 'Dân gian', 'NXB Kim Đồng', 2016, '9786040000006', 10, 'Truyện cổ tích Việt Nam', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'Clean Code', 'clean-code', 'Robert C. Martin', 'Prentice Hall', 2008, '9780132350884', 6, 'Kỹ thuật viết code sạch', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'The Pragmatic Programmer', 'the-pragmatic-programmer', 'Andrew Hunt, David Thomas', 'Addison-Wesley', 1999, '9780201616224', 7, 'Lập trình thực dụng', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
