<?php
    trait PlayerMountTrait
    {
        private $mountIds = []; // 用于保存读取的ID数组
        protected function readMounts(){
            // 获取文件的绝对路径
            $file = fopen(dirname(__DIR__)  . '/csv/spell.csv', 'r');

            // 将Mechanic列为21的所有ID查找出来保存到数组中
            while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
                if (isset($data[3]) && $data[3] == '21') { // 检查Mechanic列是否为21
                    $this->mountIds[] = $data[0]; // 将ID添加到属性中保存
                }
            }

            fclose($file);
        }

        protected function fetchTopMountPlayersFromMySQL(){
            $mountIdsString = implode(',', $this->mountIds);
            try {
                $db = $this->Connect(self::$_conf['characters']);
                $sql = "
                    SELECT 
                        c.guid, 
                        c.name, 
                        c.race, 
                        c.class, 
                        c.level, 
                        c.gender, 
                        COUNT(cs.spell) AS mount_count,
                        GROUP_CONCAT(cs.spell) AS mount_ids,
                        GROUP_CONCAT(cs.spell) AS mount_ids_list
                    FROM 
                        characters c
                    LEFT JOIN 
                        character_spell cs ON c.guid = cs.guid
                    WHERE 
                        cs.spell IN ($mountIdsString)
                    GROUP BY 
                        c.guid, c.name, c.race, c.class, c.level, c.gender
                    ORDER BY 
                        mount_count DESC
                    LIMIT 100;
                ";
                $top_players = $db->query($sql)->fetchAll();

                return $top_players;
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
        protected function processTopMountPlayersData($topPlayersData) {
            if ($topPlayersData !== false && count($topPlayersData) > 0) {
                $topPlayers = array();
                foreach ($topPlayersData as $key => $player) {
                    $topPlayers[$key] = array(
                        'guid' => $player['guid'],
                        'name' => $this->checkAndReplacePlayerName($player['name']),
                        'race' => (int)$player['race'],
                        'class' => (int)$player['class'],
                        'gender' => (int)$player['gender'],
                        'level' => $player['level'],
                        'side' => $this->Fraction((int) $player['race']),
                        'total_mount_counts' => (int)$player['mount_count'],
                        'mount_ids' => $player['mount_ids']
                    );
                }

                return $topPlayers;
            } else {
                return array();
            }
        }
        public function getTopMountPlayers(){
            if (empty($this->mountIds)) { // 如果mountIds为空，则执行读取操作
                $this->readMounts();
            }

            try {
                $cacheKey = 'top_mount_players';

                $topPlayers = $this->getDataFromRedis($cacheKey);

                if ($topPlayers === null) {
                    $topPlayersData = $this->fetchTopMountPlayersFromMySQL();
                    $topPlayers = $this->processTopMountPlayersData($topPlayersData);

                    $this->storeDataInRedis($cacheKey, $topPlayers);
                }

                $this->returnJsonResponse(true, $topPlayers);
            } catch (PDOException $e) {
                $this->returnJsonResponse(false, null, $e->getMessage());
            }
        }

    }
