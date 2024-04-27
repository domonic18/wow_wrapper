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
                LIMIT 50
            ";

            $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        protected function processTopHonorPlayersData($topPlayersData) {
            if ($topPlayersData !== false && count($topPlayersData) > 0) {
                $topPlayers = array();
                foreach ($topPlayersData as $key => $player) {
                    $topPlayers[$key] = array(
                        'Guid' => $player['guid'],
                        'Name' => $this->checkAndReplacePlayerName($player['name']),
                        'Race' => (int)$player['race'],
                        'Class' => (int)$player['class'],
                        'Gender' => (int)$player['gender'],
                        'Level' => $player['level'],
                        'Totaltime' => $this->totalTime($player['totaltime']),
                        'TotalHonorPoints' => $player['totalHonorPoints']
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