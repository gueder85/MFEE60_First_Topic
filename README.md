請依照下列步驟服用

1. 建立資料夾在C槽XAMPP/htdocs/topic <<<這個資料夾名稱要是topic
2. VScode打開資料夾開終端機輸入 git clone https://github.com/gueder85/MFEE60_First_Topic.git . <<<要加這個點才會在對的層
3. clone下來後啟動XAMPP開啟Apache跟MySQL
4. 新建資料庫topics 編碼為(utf8mb4_unicode_ci) 匯入 資料夾內的資料 topics.sql #留意max_allowed_packet需要24mb以上
5. 於網頁輸入 http://localhost/topic/article/pages/你的那頁.php
