<?php
require_once("../db_connect.php");

$sql = "INSERT INTO article (title, author, created_at, category_id) VALUES
-- 1
('吉他保養與清潔', 'Guitar To Go Featured', '2022/7/8', 2),
-- 2
('《未來還沒被書寫》推薦序：理想主義年代或音樂史的異響', '廖偉棠', '2022/6/13', 3),
-- 3
('在旅店裡聽團＋異國露營，OLAH POSHTEL悅樂旅店「夏酒祭」暑假限定', '郭璈', '2023/7/4', 3),
-- 4
('「拜託明年一定還要再辦！」首屆 法國生活節在高雄：台法品牌網紅合作出攤、在駁二來場法式野餐', '高麗音', '2024/6/17', 4),
-- 5
('搖滾樂的起源與流派', 'C&M', '2013/5/28', 2),
-- 6
('撐Live House不簡單：河岸留言創辦人林正如 ft.1976、董運昌、乩童秩序', '王信權', '2021/3/24', 4);
";

if ($conn->query($sql) === TRUE) {
    echo "資料新增成功";
} else {
    echo "新增失敗: " . $conn->error;
}

$conn->close();
?>
