# <a name="_e3wanvacknnk"></a>**BÁO CÁO PHÂN CHIA CÔNG VIỆC**
**Đề tài:** Xây dựng Module Quản lí Thư viện\
**Số thành viên:** 4
## <a name="_lb6udz5zkxzd"></a>**1. Mục tiêu phân chia công việc**
Nhằm đảm bảo tiến độ thực hiện đồ án, tránh tình trạng các thành viên phải chờ đợi lẫn nhau trong quá trình phát triển, nhóm lựa chọn phương pháp phân chia công việc theo trang kết hợp API Contract.

Mục tiêu của phương pháp này:

- Cho phép các thành viên làm việc song song**\

- Giảm phụ thuộc giữa Backend – Frontend – CSDL
- Mỗi thành viên đều có phần việc độc lập, rõ ràng
- Dễ tích hợp, dễ kiểm soát khi hoàn thiện đồ án
## <a name="_usnkntrvkydm"></a>**2. Nguyên tắc phân chia công việc**
Nhóm thống nhất các nguyên tắc sau:

1. Chốt API Contract trước khi code**\

   1. Thống nhất format dữ liệu 
   1. Thống nhất tên field và endpoint
1. Mỗi thành viên phụ trách trọn vẹn một nhóm trang**\

   1. Bao gồm: giao diện + xử lý logic liên quan
1. Sử dụng dữ liệu giả (mock data) trong giai đoạn đầu**\

   1. Không cần chờ Backend hoàn thiện
1. Tích hợp dần theo từng giai đoạn**\


## <a name="_p6axmri9wapf"></a>**3. Danh sách các trang của hệ thống**
### <a name="_k1c0km58z00"></a>**3.1. Ngoài site (User)**

|**STT**|**Tên trang**|
| :-: | :-: |
|1|Trang danh sách sách|
|2|Trang danh sách sách theo thể loại|
|3|Trang chi tiết sách|
|4|Trang mượn sách|
### <a name="_90zq9ylkth7i"></a>**3.2. Trong quản trị (Admin)**

|**STT**|**Tên trang**|
| :-: | :-: |
|5|Trang quản lí sách|
|6|Trang thêm sách|
|7|Trang sửa sách|
|8|Trang quản lí thể loại sách|
|9|Trang quản lí mượn/trả sách|

## <a name="_oud55k8m145y"></a>**4. Phân chia công việc chi tiết cho từng thành viên**
### <a name="_e149i1amx7d0"></a>**4.1. Tổng hợp phân chia**

|**Thành viên**|**Vai trò chính**|**Phạm vi phụ trách**|
| :-: | :-: | :-: |
|Nguyễn Tiến Đạt|User List & Filter|Trang danh sách sách, Trang theo thể loại, Trang lịch sử mượn sách|
|Trần Phú Minh|User Detail & Borrow|Trang chi tiết sách, Trang mượn sách|
|Trần Thế Anh|Admin Books & API|Trang quản lí sách, Thêm/Sửa sách, API khung|
|Đỗ Thị Ngân|Admin Control & QA|Thể loại, Mượn/Trả,Thống kê, Test & Demo|

### <a name="_xxz3mq1bk84e"></a>**4.2. Phân chia chi tiết theo thành viên**
### <a name="_2dzwz2fw7neb"></a>**Nguyễn Tiến Đạt – User List & Filter**

|**Nội dung**|**Mô tả**|
| :-: | :-: |
|Trang phụ trách|Danh sách sách, Sách theo thể loại, Sách đã mượn|
|Công việc|Thiết kế UI, hiển thị danh sách, lọc theo thể loại|
|Dữ liệu|Sử dụng DB|
|Kết quả|2 trang user hiển thị và điều hướng ổn định|

### <a name="_7ggr2c46musa"></a>**Trần Phú Minh – User Detail & Borrow**

|**Nội dung**|**Mô tả**|
| :-: | :-: |
|Trang phụ trách|Chi tiết sách, Mượn sách|
|Công việc|Hiển thị chi tiết, form mượn, validate|
|Dữ liệu|Sử dụng DB|
|Kết quả|Luồng mượn sách phía user hoàn chỉnh|

### <a name="_nutt42ubio09"></a>**Trần Thế Anh – Admin Books & API**

|**Nội dung**|**Mô tả**|
| :-: | :-: |
|Trang phụ trách|Quản lí sách, Thêm/Sửa sách|
|Công việc|CRUD sách, xây API khung|
|Dữ liệu|Cần CSDL mẫu để test nội dung hiển thị|
|Kết quả|Đã tạo 3 trang admin (quản lí sách, thêm sách, sửa sách); cần dữ liệu mẫu để kiểm thử hiển thị|

### <a name="_1vajpp36p8cw"></a>**Đỗ Thị Ngân – Admin Control & QA**

|**Nội dung**|**Mô tả**|
| :-: | :-: |
|Trang phụ trách|Thể loại, Mượn/Trả|
|Công việc|CRUD thể loại, duyệt mượn|
|QA|Test case, demo script|
|Kết quả|Luồng admin + demo ổn định|

**5. Cách phối hợp và tích hợp giữa các thành viên**

|**Giai đoạn**|**Hoạt động**|
| :-: | :-: |
|Giai đoạn 1|Mỗi thành viên làm độc lập BD đã tạo|
|Giai đoạn 2|Kết nối API khung|
|Giai đoạn 3|Tích hợp UI chung|
|Giai đoạn 4|Test toàn hệ thống và hoàn thiện|
## <a name="_pncja2aj9czs"></a>**6. Ưu điểm của phương pháp phân chia**
- Không xảy ra tình trạng chờ đợi lẫn nhau
- Dễ kiểm soát tiến độ từng thành viên
- Tăng hiệu suất làm việc nhóm
- Phù hợp với đồ án có thời gian giới hạn

