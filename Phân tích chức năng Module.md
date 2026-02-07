# <a name="_5gon2jxyrwhb"></a>Phân tích chức năng
## <a name="_iy4o8159bxzh"></a>1. Mục tiêu
Xây dựng module quản lý thư viện trong hệ thống Nukeviet với các mục tiêu:

- Quản lý sách và phân loại theo thể loại
- Hỗ trợ admin quản lý sách trong thư viện và quản lý mượn trả sách

Module góp phần:

- Giảm thao tác thủ công trong quản lý thư viện
- Tăng khả năng tiếp cận thông tin cho người dùng
- Chuẩn hóa quy trình mượn sách trong hệ thống
## <a name="_1geuj7sb7hgv"></a>2. Phạm vi áp dụng
Module được áp dụng cho hai nhóm đối tượng chính:
## <a name="_767ghvexsdkp"></a>2.1. Đối tượng sử dụng
- **User** (người dùng, thao tác ngoài site chính): cần đăng nhập tài khoản, thao tác xem và gửi yêu cầu mượn.
- **Admin** (quản trị viên, thao tác trong trang quản trị Nukeviet, ở đây có thể gọi là thủ thư): cần sử dụng tài khoản với chức vụ quản trị, thao tác quản lý sách, quản lý mượn trả sách.
## <a name="_9fqgbjeq8i3q"></a>2.2. Chức năng
Đối với User:

- Truy cập thư viện sách
- Xem danh sách lọc theo thể loại
- Tìm kiếm sách theo tiêu đề, tác giả
- Xem lịch sử mượn và trạng thái yêu cầu mượn sách

Đối với Admin:

- Quản lý thể loại, sách (thêm, sửa, xoá)
- Quản lý mượn/trả sách (duyệt/huỷ yêu cầu mượn, xác nhận đã trả sách)
## <a name="_x1luk8d3uih2"></a>2.3. Ngoài phạm vi
Module không gồm các tính năng sau (có thể phát triển thêm trong tương lai):

- Cơ chế thanh toán, thông báo đến hạn trả với người dùng

## <a name="_dd9y0zf7vqw0"></a>3. Quy tắc chính
## <a name="_15ukp3sxj8s0"></a>3.1. Quy tắc về sách và thể loại
- Mỗi sách thuộc 1 thể loại chính
- Khi thêm sách mới vào thư viện nếu có thể loại mới thì cần thêm thể loại trước khi thêm sách; nếu muốn xoá thể loại thì trong thể loại đó không được có sách nào
## <a name="_hk7onsbj0k3"></a>3.2. Quy tắc mượn sách
- Người dùng sử dụng tài khoản hệ thống để mượn sách
- ` `Chỉ có thể mượn sách khi số lượng sách trong thư viện là có sẵn, nếu sách đã được cho mượn hết thì sẽ từ chối và hiện “Sách đã hết”
- Thời gian mượn sách mặc định là 7 ngày kể từ ngày mượn
- Người dùng cần trả sách đã mượn trước khi mượn sách mới
## <a name="_12f0mzz0hk9n"></a>3.4. Quy tắc trạng thái của yêu cầu mượn
- “Chờ duyệt”: yêu cầu được gửi từ người dùng đến admin
- “Đã huỷ”: admin từ chối duyệt yêu cầu
- “Đang mượn”: admin duyệt yêu cầu mượn sách
- “Đã trả”: admin xác nhận người dùng đã trả sách
- “Quá hạn”: đã quá thời hạn mượn (7 ngày kể từ ngày mượn) , mà người dùng chưa trả sách hoặc trả quá ngày hẹn

Mapping trạng thái trong CSDL:
- 0: Chờ duyệt
- 1: Đang mượn
- 2: Đã trả
- 3: Đã huỷ
- 4: Quá hạn
## <a name="_i2ox0wioqj6g"></a>3.5. Quy tắc quản lý mượn/trả sách
- Khi người dùng hoàn thành gửi yêu cầu mượn sách thì yêu cầu mượn sẽ được hình thành trong danh sách quản lý mượn/trả sách của quản trị và trạng thái ở “Chờ duyệt”
- Admin có thể thao tác với danh sách yêu cầu mượn:

o   Duyệt yêu cầu thì sẽ chuyển yêu cầu mượn đó sang trạng thái “Đang mượn”

o   Huỷ thì sẽ yêu cầu đó sẽ chuyển sang trạng thái “Đã huỷ”

o   Xác nhận đã trả sách thì yêu cầu đó sẽ chuyển trang trạng thái “Đã trả” và lưu về hệ thống

- ` `Khi sách được xác nhận là đã trả:

o   Yêu cầu mượn vẫn tồn tại trong danh sách yêu cầu mượn

o   Số lượng sách trong thư viện sẽ được cộng trả lại

- Nếu quá hạn 7 ngày kể từ ngày mượn, trạng thái sẽ chuyển sang “Quá hạn”
- Tất cả các yêu cầu dù admin thực hiện chức năng gì thì vẫn được lưu trữ lại trong danh sách yêu cầu

## <a name="_2wpk0ty7lfyz"></a>4. Tính năng chính
## <a name="_qr6q4joa6k9q"></a>4.1. Ngoài site
### <a name="_3fwwxwq1nja"></a>4.1.1. Trang Danh Sách
- Hiển thị toàn bộ sách có trong thư viện (có phân trang)
- Người dùng có thể tìm sách theo từ khóa tìm kiếm, thể loại hoặc trạng thái
- Ấn vào 1 cuốn sách để chuyển sang Trang thông tin chi tiết sách của cuốn sách đó
### <a name="_pw5pw41m01wa"></a>4.1.2. Trang thông tin chi tiết sách
- Hiển thị các thông tin về cuốn sách đó: Tên, tác giả, thể loại, mô tả, số lượng hiện có,...
- Ấn vào “Mượn sách” để gửi yêu cầu mượn sách đến admin và chuyển hướng đến Trang lịch sử mượn sách
- Nếu sách đó đang trong tình trạng không có sẵn trong thư viện hoặc người dùng chưa trả sách đã mượn thì nút mượn bị vô hiệu hoá và hiển thị tooltip với nội dung “Sách không có sẵn/Người dùng chưa trả sách”
### <a name="_2qu47pt06ass"></a>4.1.3. Trang lịch sử mượn sách
- Trang hiển thị dưới dạng danh sách gồm các cột: STT- Tên sách - Ngày mượn - Ngày trả - Trạng thái
- Có phân trang 
## <a name="_j3vxaut1t504"></a>4.2. Trong quản lý
### <a name="_5keu22vqoihw"></a>4.2.1. Trang quản lý thể loại
- Hiển thị danh sách các thể loại sách hiện có
- Có các nút lựa chọn: “Thêm thể loại” (ở trên góc phải màn hình); “Sửa”, “Xóa” (thuộc cột thao tác của từng thể loại trong danh sách)
- Khi chọn “thêm thể loại” sẽ hiển thị 1 cửa sổ để người dùng điền tên thể loại mới sau đó nhấn OK để thêm
- Khi chọn “Sửa” sẽ hiển thị 1 cửa sổ để người dùng sửa thông tin của thể loại thể loại sau đó nhấn OK để xác nhận sửa
- Khi chọn “Xóa” sẽ hiển thị 1 cửa sổ xác nhận “Bạn có muốn xóa thể loại này không?” có thể chọn OK hoặc CANCEL
### <a name="_8uz7g2g7b98u"></a>4.2.2. Trang quản lý sách
- Hiển thị toàn bộ sách có trong thư viện dưới dạng danh sách
- Có các nút lựa chọn: “Thêm sách” (ở trên góc phải màn hình); “Sửa”, “Xóa” (thuộc cột thao tác của từng thể loại trong danh sách)
- Khi chọn “Thêm sách” sẽ chuyển đến Trang thêm sách mới
- Khi chọn “Sửa” sẽ chuyển đến Trang sửa thông tin sách
- Khi chọn “Xoá” sẽ hiển thị 1 cửa sổ xác nhận “Bạn có muốn xóa sách này không?” có thể chọn OK hoặc CANCEL
### <a name="_yx7fun1o4f2s"></a>4.2.3. Trang thêm sách mới
- Thêm sách mới theo hình thức form
- Admin có thể thêm sách mới bằng cách điền các thông tin của sách: Tiêu đề, tác giả, chọn thể loại có sẵn, upload bìa, điền số lượng nhập vào thư viện; phần mô tả có thể viết hoặc không
- Sau khi hoàn thành Admin chọn “Thêm sách vào thư viện”, thêm thành công sẽ chuyển về Trang quản lý sách
- Nếu chưa điền đầy đủ các thông tin cần thiết đã nêu thì sẽ hiển thị Alert thông báo lỗi
### <a name="_7ko8xedjfl"></a>4.2.4. Trang sửa thông tin sách
- Trả lại dạng form tương tự như Trang thêm sách mới, nhưng lúc này các thông tin đã hiển thị chính là các thông tin đã điền khi thêm sách
- Sau khi hoàn thành Admin chọn “Cập nhật”, cập nhật thành công sẽ chuyển về Trang quản lý sách nếu thành công
- Các dữ liệu đã điền ở lần sửa này sẽ được cập nhật vào CSDL và sẽ là thông tin hiển thị ở lần Sửa tiếp theo
- Trang “Thêm sách” chỉ dùng khi sách mới hoàn toàn
- Nếu sách đã tồn tại → admin bấm “Nhập thêm” (ở góc trên bên phải) và nhập số lượng tăng thêm
### <a name="_enqejo1vrikq"></a>4.2.5. Trang quản lý mượn/trả sách
- Trang hiển thị các yêu cầu mượn sách dưới dạng danh sách
- Các yêu cầu được gửi thành công từ người dùng ở mục 4.1.3. sẽ hiển thị với trạng thái “Chờ duyệt”, khi này ở cuối dòng sẽ hiện nút “Duyệt” và “Huỷ”
- Khi Admin chọn “Huỷ” thì yêu cầu mượn sách sẽ không được chấp nhận, chuyển sang trạng thái “Đã huỷ” và lưu vào danh sách
- Khi 1 yêu cầu mượn sách được duyệt thì trạng thái của nó sẽ chuyển sang “Đang mượn” và ở cuối dòng sẽ hiện nút “Xác nhận trả”
- Khi Admin chọn “Xác nhận trả” thì yêu cầu mượn sách sẽ được cập nhật trạng thái “Đã trả”.
- Khi người dùng mượn sách quá hạn ngày trả, yêu cầu mượn sẽ hiển thị trạng thái “Quá hạn”


5\. Phân quyền

|**Nhóm người dùng**|**Xem danh sách**|<p>**Thêm/**</p><p>**Sửa**</p>|**Xoá**|**Mượn sách**|**Duyệt mượn**|
| :-: | :-: | :-: | :-: | :-: | :-: |
|Admin|✅|✅|✅|❌|✅|
|User|✅|❌|❌|✅|❌|

6\. Thiết kế cơ sở dữ liệu

Cấu trúc cơ sở dữ liệu như sau:

![](Aspose.Words.85ac217c-d757-43f9-806b-aadd4372b795.001.png)

Chi tiết các bảng (theo schema hiện tại):

- <prefix>_<lang>_<module_data>_categories

|Field|Kiểu dữ liệu|Mô tả|
| :- | :- | :- |
|id|INT (PK)|id của thể loại|
|title|varchar|tên thể loại|
|alias|varchar|định danh, duy nhất|
|description|TEXT|mô tả|
|weight|SMALLINT|thứ tự sắp xếp|
|status|TINYINT|trạng thái hoạt động|
|add_time|INT|thời gian tạo (unix timestamp)|
|edit_time|INT|thời gian cập nhật (unix timestamp)|



- <prefix>_<lang>_<module_data>_books

|Field|Kiểu dữ liệu|Mô tả|
| :- | :- | :- |
|id|INT (PK)|id của sách|
|cat_id|INT (FK)|id thể loại|
|title|varchar|tên sách|
|alias|varchar|định danh, duy nhất|
|author|varchar|tác giả|
|publisher|varchar|nhà xuất bản|
|publish_year|SMALLINT|năm xuất bản|
|isbn|varchar|mã ISBN|
|quantity|INT|số lượng sách trong thư viện|
|description|MEDIUMTEXT|mô tả|
|image|varchar|đường dẫn ảnh bìa|
|status|TINYINT|trạng thái hiển thị|
|add_time|INT|thời gian tạo (unix timestamp)|
|edit_time|INT|thời gian cập nhật (unix timestamp)|



- users là bảng sẵn có trong hệ thống
- <prefix>_<lang>_<module_data>_borrows

|Field|Kiểu dữ liệu|Mô tả|
| :- | :- | :- |
|id|INT (PK)|id của yêu cầu mượn|
|book_id|INT (FK)|id sách được mượn|
|user_id|INT (FK)|id người mượn|
|request_date|DATETIME|thời gian gửi yêu cầu|
|approve_date|DATETIME|thời gian duyệt|
|borrow_date|DATETIME|thời gian bắt đầu mượn|
|due_date|DATETIME|hạn trả dự kiến (7 ngày)|
|return_date|DATETIME|thời gian trả thực tế|
|status|TINYINT|trạng thái theo mapping mục 3.4|
|note_user|varchar|ghi chú từ user|
|note_admin|varchar|ghi chú từ admin|



7\. Luồng xử lý
#### ` `**7.1. Logic xử lý**
#### <a name="_nibfs7hghpmh"></a>**Đối với User ngoài site**

|<h4>**Bước**</h4>|<h4>**Mô tả**</h4>|
| :-: | :-: |
|<h4>1</h4>|<h4>User truy cập trang thư viện</h4>|
|<h4>2</h4>|<h4>Xem danh sách hoặc chọn thể loại</h4>|
|<h4>3</h4>|<h4>Xem chi tiết sách</h4>|
|<h4>4</h4>|<h4>Gửi yêu cầu mượn sách</h4>|
####
#### <a name="_errq7ro02dv"></a>**Đối với Admin**

|<h4>**Bước**</h4>|<h4>**Mô tả**</h4>|
| :-: | :-: |
|<h4>1</h4>|<h4>Admin đăng nhập</h4>|
|<h4>2</h4>|<h4>Quản lý sách / thể loại</h4>|
|<h4>3</h4>|<h4>Xem danh sách mượn</h4>|
|<h4>4</h4>|<h4>Duyệt hoặc từ chối yêu cầu</h4>|
####
### <a name="_t52ec3wxlbv0"></a>7.2. Luồng thiết kế màn hình
#### <a name="_u83qpaeiyjms"></a>7.2.1. Trong Admin
- #### Trang quản lý sách
- #### Trang thêm / sửa sách
- #### Trang quản lý thể loại
- #### Trang quản lý mượn sách
#### <a name="_u09icb7xqsz"></a>7.2.2. Ngoài site
- #### Trang danh sách sách
- #### Trang sách theo thể loại
- #### <a name="_1up2u34k1t7"></a>Trang chi tiết sách
- Trang lịch sử mượn sách
