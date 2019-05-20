<html>
	<head>
		<meta charset=utf-8>
		<style>
			@import url("css/style.css"); 
        </style>
    </head>
    
	<body>	
        <div id='niter'><p> <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="POST"><input name="ip" type= "text"  maxlength="16" required 
            <?php
           
                
                require_once 'config.php';
                
                if(isset( $_SERVER['QUERY_STRING'])){
                    $url_query = $_SERVER['QUERY_STRING'];
                    if($_SERVER['QUERY_STRING']!==''){parse_str($url_query,$partsURL);
                        $ip = isset($partsURL['ip'])?  $partsURL['ip']:'';
                        $vendor = isset($partsURL['vendor'])?$partsURL['vendor']:'';
                    }
                }
                
                if(isset($_POST["ip"]))$ip=htmlspecialchars($_POST["ip"]);
                
                if(isset($ip)) echo "value={$ip}>";
                else echo ">";
                
                echo '<select name = "vendor" >';
                
                if(isset($_POST["vendor"]))$vendor=($_POST["vendor"]);
                        
                
                
                foreach($request as $key=>$value){
                    $name_vendor=$key;
                    // next($request);
                    echo '<option value="';
                    
                    echo $name_vendor;
                    echo'"';
                    if(isset($vendor) && mb_strtolower($name_vendor)==mb_strtolower($vendor)) echo 'selected';
                    echo '>';
                    echo "{$name_vendor}</option>";
                }  
                
                echo '</select>';
                echo '<button name="activate" type="submit" value="Найти">Найти</button>';
                echo'</form></p>';  
                
                $mysqli = new mysqli(...array_values($line));
                
                $time=0;
                
                
                if (isset($ip)&& isset($_POST['ip'])){
                $str=str_replace(".","",$ip);
                    
                    $vendor = mb_strtolower($vendor);
                    if ($mysqli->connect_errno) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        echo $Err["Err1"];
                    }
                    else {
                        echo 'Соединение установлено.<br>';
                        if((ctype_digit($str)==true) && (substr_count($ip,".")==3)){
                            
                            $time=microtime(true);
                            
                            $mysqli->query($time_request['value_prof']);
                            
                            
                            
                            if ( $result = $mysqli->query(sprintf($request["{$vendor}"], $ip))) { //Отправление запросов на сервер
                                $exec_time_query = $time_request['request'];
                                
                                $exec_time_result = $mysqli->query($exec_time_query);
                                $exec_time_row = $exec_time_result->fetch_array();
                                
                                
                                
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
                            
                            
                            
                        }
                        else echo $Err["ErrEnter1"];
                    }
                }else echo $Err["info"];
                
                if(isset($exec_time_row[1])) echo "<p>Query executed in ".$exec_time_row[1].' seconds';
                
                echo "<br><br>Time request {$time}";
                // }else echo $Err["info"];
            ?>
            <!--<pre style="display:none"><?php var_dump($_POST);?></pre>-->
        </div>  
        </body>
    </html>                        
