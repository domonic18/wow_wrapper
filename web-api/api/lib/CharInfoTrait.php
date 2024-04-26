<?php
    trait CharInfoTrait {

        private function Fraction($race){
            if ($race === 1 || $race === 3 || $race === 4 || $race === 7 || $race === 11 || $race === 22) {
                return 'Alliance';
            } elseif($race == 24) {
                return 'Neutral';
            }else{
                return 'Horde';
            }
        }

        private function OnlineIcon($race,$gender){
            switch ($race) {
                case 1:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_human-male.png' : $race = 'race/Ui-charactercreate-races_human-female.png';
                    break;
                case 2:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_orc-male.png' : $race = 'race/Ui-charactercreate-races_orc-female.png';
                    break;
                case 3:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_dwarf-male.png' : $race = 'race/Ui-charactercreate-races_dwarf-female.png';
                    break;
                case 4:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_nightelf-male.png' : $race = 'race/Ui-charactercreate-races_nightelf-female.png';
                    break;
                case 5:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_undead-male.png' : $race = 'race/Ui-charactercreate-races_undead-female.png';
                    break;
                case 6:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_tauren-male.png' : $race = 'race/Ui-charactercreate-races_tauren-female.png';
                    break;
                case 7:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_gnome-male.png' : $race = 'race/Ui-charactercreate-races_gnome-female.png';
                    break;
                case 8:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_troll-male.png' : $race = 'race/Ui-charactercreate-races_troll-female.png';
                    break;
                case 10:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_bloodelf-male.png' : $race = 'race/Ui-charactercreate-races_bloodelf-female.png';
                    break;
                case 11:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_draenei-male.png' : $race = 'race/Ui-charactercreate-races_draenei-female.png';
                    break;
                case 22:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_worgen-male.png' : $race = 'race/Ui-charactercreate-races_worgen-female.png';
                    break;
                case 9:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_goblin-male.png' : $race = 'race/Ui-charactercreate-races_goblin-female.png';
                    break;
                case 24:
                    ($gender === 0) ? $race = 'race/Ui-charactercreate-races_pandaren-male.png' : $race = 'race/Ui-charactercreate-races_pandaren-female.png';
                    break;
            }
            return $race;
        }

        private function RaceIcon($race,$gender){
            switch ($race) {
                case 1:
                    ($gender === 0) ? $race = 'Resources/charBg/1-0.jpg' : $race = 'Resources/charBg/1-1.jpg';
                    break;  //humans
                case 2:
                    ($gender === 0) ? $race = 'Resources/charBg/2-0.jpg' : $race = 'Resources/charBg/2-1.jpg';
                    break;  //orks
                case 3:
                    ($gender === 0) ? $race = 'Resources/charBg/3-0.jpg' : $race = 'launcher/character/charBg/3-1.jpg';
                    break;  //dwarfs
                case 4:
                    ($gender === 0) ? $race = 'Resources/charBg/4-0.jpg' : $race = 'launcher/character/charBg/4-1.jpg';
                    break; //night elfs
                case 5:
                    ($gender === 0) ? $race = 'Resources/charBg/5-0.jpg' : $race = 'Resources/charBg/5-1.jpg';
                    break; // undead
                case 6:
                    ($gender === 0) ? $race = 'Resources/charBg/6-0.jpg' : $race = 'Resources/charBg/6-1.jpg';
                    break;  //tauren
                case 7:
                    ($gender === 0) ? $race = 'Resources/charBg/7-0.jpg' : $race = 'Resources/charBg/7-1.jpg';
                    break;  //gnomes
                case 8:
                    ($gender === 0) ? $race = 'Resources/charBg/8-0.jpg' : $race = 'Resources/charBg/8-1.jpg';
                    break; //troll
                case 10:
                    ($gender === 0) ? $race = 'Resources/charBg/10-0.jpg' : $race = 'Resources/charBg/10-1.jpg';
                    break; //blood elf
                case 11:
                    ($gender === 0) ? $race = 'Resources/charBg/11-0.jpg' : $race = 'Resources/charBg/11-1.jpg';
                    break; // drenei
                case 9:
                    ($gender === 0) ? $race = 'Resources/charBg/9-0.jpg' : $race = 'Resources/charBg/9-1.jpg';
                    break; // goblin
                case 22:
                    ($gender === 0) ? $race = 'Resources/charBg/22-0.jpg' : $race = 'Resources/charBg/22-1.jpg';
                    break; // worgen
                case 24:
                    ($gender === 0) ? $race = 'Resources/charBg/24-0.jpg' : $race = 'Resources/charBg/24-1.jpg';
                    break; // pandaren
            }
            return $race;
        }

        private function ClassState($class,$mana = 0,$rage = 0,$energy = 0,$powerRune = 0){
            $classes = array(
                1=>array('class'=>'战士','powerName'=>'Rage'),
                2=>array('class'=>'圣骑士','powerName'=>'Mana'),
                3=>array('class'=>'猎人','powerName'=>'Mana'),
                4=>array('class'=>'潜行者','powerName'=>'Energy'),
                5=>array('class'=>'牧师','powerName'=>'Mana'),
                6=>array('class'=>'死亡骑士','powerName'=>'Runic Power'),
                7=>array('class'=>'萨满祭司','powerName'=>'Mana'),
                8=>array('class'=>'法师','powerName'=>'Mana'),
                9=>array('class'=>'术士','powerName'=>'Mana'),
                11=>array('class'=>'德鲁伊','powerName'=>'Mana'),
                10=>array('class'=>'武僧','powerName'=>'Energy')
            );

            if(isset($classes[$class])){
                $cls = $classes[$class];
                if($cls['powerName'] === 'Mana'){
                    $cls['power'] = $mana;
                }elseif($cls['powerName'] === 'Energy'){
                    $cls['power'] = $energy;
                }elseif($cls['powerName'] === 'Runic Power'){
                    $cls['power'] = $powerRune;
                }elseif($cls['powerName'] === 'Rage') {
                    $cls['power'] = $rage;
                }
                return $cls;
            }else{
                $this->error('Not Found Class '.$class,E_USER_ERROR);
            }
        }

        private function HonorRang($honor = 0,$race = 0){
            $rank_a = array(
                0 => 'No rank',
                1 => 'Private',
                2 => 'Corporal',
                3 => 'Sergeant',
                4 => 'Master Sergeant',
                5 => 'Sergeant Major',
                6 => 'Knight',
                7 => 'Knight-Lieutenant',
                8 => 'Knight-Captain',
                9 => 'Knight-Champion',
                10 => 'Lieutenant Commander',
                11 => 'Commander',
                12 => 'Marshal',
                13 => 'Field Marshal',
                14 => 'Grand Marshal',
                15 => 'City Defender'
            );
            $rank_h = array(
                0 => 'No rank',
                1 => 'Scout',
                2 => 'Grunt',
                3 => 'Sergeant',
                4 => 'Senior Sergeant',
                5 => 'First Sergeant',
                6 => 'Stone Guard',
                7 => 'Blood Guard',
                8 => 'Legionnaire',
                9 => 'Centurion',
                10 => 'Champion',
                11 => 'Lieutenant General',
                12 => 'General',
                13 => 'Warlord',
                14 => 'High Warlord',
                15 => 'City Defender'
            );
            if ($honor <= 0)
                $rank = 0;
            elseif ($honor < 500)
                $rank = 1;
            elseif ($honor < 1500)
                $rank = 2;
            elseif ($honor < 3000)
                $rank = 3;
            elseif ($honor < 5000)
                $rank = 4;
            elseif ($honor < 7500)
                $rank = 5;
            elseif ($honor < 10000)
                $rank = 6;
            elseif ($honor < 15000)
                $rank = 7;
            elseif ($honor < 20000)
                $rank = 8;
            elseif ($honor < 30000)
                $rank = 9;
            elseif ($honor < 40000)
                $rank = 10;
            elseif ($honor < 50000)
                $rank = 11;
            elseif ($honor < 75000)
                $rank = 12;
            elseif ($honor < 100000)
                $rank = 13;
            elseif ($honor < 150000)
                $rank = 14;
            else
                $rank = 15;
            if($race === 1 || $race === 3 || $race === 4 || $race === 7 || $race === 11)
                return $rank_a[$rank];
            else
                return $rank_h[$rank];
        }

        private function totalTime($time){
            $totaltime = $time;
            $sec = $totaltime%60;
            $totaltime = intval ($totaltime/60);
            $min = $totaltime%60;
            $totaltime = intval ($totaltime/60);
            $hours = $totaltime%24;
            $totaltime = intval($totaltime/24);
            $days = $totaltime;
            return "$days 天 $hours 小时 $min 分钟";
        }

        private function Inventory(){
            return array(
                0 => 'HeadChar',
                1 => 'Neck',
                2 => 'Shoulders',
                3 => 'BodyChar',
                4 => 'ChestChar',
                5 => 'Waist',
                6 => 'Legs',
                7 => 'Feet',
                8 => 'Wrists',
                9 => 'Hands',
                10 => 'Finger1',
                11 => 'Finger2',
                12 => 'Trinket1',
                13 => 'Trinket2',
                14 => 'Back',
                15 => 'MainHand',
                16 => 'OffHand',
                17 => 'Ranget',
                18 => 'Tabard'
            );
        }

        private function is_item($item){
            if (is_numeric($item)) {
                return self::$_conf['site_url'] . 'launcher/race/noteImage.png';
            } else {
                return self::$_conf['wowhead_url_icons'].$item.'.jpg';
            }
        }

        // 检查并替换玩家名称的函数
        protected function checkAndReplacePlayerName($name) {
            if ($name === '') {
                return '已删号';
            }
            return $name;
        }

        public function getCharInfo($name){
            $db = $this->Connect(self::$_conf['characters']);
            $char = $db->select('characters',array('guid','power1','power2','power4','power7','class','name','level','race','gender','health','totaltime','totalHonorPoints','arenaPoints','totalKills'),array('name'=>$name));
            if($char !== false and count($char) > 0){
                $character = $char[0];

                $mana = $character['power1'];  //mp
                $rage = $character['power2'];  //Rage
                $energy = $character['power4'];  //Energy
                $powerRune = $character['power7'];  //runic power
                $character_stat = $this->ClassState($character['class'],$mana,$rage,$energy,$powerRune);

                $stats = array();
                $stats['Name'] = mb_convert_encoding($character['name'],"GBK","UTF-8");
                $stats['Level'] = $character['level'];
                $stats['Race'] = $this->RaceIcon((int) $character['race'],(int) $character['gender']);
                $stats['Class'] = $character_stat['class'];
                $stats['Side'] = $this->Fraction((int) $character['race']);
                $stats['Health'] = 'Health: '.$character['health'];  //hp
                $stats['Power'] = $character_stat['powerName'].':'.$character_stat['power'];
                $stats['TotalTime'] = $this->totalTime($character['totaltime']);
                $stats['Rank'] = 'Rank: '.$this->HonorRang((int) $character['totalHonorPoints'],(int) $character['race']);
                $stats['Honor'] = 'Honor Points: '.$character['totalHonorPoints'];
                $stats['Arena'] = 'Arena Points: '.$character['arenaPoints'];
                $stats['Kills'] = 'Total kills: '.$character['totalKills'];
                $stats['Quest'] = 'Done Quests: '.$db->count('character_queststatus_rewarded', array(
                        'guid' => $character['guid']
                    ));
                $stats['Achiev'] = 'Obtain achievements: '.$db->count('character_achievement', array(
                        'guid' => $character['guid']
                    ));

//                echo $this->XMLRender(array('Characters','Stat','CharBlock'),$stats);
                return json_decode((string)$stats, true);
            }else{
                $this->error('Not Found character '.$name,E_USER_ERROR);
            }
        }

        public function getCharItem($name){
            $slots = $this->Inventory();
            $db_char = $this->Connect(self::$_conf['characters']);
            $db_site = $this->Connect(self::$_conf['icon_db']);
            $db_world = $this->Connect(self::$_conf['world']);
            $character = $db_char->select('characters',array('guid'),array('name'=>$name));

            if($character !== false and count($character) > 0) {

                $inventory = $db_char->select('character_inventory', '*', array('AND'=>array('guid' => $character[0]['guid'],'slot[<>]'=>array(0,19),'bag'=>0)));

                if($inventory !== false and count($inventory) > 0){

                    //$itemIcon = '';
                    //$itemsDisplayID = '';
                    //$charaterInventory = '';
                    $guid = '';

                    foreach($inventory as $invert){
                        if(isset($slots[$invert['slot']]))
                        {
                            $charaterInventory[$slots[$invert['slot']]] = $invert['item'];
                            if($guid === '') {
                                $guid = $invert['guid'];
                            }
                        }

                    }

                    if(is_array($charaterInventory)) {
                        foreach ($charaterInventory as $key => $charInf) {
                            $instance = $db_char->select('item_instance',array('itemEntry'),array('AND'=>array('owner_guid'=>$guid,'guid'=>$charInf)));

                            if($instance !== false and count($instance) > 0){
                                foreach($instance as $inst) {
                                    $itemID = $db_world->select('item_template', array('displayid'), array('entry' =>$inst['itemEntry']));
                                    if($itemID !== false and count($itemID) > 0) {
                                        $itemsDisplayID[$key] = $itemID[0]['displayid'];
                                    }
                                }
                            }
                        }
                    }

                    if (is_array($itemsDisplayID)) {
                        foreach($itemsDisplayID as $name=>$display){
                            $itemIconName = $db_site->select('tab_icon',array('icon'),array('guid'=>$display));
                            if($itemIconName !== false and count($itemIconName) > 0) {
                                $itemIcon[$name] = strtolower($itemIconName[0]['icon']);
                            }
                        }
                    }

                    if (is_array($itemIcon)) {
                        $inventorySlots = array_flip($slots);
                        $itemIcon = array_merge($inventorySlots, $itemIcon);
                        $itemIcon = array_map(array(__CLASS__,'is_item'), $itemIcon);

                        echo $this->XMLRender(array('Characters','Stat','CharBlock'),$itemIcon);
                    }
                }
            }else{
                $this->error('Not Found Character:'.$name,E_USER_ERROR);
            }
        }

        /*获取游戏时长最长的TOP50玩家信息的接口*/
        protected function fetchTopPlaytimePlayers(){
            try {
                $db = $this->Connect(self::$_conf['characters']);
                $sql = "
            SELECT 
                guid, name, race, class, level, gender, totaltime 
            FROM 
                `characters` 
            ORDER BY 
                `totaltime` DESC
            LIMIT 50
        ";
                $top_players = $db->query($sql)->fetchAll();

                return $top_players;
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
        public function getTopPlaytimePlayers(){
            $response = array();
            try {
                $topPlayers = array();
                $top_players_list = $this->fetchTopPlaytimePlayers();

                if ($top_players_list !== false && count($top_players_list) > 0) {
                    foreach ($top_players_list as $player) {
                        $class = $this->ClassState($player['class']);
                        $topPlayers[] =  array(
                            'Guid' => $player['guid'],
                            'Name' => $this->checkAndReplacePlayerName($player['name']),
                            'Race' => self::$_conf['site_url'] . $this->OnlineIcon((int)$player['race'], (int)$player['gender']),
                            'Class' => $class['class'],
                            'Gender' => ((int)$player['gender']),
                            'Level' => $player['level'],
                            'Side' => $this->Fraction((int) $player['race']),
                            'TotalSpentTime' => $this->totalTime($player['totaltime'])
                        );
                    }
                    $response['success'] = true;
                    $response['data'] = $topPlayers;
                } else {
                    $response['success'] = true;
                    $response['data'] = array();
                }
            } catch (Exception $e) {
                $response['success'] = false;
                $response['error'] = $e->getMessage();
            }

            // 输出 JSON 数据
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        /*获取在线玩家信息的接口*/
        protected function fetchOnlinePlayers(){
            try {
                $db = $this->Connect(self::$_conf['characters']);
                $sql = "
                    SELECT 
                        guid, name, race, class, level, gender, totaltime 
                    FROM 
                        `characters` 
                    WHERE 
                        `online` = 1 AND NOT `extra_flags` & 16 
                    ORDER BY 
                        `name`
                ";
                $online_list = $db->query($sql)->fetchAll();

                return $online_list;
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
        public function getOnlinePlayers(){
            $response = array();
            try {
                $onlinePlayers = array();
                $online_list = $this->fetchOnlinePlayers();

                if ($online_list !== false && count($online_list) > 0) {
                    foreach ($online_list as $key => $player) {
                        $onlinePlayers[$key] = $this->processPlayerData($player);
                    }
                    $response['success'] = true;
                    $response['data'] = $onlinePlayers;
                } else {
                    $response['success'] = true;
                    $response['data'] = array();
                }
            } catch (Exception $e) {
                $response['success'] = false;
                $response['error'] = $e->getMessage();
            }

            // 输出 JSON 数据
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        /*获取在线玩家数量的接口*/
        protected function fetchOnlinePlayersCount() {
            $db = $this->Connect(self::$_conf['characters']);

            $sql = '
                    SELECT 
                        COUNT(*) as total_count,
                        SUM(CASE WHEN `race` IN (1, 3, 4, 7, 11) THEN 1 ELSE 0 END) AS alliance_count,
                        SUM(CASE WHEN `race` IN (2, 5, 6, 8, 9, 10) THEN 1 ELSE 0 END) AS horde_count
                    FROM 
                        `characters`
                    WHERE 
                        `online` = 1 
                        AND NOT `extra_flags` & 16';

            return $db->query($sql)->fetch(PDO::FETCH_ASSOC);
        }
        public function getCountOnline(){
            try {
                $result = $this->fetchOnlinePlayersCount();

                if ($result) {
                    $output = array(
                        "success" => true,
                        "data" => array(
                            "total_count" => intval($result["total_count"]),
                            "alliance_count" => isset($result["alliance_count"]) ? intval($result["alliance_count"]) : 0,
                            "horde_count" => isset($result["horde_count"]) ? intval($result["horde_count"]) : 0
                        )
                    );
                } else {
                    $output = array(
                        "success" => false,
                        "error" => "Failed to fetch online player count"
                    );
                }
            } catch (PDOException $e) {
                $output = array(
                    "success" => false,
                    "error" => $e->getMessage()
                );
            }

            // 输出 JSON 数据
            header('Content-Type: application/json');
            echo json_encode($output);
        }

        /*获取封号记录的接口*/
        protected function fetchRecentBanlistData() {
            $db = $this->Connect(self::$_conf['auth']);

            $query = "
        SELECT 
            account.username,
            account.last_ip,
            account_banned.bandate,
            account_banned.unbandate,
            account_banned.banreason
        FROM 
            account_banned 
        LEFT JOIN 
            account 
        ON 
            account_banned.id = account.id 
        ORDER BY 
            account_banned.bandate DESC 
        LIMIT 50";

            return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        }
        protected function formatBanlistData($data) {
            $output = array();
            foreach ($data as $row) {
                $ban_info = array(
                    "username" => $row["username"],
                    "last_ip" => $row["last_ip"],
                    "bandate" => date("Y-m-d H:i:s", $row["bandate"]),
                    "unbandate" => date("Y-m-d H:i:s", $row["unbandate"]),
                    "banreason" => $row["banreason"]
                );
                array_push($output, $ban_info);
            }
            return $output;
        }
        public function getRecentBanlist() {
            $response = array();
            try {
                $result = $this->fetchRecentBanlistData();

                if ($result) {
                    $output = $this->formatBanlistData($result);
                    $response['success'] = true;
                    $response['data'] = $output;
                } else {
                    $response['success'] = false;
                    $response['error'] = "Failed to fetch recent banlist";
                }
            } catch (PDOException $e) {
                $response['success'] = false;
                $response['error'] = $e->getMessage();
            }

            // 输出 JSON 数据
            header('Content-Type: application/json');
            echo json_encode($response);
        }

    }