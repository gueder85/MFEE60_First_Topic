<?php
require_once("../assets/sqls-activity.php");

if (!isset($_GET["id"])) {
    echo "請輸入id";
    exit;
}

$id = $_GET["id"];

// 活動物件
$act = new Activity($conn);

$row = $act->getById($id);
$images = $act->readMedia($id);
$bands = $act->readBand($id);
$cities = $act->readCity();
$cates = $act->readCategory();

// 資料處理
$date_start = date("Y-m-d H:i", strtotime($row["date_start"]));
$date_end = date("Y-m-d H:i", strtotime($row["date_end"]));
$sign_up_start = date("Y-m-d H:i", strtotime($row["sign_up_start"]));
$sign_up_end = date("Y-m-d H:i", strtotime($row["sign_up_end"]));
?>

<div class="container-fluid py-2">
    <div class="container">
        <?php if ($row): ?>
            <h2>活動修改</h2>

            <form action="doActUpdate.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <table class="table table-striped table-bordered" id="editTable">
                    <colgroup>
                        <col style="width: 100px;"> <!--定義第一列的寬度-->
                        <col> <!-- 其他列自動調整 -->
                    </colgroup>
                    <tr>
                        <th class="align-middle text-center">名稱</th>
                        <td>
                            <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">音樂類型</th>
                        <td>
                            <div class="form-group">
                                <?php foreach ($cates as $cate): ?>
                                    <div>
                                        <input
                                            type="radio"
                                            id="cate-<?= $cate['id'] ?>"
                                            name="cate"
                                            value="<?= $cate['id'] ?>"
                                            <?= ($cate['id'] == $row['category_id']) ? 'checked' : ''; ?>
                                            required>
                                        <label for="cate-<?= $cate['id'] ?>"><?= $cate['name'] ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">演出樂團</th>
                        <td class="form-bands">
                            <div class="row gap-3" id="add-band-area">
                                <?php foreach ($bands as $band): ?>
                                    <div class="col-1">
                                        <input type="text" class="form-control text-center mb-0"
                                            name="bands[<?= $band["id"] ?>]"
                                            value="<?= $band["band"] ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button onclick="addBand()" type="button" class="btn btn-success mt-4">新增樂團</button>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">活動日期</th>
                        <td class="date">
                            <label for="" class="form-control mb-0">開始日期</label>
                            <input type="datetime-local" class="form-control ms-1" name="date_start" value="<?= $date_start ?>" required>
                            <label for="" class="form-control mt-3 mb-0">結束日期</label>
                            <input type="datetime-local" class="form-control ms-1" name="date_end" value="<?= $date_end ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">報名日期</th>
                        <td class="date">
                            <label for="" class="form-control mb-0">開始日期</label>
                            <input type="datetime-local" class="form-control ms-1" name="sign_up_start" value="<?= $sign_up_start ?>" required>
                            <label for="" class="form-control mt-3 mb-0">結束日期</label>
                            <input type="datetime-local" class="form-control ms-1" name="sign_up_end" value="<?= $sign_up_end ?>" required>
                        </td>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">門票數量</th>
                        <td>
                            <input type="text" class="form-control" name="ticket_num" value="<?= $row["ticket_num"] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">門票價格</th>
                        <td>
                            <input type="text" class="form-control" name="ticket_price" value="<?= $row["ticket_price"] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">活動描述</th>
                        <td>
                            <textarea class="form-control" name="description" rows="10" required><?= $row["description"] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">地址</th>
                        <td>
                            <input type="text" class="form-control" name="address" value="<?= $row["address"] ?>" required>
                        </td>
                    </tr>

                    <tr>
                        <th class="align-middle text-center">地區</th>
                        <td>
                            <select class="form-select" name="city" required>
                                <option selected>請選擇縣市</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city['id'] ?>"
                                        <?= ($city['id'] == $row['city_id']) ? 'selected' : ''; ?>>
                                        <?= $city['name'] ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">照片</th>
                        <td>
                            <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-1 g-3" id="add-img-area">
                                <?php foreach ($images as $image): ?>
                                    <div class="col position-relative">
                                        <div class="ratio ratio-16x9 border rounded">
                                            <img class="img-fluid" src="../assets/upload/<?= $image["img"] ?>" alt="">
                                        </div>

                                        <!-- 刪除照片的 checkbox  -->
                                        <div class="form-check position-absolute top-3 ps-2">
                                            <input type="checkbox" class="form-check-input" id="deleteCheck<?= $image["id"] ?>"
                                                name="deleteCheck[<?= $image['id'] ?>]">
                                            <label class="form-check-label" for="deleteCheck<?= $image["id"] ?>">X</label>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- 上傳照片 -->
                            <input type="file" id="addImage" name="file[]" class="mt-4" multiple>
                        </td>
                    </tr>
                </table>


                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-outline-dark" type="submit" title="儲存更改">儲存</button>
                        <a href="?page=1" class="btn btn-outline-secondary ms-2" title="返回列表">取消</a>
                    </div>
                    <div>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" type="button">刪除活動</button>
                    </div>
                </div>
            </form>

        <?php else: ?>
            <h1>未找到該活動</h1>
        <?php endif; ?>

        <!-- 刪除活動確認 -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        是否刪除此活動?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a></ㄇ>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>