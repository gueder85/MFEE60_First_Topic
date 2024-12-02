<?php
require_once("../../db_connect.php");

class Activity
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    // 活動數量
    public function getNum()
    {
        $sql = "SELECT * FROM activity WHERE is_deleted=0";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }
    public function getBandNum()
    {
        $sql = "SELECT * FROM activity_band";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    // 讀取資料表
    public function read($order = 0, $search = '', $date_start = '', $date_end = '', $city_id = 0, $category_id = 0, $start_item, $per_page)
    {
        switch ($order) {
            case 0:
                $whereClause = "ORDER BY id ASC";
                break;
            case 1:
                $whereClause = "ORDER BY id DESC";
                break;
            case 2:
                $whereClause = "ORDER BY ticket_price ASC";
                break;
            case 3:
                $whereClause = "ORDER BY ticket_price DESC";
                break;
            case 4:
                $whereClause = "ORDER BY ticket_num ASC";
                break;
            case 5:
                $whereClause = "ORDER BY ticket_num DESC";
                break;
            case 6:
                $whereClause = "ORDER BY date_start ASC";
                break;
            case 7:
                $whereClause = "ORDER BY date_start DESC";
                break;
            default:
                $whereClause = "";
        }

        $sqlRead = "SELECT activity.*, activity_category.name AS category_name, activity_city.name AS city_name
            FROM 
                activity
            JOIN 
                activity_category
            ON 
                activity.category_id = activity_category.id
            JOIN 
                activity_city
            ON 
                activity.city_id = activity_city.id
            WHERE
                activity.is_deleted = 0";

        // 正常搜尋
        $sql = $sqlRead;

        // 有搜尋就搜尋
        if (!empty($search)) {
            $sql = "$sqlRead AND activity.name LIKE '%$search%'";
        } else {
            // 不然就根據篩選條件 BUG 點了之後order就清除
            if (!empty($city_id)) {
                $sql = "$sql AND activity.city_id = '$city_id'";
            }
            if (!empty($category_id)) {
                $sql = "$sql AND activity.category_id = '$category_id'";
            }
            if (!empty($date_start) && !empty($date_end)) {
                $sql = "$sql AND activity.date_start BETWEEN '$date_start' AND '$date_end'";
            }

            // 加上 order 排序
            $sql = "$sql $whereClause";

            // 加上 分頁
            $sql = "$sql LIMIT $start_item, $per_page";
        }

        $result = $this->conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $num_rows = $result->num_rows;
        return [
            'rows' => $rows,
            'num_rows' => $num_rows,
            'sql' => $sql
        ];
    }

    // 搜尋活動 (id)
    public function getById($id)
    {
        $sql = "SELECT activity.*, activity_category.name AS category_name
            FROM 
                activity
            JOIN 
                activity_category 
            ON 
                activity.category_id = activity_category.id
            WHERE 
                activity.id = '$id' AND activity.is_deleted = 0";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    public function readMedia($i)
    {
        $sql = "SELECT * FROM activity_media WHERE activity_id = $i AND is_deleted=0";
        $result = $this->conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public function readBand($i)
    {
        $sql = "SELECT * FROM activity_band WHERE activity_id = $i";
        $result = $this->conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public function readCity()
    {
        $sql = "SELECT * FROM activity_city";
        $result = $this->conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public function readCategory()
    {
        $sql = "SELECT * FROM activity_category";
        $result = $this->conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
}
