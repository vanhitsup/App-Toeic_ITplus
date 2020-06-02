<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
</head>
<body>
<?php
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$linkSearch = "search.php?search=$search";
// nạp file kết nối CSDL
include_once "config.php";
if (strlen($search) > 0) {
    $sqlSelect = "SELECT * FROM newwords WHERE newword LIKE '%$search%' ORDER BY newword";
    /**
     * Thực hiện câu truy vấn và trả data cho biến $newwordList
     */
    $newwordList = $connection->query($sqlSelect);
} else {
    $sqlSelect = "SELECT * FROM newwords ORDER BY newword";
    /**
     * Thực hiện câu truy vấn và trả data cho biến $newwordList
     */
    $newwordList = $connection->query($sqlSelect);
}
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
if ($id > 0) {
    $sqlSelect2 = "SELECT * FROM newwords WHERE id = ".$id;
    /**
     * Thực hiện câu truy vấn và trả data cho biến $result
     */
    $mean = $connection->query($sqlSelect2);
}
if ($id > 0) {
    $sqlSelect3 = "SELECT * FROM sentences WHERE newword_id = ".$id;
    /**
     * Thực hiện câu truy vấn và trả data cho biến $result
     */
    $sentences = $connection->query($sqlSelect3);
}
?>

<div class="container">
    <div class="row" style="margin-top: 50px">
        <img src="toeic.png">

    </div>
    <div class="row" style="margin-top: 50px">
        <h1>Ứng dụng từ điển TOEIC</h1>
        <p style="margin-left: 30px"><a href="index.php" class="btn btn-info">Quản lý từ vựng</a></p>
    </div>
    <div class="row" style="margin: 50px 0; border: 1px solid gray">

        <div class="col-md-4" style="border-right: 1px solid gray">
            <div class="col-md-12" style="padding: 30px 0">
                <form action="search.php" name="" method="get">
                    <input type="text" name="search" value="<?php echo $search ?>" placeholder="Nhập từ muốn tra cứu">
                    <input type="submit" name="translate" class="btn btn-info" value="Tìm kiếm">
                    <a href="#" class="btn btn-warning" id="reset">Xóa</a>
                </form>
            </div>
            <div class="col-md-12" style="max-height: 600px;overflow: auto">
                <?php
                /**
                 * Nếu $newwordList->num_rows > 0 tức là có dữ liệu trong bảng
                 * ngược lại là bảng đang rỗng
                 */
                if (isset($newwordList) && $newwordList->num_rows > 0) {
                    /*
                     *
                     * Sử dụng $newwordList->fetch_assoc() để lấy về từng dòng bản ghi trong bảng
                     * và trả về cho biến $row
                     */
                    while($row = $newwordList->fetch_assoc()) {
                        ?>
                        <div class="col-md-12"><a href="<?php echo $linkSearch."&id=".$row["id"] ?>">+ <?php echo $row["newword"] ?></a></div>
                        <?php
                    }
                } else {
                    ?> <div class="alert alert-danger"><?php echo "Không tìm thấy từ vựng nào"; ?></div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-md-8">
            <?php
            if ($id > 0) {
                if (isset($mean)) {
                    $meanWord = $mean->fetch_assoc();
                    ?>
                    <div class="alert alert-info"><h3>Từ mới : <?php echo $meanWord["newword"]; ?></h3></div>
                    <div class="alert alert-info">Nghĩa của từ : <?php echo $meanWord["mean"]; ?></div>
                    <?php
                }
            }

            ?>
            <?php
            if ($id > 0) {
                /**
                 * Nếu $result->num_rows > 0 tức là có dữ liệu trong bảng
                 * ngược lại là bảng đang rỗng
                 */
                if (isset($sentences) && $sentences->num_rows > 0) { ?>
                    <h3>Các ví dụ :</h3>
                    <?php
                    /*
                     * Sử dụng $result->fetch_assoc() để lấy về từng dòng bản ghi trong bảng
                     * và trả về cho biến $row
                     */
                    while($row = $sentences->fetch_assoc()) {
                        ?>
                        <div class="alert alert-success"><?php echo $row["sentence_example"] ?></div>
                        <div class="alert alert-success"><?php echo $row["sentence_translate"] ?></div>
                        <?php
                    }
                } else { ?>
                    <div class="alert alert-danger"><?php echo "Không tìm thấy ví dụ cho từ này";  ?></div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("a#reset").on("click", function (e) {
            e.preventDefault();
            $("input[name='search']").val();

            window.location.replace("search.php");
        });
    });
</script>
</body>
</html>