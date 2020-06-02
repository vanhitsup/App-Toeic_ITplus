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

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$sentence_example = "";
$sentence_translate = "";

$sqlSelect = "SELECT * FROM newwords WHERE id=".$id;

$newwordResult = $connection->query($sqlSelect);

$newword = $newwordResult->fetch_assoc();

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
    if (!isset($_POST["sentence_example"]) || empty($_POST["sentence_example"])) {
        $errors[] = "Câu không hợp lệ";
    }

    if (!isset($_POST["sentence_translate"]) || empty($_POST["sentence_translate"])) {
        $errors[] = "Nghĩa của câu không hợp lệ";
    }

    if (!isset($_POST["newword_id"]) || empty($_POST["newword_id"])) {
        $errors[] = "Từ mới không hợp lệ";
    }

    /**
     * $errors rỗng tức là không có lỗi
     */
    if (empty($errors)) {

        $sentence_example = $_POST['sentence_example'];
        $sentence_translate = $_POST['sentence_translate'];
        $newword_id = (int)$_POST['newword_id'];

        $sqlInsert = "INSERT INTO sentences (sentence_example, sentence_translate, newword_id) VALUES ('$sentence_example', '$sentence_translate', '$newword_id')";

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
            <h1>Tạo ví dụ cho từ : "<?php echo $newword["newword"] ?>"</h1>
            <form name="create" action="" method="post">
                <input type="hidden" name="newword_id" value="<?php echo $id ?>">

                <div class="form-group">
                    <label>Câu ví dụ:</label>
                    <textarea class="form-control" name="sentence_example"><?php echo $sentence_example ?></textarea>
                </div>
                <div class="form-group">
                    <label>Ý nghĩa:</label>
                    <textarea class="form-control" name="sentence_translate"><?php echo $sentence_translate ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="index.php" class="btn btn-warning">Quay lại</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>