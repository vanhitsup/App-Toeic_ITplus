<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<?php
/**
 * Nạp kết nối CSDL
 */
include_once "config.php";
/**
 * Lấy id từ trên url xuống
 */
$id = (int) $_GET["id"];

$sqlSelect = "SELECT * FROM newwords WHERE id=".$id;

$result = $connection->query($sqlSelect);

$row = $result->fetch_assoc();


?>

<?php
/**
 * Kiểm tra xem có dữ liệu submit đi hay không
 * !empty($_POST) có nghĩa là không rỗng tức là có dữ liệu trong mảng này
 * isset($_POST) dùng để kiểm tra biến có tồn tại hay không
 */
if (isset($_POST) && !empty($_POST) && isset($_POST["employee_id"])) {

    /**
     * Tạo ra 1 biến để check lỗi mặc định là rỗng
     */
    $errors = array();

    /**
     * !isset($_POST["name"]) => không tồn tại
     *  empty($_POST["name"]) => rỗng
     */
    if (!isset($_POST["id"]) || empty($_POST["id"])) {
        $errors[] = "ID khong hop le";
    }

    /**
     * $errors rỗng tức là không có lỗi
     */
    if (empty($errors)) {
        $id = (int) $_POST["id"];

        $sqlDelete = "DELETE FROM newwords WHERE id=$id";
        // Thực hiện câu SQL

        $result = $connection->query($sqlDelete);

        if ($result == true) {
            echo "<div class='alert alert-success'>
Xóa thành công ! <a href='index.php'>Trang chủ</a>
</div>";
        } else {
            echo "<div class='alert alert-danger'>
Xóa thất bại !
</div>";
        }


    }else{
        /**
         * Chuyển mảng $errors thành chuỗi = hàm implode()
         */
        $errors_string = implode("<br>", $errors);
        echo "<div class='alert alert-danger'>$errors_string</div>";
    }


}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Xóa từ mới</h1>
            <form name="delete" action="remove.php" method="post">

                <input type="hidden" name="id" value="<?php echo $row["id"] ?>">

                <div class="form-group">
                    <label>Từ mới: <?php echo $row["newword"] ?></label>
                </div>
                <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                <a href="index.php" class="btn btn-warning">Quay lại</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>