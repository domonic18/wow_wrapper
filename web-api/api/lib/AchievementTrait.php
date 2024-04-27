<?php
    trait AchievementTrait
    {
        /*获取成就点数TOP 50玩家名称的接口*/
        protected function fetchTopAchievementPlayersFromMySQL() {
            $db = $this->Connect(self::$_conf['characters']);

            $sql = "
                SELECT 
                    c.guid, 
                    c.name, 
                    c.race, 
                    c.class, 
                    c.gender, 
                    c.level,
                    c.totaltime,
                    SUM(a.Points) as total_achieve_points
                FROM 
                    acore_characters.`characters` AS c
                INNER JOIN 
                    acore_characters.`character_achievement` AS ca ON c.guid = ca.guid
                INNER JOIN 
                    acore_world.`achievement_dbc` AS a ON ca.achievement = a.ID
                GROUP BY c.guid
                ORDER BY total_achieve_points DESC
                LIMIT 50
            ";

            $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }
        protected function processTopAchievementPlayersData($playersData) {
            $topPlayers = array();

            foreach ($playersData as $key => $player) {
                $topPlayers[$key] = array(
                    'Guid' => $player['guid'],
                    'Name' => $player['name'],
                    'Race' => (int)$player['race'],
                    'Class' => (int)$player['class'],
                    'Gender' => (int)$player['gender'],
                    'Level' => $player['level'],
                    'Totaltime' => $this->totalTime($player['totaltime']),
                    'Total_achieve_points' => $player['total_achieve_points']
                );
            }

            return $topPlayers;
        }
        public function getTopAchievementPlayers() {
            try {
                $cacheKey = 'top_achievement_players';

                $topPlayers = $this->getDataFromRedis($cacheKey);

                if ($topPlayers === null) {
                    $topPlayersData = $this->fetchTopAchievementPlayersFromMySQL();
                    $topPlayers = $this->processTopAchievementPlayersData($topPlayersData);

                    $this->storeDataInRedis($cacheKey, $topPlayersData);
                }

                $this->returnJsonResponse(true, $topPlayers);
            } catch (PDOException $e) {
                // 处理数据库异常情况
                $this->returnJsonResponse(false, null, $e->getMessage());
            }
        }

        /*获取最近的成就事件接口*/
        protected function fetchRecentAchievementsFromMySQL() {
            $db = $this->Connect(self::$_conf['characters']);

            $sql = "
                SELECT
                    c.guid, 
                    c.name, 
                    c.race, 
                    c.class, 
                    c.gender, 
                    c.level, 
                    ad.Title_Lang_deDE AS achievement_description, 
                    FROM_UNIXTIME(ca.date) AS achievement_date
                FROM 
                    acore_characters.character_achievement AS ca
                INNER JOIN 
                    acore_characters.characters AS c ON ca.guid = c.guid
                INNER JOIN 
                    acore_world.achievement_dbc AS ad ON ca.achievement = ad.ID
                ORDER BY ca.date DESC
                LIMIT 50
            ";

            $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        protected function processRecentAchievementsData($playersData) {
            $recentAchievements = array();

            foreach ($playersData as $key => $player) {
                $recentAchievements[$key] = array(
                    'Guid' => $player['guid'],
                    'Name' => $player['name'],
                    'Race' => (int)$player['race'],
                    'Class' => (int)$player['class'],
                    'Gender' => (int)$player['gender'],
                    'Level' => $player['level'],
                    'Achievement_description' => $player['achievement_description'],
                    'Achievement_date' => $player['achievement_date']
                );
            }

            return $recentAchievements;
        }
        public function getRecentAchievements() {
            try {
                $cacheKey = 'recent_achievement';

                $recentAchievementsPlayers = $this->getDataFromRedis($cacheKey);
                if ($recentAchievementsPlayers === null) {
                    $recentAchievementsData = $this->fetchRecentAchievementsFromMySQL();
                    $recentAchievementsPlayers = $this->processRecentAchievementsData($recentAchievementsData);

                    $this->storeDataInRedis($cacheKey, $recentAchievementsPlayers);
                }

                $this->returnJsonResponse(true, $recentAchievementsPlayers);
            } catch (PDOException $e) {
                $this->returnJsonResponse(false, null, $e->getMessage());
            }
        }

    }