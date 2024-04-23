<?php
    $host = 'localhost';
    $dbuser ='root';
    $dbpassword = '';
    $dbname = 'user_name';
    $link = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
    if($link){

        $datas = array();
        $sql = "SELECT user,date,patientnum,meetdate FROM `username` WHERE 1;";

        $result = mysqli_query($link, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $datas[] = $row;
            }
            mysqli_free_result($result);
        }
        
    }
    else {
        echo "不正確連接資料庫</br>" . mysqli_connect_error();
    }

?>
<?php if (!empty($datas)): ?>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <table>
        <thead>
            <tr>
                <th>醫師</th>
                <th>病人編號</th>
                <th>上傳日期</th>
                <th>看診日期</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datas as $key => $row) : ?>
                <tr>
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['patientnum']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['meetdate']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <button style="padding: 10px 20px; background-color: #96632E; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-family: Arial, sans-serif; font-size: 16px;" onclick="goToPage()">登出</button>

    <script>
        function goToPage() {
            window.location.href = 'index2.html';
            // 清空瀏覽器的歷史記錄，禁止往前
            history.pushState(null, null, location.href);
        }
        
        // 禁用瀏覽器的後退按鈕
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
<?php else: ?>
    查無資料
<?php endif; ?>