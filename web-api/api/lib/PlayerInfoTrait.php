<?php
    trait PlayerInfoTrait
    {

        /*获取金币最多的TOP 200玩家信息的接口*/
        protected function fetchTopGoldPlayers(){
            try {
                $db = $this->Connect(self::$_conf['characters']);
                $sql = "
            SELECT 
                guid, name, race, class, level, gender, money 
            FROM 
                `characters` 
            ORDER BY 
                `money` DESC
            LIMIT 200
        ";
                $top_players = $db->query($sql)->fetchAll();

                return $top_players;
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
        public function getTopGoldPlayers(){
            $response = array();
            try {
                $topPlayers = array();
                $top_players_list = $this->fetchTopGoldPlayers();

                if ($top_players_list !== false && count($top_players_list) > 0) {
                    foreach ($top_players_list as $player) {
                        $topPlayers[] =  array(
                            'Guid' => $player['guid'],
                            'Name' => $this->checkAndReplacePlayerName($player['name']),
                            'Race' => (int)$player['race'],
                            'Class' => (int)$player['class'],
                            'Gender' => (int)$player['gender'],
                            'Level' => $player['level'],
                            'Side' => $this->Fraction((int) $player['race']),
                            'TotalGold' => (int)$player['money']
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

        /*获取游戏时长最长的TOP 200玩家信息的接口*/
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
            LIMIT 200
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
                        $topPlayers[] =  array(
                            'Guid' => $player['guid'],
                            'Name' => $this->checkAndReplacePlayerName($player['name']),
                            'Race' => (int)$player['race'],
                            'Class' => (int)$player['class'],
                            'Gender' => (int)$player['gender'],
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
                    foreach ($online_list as $player) {
                        $onlinePlayers[] =  array(
                            'Guid' => $player['guid'],
                            'Name' => $this->checkAndReplacePlayerName($player['name']),
                            'Race' => (int)$player['race'],
                            'Class' => (int)$player['class'],
                            'Gender' => (int)$player['gender'],
                            'Level' => $player['level'],
                            'Side' => $this->Fraction((int) $player['race'])
                        );
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

    }