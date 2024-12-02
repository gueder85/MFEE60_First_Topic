<?php
require_once("../assets/sqls-activity.php");

// 活動物件
$act = new Activity($conn);

$cities = $act->readCity();
$cates = $act->readCategory();

?>

<div class="container-fluid py-2">
    <div class="container">
        <h2>活動建立</h2>

        <form action="doActCreate.php" method="post" enctype="multipart/form-data">
            <table class="table table-striped table-bordered" id="createTable">
                <colgroup>
                    <col style="width: 100px;"> <!--定義第一列的寬度-->
                    <col> <!-- 其他列自動調整 -->
                </colgroup>
                <tr>
                    <th class="align-middle text-center">名稱</th>
                    <td>
                        <input type="text" class="form-control" name="name" required>
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

                        </div>
                        <button onclick="addBand()" type="button" class="btn btn-success mt-4">新增樂團</button>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle text-center">活動日期</th>
                    <td class="date">
                        <label for="" class="form-control mb-0">開始日期</label>
                        <input type="datetime-local" class="form-control ms-1" name="date_start" required>
                        <label for="" class="form-control mt-3 mb-0">結束日期</label>
                        <input type="datetime-local" class="form-control ms-1" name="date_end" required>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle text-center">報名日期</th>
                    <td class="date">
                        <label for="" class="form-control mb-0">開始日期</label>
                        <input type="datetime-local" class="form-control ms-1" name="sign_up_start" required>
                        <label for="" class="form-control mt-3 mb-0">結束日期</label>
                        <input type="datetime-local" class="form-control ms-1" name="sign_up_end" required>
                    </td>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle text-center">門票數量</th>
                    <td>
                        <input type="text" class="form-control" name="ticket_num" required>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle text-center">門票價格</th>
                    <td>
                        <input type="text" class="form-control" name="ticket_price" required>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle text-center">活動描述</th>
                    <td>
                        <textarea class="form-control" name="description" rows="10" required></textarea>
                    </td>
                </tr>
                <tr>
                    <th class="align-middle text-center">地址</th>
                    <td>
                        <input type="text" class="form-control" name="address" required>
                    </td>
                </tr>

                <tr>
                    <th class="align-middle text-center">地區</th>
                    <td>
                        <select class="form-select" name="city" required>
                            <option selected>請選擇縣市</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= $city['id'] ?>">
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

                        </div>
                        <!-- 上傳照片 -->
                        <input type="file" id="addImage" name="file[]" class="mt-4" multiple>
                    </td>
                </tr>
            </table>


            <div class="d-flex justify-content-between">
                <div>
                    <button class="btn btn-info" type="submit" title="建立活動">完成</button>
                    <a href="?page=1" class="btn btn-info ms-2" title="返回列表">取消</a>
                </div>
            </div>
        </form>

    </div>
</div>