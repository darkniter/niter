<html>
	<head>
		<meta charset=utf-8>
		<style>
			@import url("css/style.css?201905131611"); 
        </style>
    </head>
    
	<body>	
        
        <?php
            $mysqli = new mysqli('localhost','mysql','mysql','radius');
            
            $url_query=$_SERVER['QUERY_STRING'];
            parse_str($url_query,$partsURL);
            $ip=$partsURL['ip'];
            $vendor=mb_strtolower($partsURL['vendor']);
            $exec_time_row = 0;
            
            
            
            echo '<p><form action="' . $_SERVER['REQUEST_URI'] . '" method="POST"><input name="ip" type= "text"  maxlength="16" required ';
            
            if($ip==null)$ip=htmlspecialchars($_POST["ip"]);
            
            echo "value={$ip}>";
            
            
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
                // $mysqli ->query("SET GLOBAL general_log = 'ON'");
                    
                    
                    if ( $result = $mysqli->query($request["{$vendor}"]) ) { //Отправление запросов на сервер
                        
                        
                        
                        
                        $time = microtime(true)-$time;
                        
                        if($result->num_rows){//Обработка пустого ответа от сервера 
                            
                            if($result!=null){
                                $a = mysqli_num_fields($result);//сорян мозги кипели
                                echo'<table> <tr>';
                                
                                for($i=0;$i<$a;$i++){
                                    
                                    
                                    $info_column = $result->fetch_field_direct($i); 
                                    
                                    $name_column= $info_column->name;
                                    
                                    echo "<th>{$name_column}</th>";
 
                                }
                                echo '</tr>';
                            }
                            
                            
                            
                            while($resource=$result->fetch_array(MYSQLI_ASSOC)){ //Вывод таблицы с полученными значениями
                                echo '<tr>';
                                for($i=0;$i<$a;$i++){
                                    $info_column = $result->fetch_field_direct($i); 
                                    
                                    $name_column= $info_column->name;
                                    
                                    echo '<td>'.$resource["{$name_column}"].'</td>';
                                }
                                echo '</tr>';
                            }
                            echo '</table>';
                            $result->close();
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
         
        /* $result = $mysqli -> query("SELECT * FROM mysql.general_log");
         $SQL_time=$result ->fetch_array(MYSQLI_ASSOC);*/
            
            echo "<br><br>Time request {$time}";
        ?>
        <!--<pre style="display:none"><?php echo($SQL_time);?></pre>-->
        
    </body>
</html>
