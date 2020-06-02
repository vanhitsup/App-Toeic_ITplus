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

var_dump($id);
$sqlSelect = "SELECT * FROM sentences WHERE sentence_id=".$id;

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
if (isset($_POST) && !empty($_POST) && isset($_POST["sentence_id"])) {

    /**
     * Tạo ra 1 biến để check lỗi mặc định là rỗng
     */
    $errors = array();

    if (!isset($_POST["sentence_example"]) || empty($_POST["sentence_example"])) {
        $errors[] = "Ví dụ không hợp lệ";
    }

    if (!isset($_POST["sentence_translate"]) || empty($_POST["sentence_translate"])) {
        $errors[] = "Ý nghĩa không hợp lệ";
    }

    /**
     * $errors rỗng tức là không có lỗi
     */
    if (empty($errors)) {
        $id = (int) $_POST["sentence_id"];
        $sentence_example = addslashes($_POST['sentence_example']);
        $sentence_translate = $_POST['sentence_translate'];

        $sqlUpdate = "UPDATE sentences SET sentence_example='$sentence_example',sentence_translate='$sentence_translate' WHERE sentence_id=$id";
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
            <h1>Sửa câu ví dụ</h1>
            <form name="edit" action="" method="post">

                <input type="hidden" name="sentence_id" value="<?php echo $row["sentence_id"] ?>">

                <div class="form-group">
                    <label>Câu ví dụ:</label>
                    <textarea class="form-control" name="sentence_example"><?php echo $row["sentence_example"] ?></textarea>
                </div>
                <div class="form-group">
                    <label>Ý nghĩa:</label>
                    <textarea class="form-control" name="sentence_translate"><?php echo $row["sentence_translate"] ?></textarea>
                </div>

                <button type="submit" class="btn btn-warning">Sửa ví dụ</button>
                <a href="index.php" class="btn btn-info">Quay lại</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>