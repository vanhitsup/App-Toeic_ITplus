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
$id = (int) $_GET["id"];
$sqlSelect = "SELECT * FROM newwords WHERE id=".$id;
$newwordResult = $connection->query($sqlSelect);
$newword = $newwordResult->fetch_assoc();
$sqlSelectSentence = "SELECT * FROM sentences WHERE newword_id='$id'";
$result = $connection->query($sqlSelectSentence);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Liệt kê ví dụ cho từ : "<?php echo $newword["newword"] ?>"</h1>
            <h1>
                <a href="createsentence.php?id=<?php echo $id ?>" class="btn btn-success">Thêm ví dụ</a>
                <a href="index.php" class="btn btn-success">Quay lại </a>
            </h1>
            <table class="table">
                <thead>
                <tr>

                    <th>ID</th>
                    <th>Ví dụ</th>
                    <th>Nghĩa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /**
                 * Nếu $result->num_rows > 0 tức là có dữ liệu trong bảng
                 * ngược lại là bảng đang rỗng
                 */
                if (isset($result) &&  $result->num_rows > 0) {
                    /*
                     * Sử dụng $result->fetch_assoc() để lấy về từng dòng bản ghi trong bảng
                     * và trả về cho biến $row
                     */

                    while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>

                            <td><?php echo $row["sentence_id"] ?></td>
                            <td><?php echo $row["sentence_example"] ?></td>
                            <td><?php echo $row["sentence_translate"] ?></td>
                            <td>
                                <p><a href="editsentence.php?id=<?php echo $row["sentence_id"] ?>" class="btn btn-warning">Sửa ví dụ</a>
                                    <a href="deletesentence.php?id=<?php echo $row["sentence_id"] ?>" class="btn btn-danger">Xóa ví dụ</a> </p>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "Không tồn tại từ nào";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>