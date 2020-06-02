<?php
// Nạp file kết nối cơ sở dữ liệu
include_once "config.php";

echo "<pre>";
print_r($_POST);
echo "</pre>";


if (isset($_POST["id"]) && ($_POST["id"] > 0)) {
    $id = (int) $_POST["id"];

    $sqlDelete = "DELETE FROM sentences WHERE id=$id";

    if (mysqli_query($connection, $sqlDelete)) {
        echo "Xóa thành công";
        echo"<br><a href='index.php'>Trang chủ</a>";
    } else {
        echo "Error ! " . mysqli_error($connection);
    }

}
