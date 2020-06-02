<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<?php
// nạp file kết nối CSDL
include_once "config.php";

$newword = "";
$mean = "";
$type = "";

/**
 * Kiểm tra xem có dữ liệu submit đi hay không
 * !empty($_POST) có nghĩa là không rỗng tức là có dữ liệu trong mảng này
 * isset($_POST) dùng để kiểm tra biến có tồn tại hay không
 */
if (isset($_POST) && !empty($_POST)) {

    /**
     * Tạo ra 1 biến để check lỗi mặc định là rỗng
     */
    $errors = array();

    /**
     * !isset($_POST["name"]) => không tồn tại
     *  empty($_POST["name"]) => rỗng
     */
    if (!isset($_POST["newword"]) || empty($_POST["newword"])) {
        $errors[] = "Từ vựng không hợp lệ";
    }

    if (!isset($_POST["mean"]) || empty($_POST["mean"])) {
        $errors[] = "Nghĩa của từ không hợp lệ";
    }

    if (!isset($_POST["type"]) || empty($_POST["type"])) {
        $errors[] = "Kiểu từ không hợp lệ";
    }

    /**
     * $errors rỗng tức là không có lỗi
     */
    if (empty($errors)) {

        $newword = $_POST['newword'];
        $mean = $_POST['mean'];
        $type = $_POST['type'];

        $sqlInsert = "INSERT INTO newwords (newword, mean, type) VALUES ('$newword', '$mean', '$type')";

        // Thực hiện câu SQL
        $result = $connection->query($sqlInsert);

        if ($result == true) {
            echo "<div class='alert alert-success'>
Thêm từ mới thành công ! <a href='index.php'>Trang chủ</a>
</div>";
        } else {
            echo "<div class='alert alert-danger'>
Thêm từ mới thất bại !
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
            <h1>Tạo từ mới</h1>
            <form name="create" action="" method="post">
                <div class="form-group">
                    <label>Từ mới:</label>
                    <input type="text" name="newword" class="form-control" value="<?php echo $newword ?>">
                </div>
                <div class="form-group">
                    <label>Ý nghĩa:</label>
                    <input type="text" name="mean" class="form-control" value="<?php echo $mean ?>">
                </div>
                <div class="form-group">
                    <label>Từ loại:</label>
                    <input type="text" name="type" class="form-control" value="<?php echo $type ?>">
                </div>

                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="index.php" class="btn btn-warning">Quay lại</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>