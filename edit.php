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
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

var_dump($id);
$sqlSelect = "SELECT * FROM newwords WHERE id=".$id;

$result = $connection->query($sqlSelect);

$row = $result->fetch_assoc();

echo "<pre>";
print_r($row);
echo "</pre>";
?>




<?php
/**
 * Kiểm tra xem có dữ liệu submit đi hay không
 * !empty($_POST) có nghĩa là không rỗng tức là có dữ liệu trong mảng này
 * isset($_POST) dùng để kiểm tra biến có tồn tại hay không
 */
if (isset($_POST) && !empty($_POST) && isset($_POST["id"])) {

    /**
     * Tạo ra 1 biến để check lỗi mặc định là rỗng
     */
    $errors = array();

    /**
     * !isset($_POST["name"]) => không tồn tại
     *  empty($_POST["name"]) => rỗng
     */
    if (!isset($_POST["newword"]) || empty($_POST["newword"])) {
        $errors[] = "Từ mới không hợp lệ";
    }

    if (!isset($_POST["mean"]) || empty($_POST["mean"])) {
        $errors[] = "Ý nghĩa không hợp lệ";
    }

    if (!isset($_POST["type"]) || empty($_POST["type"])) {
        $errors[] = "Kiểu từ không hợp lệ";
    }

    /**
     * $errors rỗng tức là không có lỗi
     */
    if (empty($errors)) {
        $id = (int) $_POST["id"];
        $newword = $_POST['newword'];
        $mean = $_POST['mean'];
        $type = $_POST['type'];

        $sqlUpdate = "UPDATE newwords SET newword='$newword',mean='$mean',type='$type' WHERE id=$id";
        // Thực hiện câu SQL

        echo $sqlUpdate;
        $result = $connection->query($sqlUpdate);

        if ($result == true) {
            echo "<div class='alert alert-success'>
Sửa thành công ! <a href='index.php'>Trang chủ</a>
</div>";
        } else {
            echo "<div class='alert alert-danger'>
Sua thất bại !
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
            <h1>Sửa từ mới</h1>
            <form name="edit" action="" method="post">

                <input type="hidden" name="id" value="<?php echo $row["id"] ?>">

                <div class="form-group">
                    <label>Từ mới:</label>
                    <input type="text" name="newword" class="form-control" value="<?php echo $row["newword"] ?>">
                </div>
                <div class="form-group">
                    <label>Ý nghĩa:</label>
                    <input type="text" name="mean" class="form-control" value="<?php echo $row["mean"] ?>">
                </div>
                <div class="form-group">
                    <label>Kiểu từ:</label>
                    <input type="text" name="type" class="form-control" value="<?php echo $row["type"] ?>">
                </div>

                <button type="submit" class="btn btn-warning">sửa từ mới</button>
                <a href="index.php" class="btn btn-info">Quay lại</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>