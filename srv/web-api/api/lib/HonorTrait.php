<?php

    trait HonorTrait
    {
        protected function fetchTopHonorPlayersFromMySQL() {
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
                    c.totalHonorPoints
                FROM 
                    characters AS c
                ORDER BY totalHonorPoints DESC
                LIMIT 200
            ";

            $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }
        protected function processTopHonorPlayersData($topPlayersData) {
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
                        'total_time' => $this->totalTime($player['totaltime']),
                        'total_honor_points' => $player['totalHonorPoints']
                    );
                }

                return $topPlayers;
            } else {
                return array();
            }
        }
        public function getTopHonorPlayers() {
            try {
                $cacheKey = 'top_honor_players';

                $topPlayers = $this->getDataFromRedis($cacheKey);

                if ($topPlayers === null) {
                    $topPlayersData = $this->fetchTopHonorPlayersFromMySQL();
                    $topPlayers = $this->processTopHonorPlayersData($topPlayersData);

                    $this->storeDataInRedis($cacheKey, $topPlayers);
                }

                $this->returnJsonResponse(true, $topPlayers);
            } catch (PDOException $e) {
                $this->returnJsonResponse(false, null, $e->getMessage());
            }
        }

    }