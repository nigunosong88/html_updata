<?php
    $host = 'localhost';
    $dbuser ='root';
    $dbpassword = '';
    $dbname = 'user_name';
    $link = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
    if($link){
        mysqli_query($link,'SET NAMES utf8');

        if (($_POST['user']=='root' and ($_POST['patientnum'])=='123456') ){
            header("Location: root.php"); // 自動跳轉至 root.php
            exit();
        };
        if (($_POST['user']=='root' and ($_POST['patientnum'])!='123456') ){
            echo '<p style="font-family: Arial, sans-serif; font-size: 16px; margin-bottom: 10px;">密碼有誤，請再次輸入，或聯絡管理員</p>';
            echo '<button style="padding: 10px 20px; background-color: #96632E; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-family: Arial, sans-serif; font-size: 16px;" onclick="window.location.href=\'index2.html\'">返回上一頁</button>';
            exit();
        };
        if (empty($_POST['user']) || empty($_POST['patientnum'])){
            echo '資料有缺，請再次填寫<br>';
            exit();   // 終止程序
        };
        
        
        $time = date("Y/m/d H:i:s");

        $user = $_POST['user'];
        $patientnum = $_POST['patientnum'];
        $meetday = $_POST['meetday'];

        // 格式化日期為純數字日期
        $meetDayNumeric = date("Ymd", strtotime($meetday)); 

        $sql = sprintf(  
            "INSERT INTO username (user, date, patientnum, meetdate)
            VALUES ('%s', '%s', '%s', '%s')",
            $user, $time, $patientnum, $meetday
        );
        $result = mysqli_query($link, $sql); 
        if (!$result) {
           die(mysqli_error($link));
        }

        // 照片移動代碼開始
        if(isset($_FILES['fileToUpload']['name']) && is_array($_FILES['fileToUpload']['name'])) {
            $num_files = count($_FILES['fileToUpload']['name']);

            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $patientNum = $_POST['patientnum'];
            $meetDay = $_POST['meetday'];
            $formattedDate = str_replace("-", "", $meetDay);

            // 檢查病歷號資料夾是否存在，如果不存在，創建它
            $patientFolder = $uploadDir . $patientNum . '/';
            if (!file_exists($patientFolder)) {
                mkdir($patientFolder, 0777, true);
            }

            // 檢查相對日期的資料夾是否存在，如果不存在，創建它
            $meetDayFolder = $patientFolder . $formattedDate . '/';
            if (!file_exists($meetDayFolder)) {
                mkdir($meetDayFolder, 0777, true);
            }

            // 移動上傳的照片到相對日期的資料夾中
            for($i=0; $i<$num_files; $i++){
                $fileName = $_FILES['fileToUpload']['name'][$i];
                $tempFileName = $_FILES['fileToUpload']['tmp_name'][$i];

                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = $patientNum. '_' . $formattedDate .'_'.($i+1). '.' . $extension;

                $targetFile = $meetDayFolder . $newFileName;
                move_uploaded_file($tempFileName, $targetFile);
            }
        } else {
            echo "沒有選擇檔案進行上傳";
        }
        // 照片移動代碼結束
       
        echo '<script>alert("上傳完成");window.location.href="index2.html";</script>'; 
        
    }
    else {
        echo "不正確連接資料庫</br>" . mysqli_connect_error();
    }
?>
