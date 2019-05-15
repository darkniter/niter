<html>
	<head>
		<meta charset=utf-8>
		<style>
			@import url("css/style.css?201905131611"); 
        </style>
    </head>
    
	<body>	
        
        <?php
            $url_query=$_SERVER['QUERY_STRING'];
            parse_str($url_query,$partsURL);
            $ip=$partsURL['ip'];
            $vendor=mb_strtolower($partsURL['vendor']);

            echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST"><input name="ip" type= "text"  maxlength="16" required ';
            
            if($ip==null)$ip=htmlspecialchars($_POST["ip"]);
            
            echo "value={$ip}>";
            echo '<button name="activate" type="submit" value="Найти">Найти</button><p>';
            
            require_once 'config.php';
            
            echo '<select name = "vendor" >';
            if($vendor==null)$vendor=htmlspecialchars($_POST["vendor"]);
            
          foreach($request as $value){
                $name_vendor=key($request);
                next($request);
                echo '<option value="';
                
                echo $name_vendor;
                echo'"';
                if(mb_strtolower($name_vendor)==mb_strtolower($vendor)) echo 'selected';
                echo '>';
                echo "{$name_vendor}</option>";
            }  
            reset($request);
            echo '</select>';
            echo '<button name="activate" type="submit" value="Найти">Найти</button>';
            echo'</form></p>';          
            
            $time=0;
            $ip=htmlspecialchars($_POST["ip"]);		
            $vendor = $_POST["vendor"];
            $str=str_replace(".","",$ip);
            
            //Проверка правильности ввода
            
            
            error_reporting(E_ALL);
            
            ini_set('display_errors', 1);
            // mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
            $link =  mysqli_connect($line["host"],$line["username"],$line["passwd"],$line["dbnam"]);
            
            if (mysqli_connect_errno()){ //Тест подключения
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            if($link){
                echo 'Соединение установлено.<br>';
                if((ctype_digit($str)==true) && (substr_count($ip,".")==3)){
                    
                    $time=microtime(true);
                    mysqli_query($link, "SET profiling = 1;");
                    
                    if (mysqli_errno($link)) { die( "ERROR ".mysqli_errno($link) . ": " . mysqli_error($link) ); }
                    
                    
                    if ( $result = mysqli_query($link,$request["{$vendor}"]) ) { //Отправление запросов на сервер
                        $exec_time_result=mysqli_query($link, "SELECT query_id, SUM(duration) FROM information_schema.profiling GROUP BY query_id ORDER BY query_id DESC LIMIT 1;");
                        $exec_time_row = mysqli_fetch_array($exec_time_result);
                        $time = microtime(true)-$time;
                        if($result->num_rows){//Обработка пустого ответа от сервера 
                            echo'<table><tr><th>Логин</th><th>MAC-адрес</th><th>Порт</th><th> Дата </th></tr>';
                            
                            
                            while($resource=mysqli_fetch_array($result)){ //Вывод таблицы с полученными значениями
                                echo "<tr><td>{$resource['login']}</td><td>{$resource['mac']}</td><td>{$resource['port']}</td><td>{$resource['date']}</td></tr>";
                            } 
                            echo '</table>';
                        }
                        else echo $Err["ErrEnter2"];
                        } else {
                        echo $Err["ErrRequestEmpty"];
                    }
                    
                }elseif($str==""){echo $Err["info"];}
                else echo $Err["ErrEnter1"];
            }
            else
            echo $Err["Err1"];
            if(isset($exec_time_row[1])) echo "<p>Query executed in ".$exec_time_row[1].' seconds';
            
            echo "<br><br>Time request {$time}";
        ?>
        <!--<pre><?php var_dump( $_SERVER ); ?></pre>
        <pre><?php var_dump( $_GET ); ?></pre>
        <pre><?php var_dump( $_POST ); ?></pre>-->
    </body>
</html>
