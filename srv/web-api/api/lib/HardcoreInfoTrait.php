<?php
    trait HardcoreInfoTrait
    {
        protected function ConnectRedis()
        {
            try {
                if (extension_loaded('redis')) {
                    $redis = new Redis();
                    $redis->connect(self::$_conf['redis_host'], self::$_conf['redis_port']);
                    return $redis;
                } else {
                    // Redis 扩展未安装，执行备用逻辑或抛出异常
                    throw new Exception('Redis extension is not installed.');
                }
            } catch (Exception $e) {
                // 处理异常，例如记录日志或执行备用逻辑
                echo 'Error: ' . $e->getMessage();
                // 返回其他内容或执行其他逻辑
                return null; // 或者返回其他值
            }
        }
        protected function getListFromRedis($cacheKey)
        {
            try {
                $cacheResult = $this->ConnectRedis()->get($cacheKey);

                if ($cacheResult !== false) {
                    return json_decode($cacheResult, true);
                } else {
                    return null;
                }
            } catch (Exception $e) {
                // 捕获 Redis 异常并返回 null
                return null;
            }
        }
        protected function getDataFromRedis($cacheKey) {
            $data = null;

            if (self::$_conf['enable_redis']) {
                $data = $this->getListFromRedis($cacheKey);
            }

            return $data;
        }
        protected function storeDataInRedis($cacheKey, $data) {
            if (self::$_conf['enable_redis']) {
                $this->ConnectRedis()->set($cacheKey, json_encode($data));
                $this->ConnectRedis()->expire($cacheKey, self::$_conf['redis_expire_time']); // Cache for specified time
            }
        }
        protected function returnJsonResponse($success, $data = null, $error = null) {
            $response = array();
            $response['success'] = $success;

            if ($data !== null) {
                $response['count'] = count($data);
                $response['data'] = $data;
            }

            if ($error !== null) {
                $response['error'] = $error;
            }

            // 输出 JSON 数据
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        protected function processPlayerData($player) {
            //$class = $this->ClassState($player['class']);
            return array(
                'Guid' => $player['guid'],
                'Name' => $this->checkAndReplacePlayerName($player['name']),
                'Race' => (int)$player['race'],
                'Class' => ((int)$player['class']),
                'Gender' => ((int)$player['gender']),
                'Level' => $player['character_level'],
                'Side' => $this->Fraction((int) $player['race']),
                'TotalSpentTime' => $this->totalTime($player['total_spent_time'])
            );
        }

        /*获取硬核奋进实时榜的数据接口*/
        protected function fetchInCompletedListFromMySQL()
        {
            $db = $this->Connect(self::$_conf['characters']);

            $incomplete_list = $db->query("
                SELECT
                    c.guid,
                    c.name,
                    c.race,
                    c.class,
                    c.gender,
                    f.character_level,
                    f.total_spent_time
                FROM
                    `characters` AS c
                INNER JOIN
                    `hardcore_challenge_completed` AS f ON c.guid = f.character_guid
                LEFT JOIN
                    `hardcore_challenge_failed` AS ff ON c.guid = ff.character_guid
                WHERE
                    (f.character_level < 60 OR (f.character_level > 60 AND f.character_level < 70))
                    AND name != ''
                    AND f.character_level = (
                        SELECT MAX(character_level)
                        FROM `hardcore_challenge_completed`
                        WHERE character_guid = c.guid
                    )
                    AND ff.character_guid IS NULL
                ORDER BY 
                    f.character_level DESC 
                LIMIT 200
            ")->fetchAll(PDO::FETCH_ASSOC);

            return $incomplete_list;
        }
        protected function processInCompletedListData($incomplete_list)
        {
            if ($incomplete_list !== false && count($incomplete_list) > 0) {
                $incompletePlayers = array();
                foreach ($incomplete_list as $key => $player) {
                    $incompletePlayers[$key] = $this->processPlayerData($player);
                }

                return $incompletePlayers;
            } else {
                return array();
            }
        }
        public function getHardcore_Incomplete()
        {
            try {
                $cacheKey = 'hardcore_challenge_incompleted';

                $incompletePlayers = $this->getDataFromRedis($cacheKey);

                if ($incompletePlayers === null) {
                    $incomplete_list = $this->fetchInCompletedListFromMySQL();
                    $incompletePlayers = $this->processInCompletedListData($incomplete_list);

                    $this->storeDataInRedis($cacheKey, $incompletePlayers);
                }

                $this->returnJsonResponse(true, $incompletePlayers);
            } catch (PDOException $e) {
                $this->returnJsonResponse(false, null, $e->getMessage());
            }
        }

        /*获取硬核达成霸者榜的数据接口，支持60级、70级、80级*/
        protected function fetchCompletedListFromMySQL($level)
        {
            // 验证 level 参数
            if ($level != 60 && $level != 70 && $level != 80) {
                $level = 60;
            }

            $db = $this->Connect(self::$_conf['characters']);
            // 构建动态 SQL 查询语句
            $sql = "
                SELECT 
                    c.guid, 
                    c.name, 
                    c.race, 
                    c.class, 
                    c.gender, 
                    f.character_level, 
                    f.total_spent_time 
                FROM 
                    `characters` AS c
                INNER JOIN 
                    `hardcore_challenge_completed` AS f ON c.guid = f.character_guid
                WHERE
                    f.character_level = {$level}
            ";

            $completed_list = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            return $completed_list;
        }
        protected function processCompletedListData($completed_list) {
            if ($completed_list !== false && count($completed_list) > 0) {
                $completedPlayers = array();
                foreach ($completed_list as $key => $player) {
                    $completedPlayers[$key] = $this->processPlayerData($player);
                }

                return $completedPlayers;
            } else {
                return array();
            }
        }
        public function getHardcore_Completed($level=60) {
            try {

                $cacheKey = 'hardcore_challenge_completed_' . $level;

                $completedPlayers = $this->getDataFromRedis($cacheKey);

                if ($completedPlayers === null) {
                    $completed_list = $this->fetchCompletedListFromMySQL($level);
                    $completedPlayers = $this->processCompletedListData($completed_list);

                    $this->storeDataInRedis($cacheKey, $completedPlayers);
                }

                $this->returnJsonResponse(true, $completedPlayers);

            } catch (PDOException $e) {
                $this->returnJsonResponse(false, null, $e->getMessage());
            } catch (InvalidArgumentException $e) {
                $this->returnJsonResponse(false, null, $e->getMessage());
            }
        }

        /*获取硬核失败阵亡榜的数据接口*/
        protected function fetchFailedListFromMySQL() {
                $db = $this->Connect(self::$_conf['characters']);
                $failed_list = $db->query("
                    SELECT 
                        c.guid, 
                        c.name, 
                        c.race, 
                        c.class, 
                        c.gender, 
                        f.character_level, 
                        f.total_spent_time 
                    FROM 
                        `characters` AS c
                    INNER JOIN 
                        `hardcore_challenge_failed` AS f ON c.guid = f.character_guid
                    ORDER BY f.id DESC
                    LIMIT 500
                ")->fetchAll(PDO::FETCH_ASSOC);

                return $failed_list;
            }
        protected function processFailedListData($failed_list) {
            if ($failed_list !== false && count($failed_list) > 0) {
                $failedPlayers = array();
                foreach ($failed_list as $key => $player) {
                    $failedPlayers[$key] = $this->processPlayerData($player);
                }

                return $failedPlayers;
            } else {
                return array();
            }
        }
        public function getHardcore_Fail() {
        try {
            $cacheKey = 'hardcore_challenge_failed';

            $failedPlayers = $this->getDataFromRedis($cacheKey);

            if ($failedPlayers === null) {
                $failed_list = $this->fetchFailedListFromMySQL();
                $failedPlayers = $this->processFailedListData($failed_list);

                $this->storeDataInRedis($cacheKey, $failedPlayers);
            }

            $this->returnJsonResponse(true, $failedPlayers);
        } catch (PDOException $e) {
            $this->returnJsonResponse(false, null, $e->getMessage());
        }
    }


}