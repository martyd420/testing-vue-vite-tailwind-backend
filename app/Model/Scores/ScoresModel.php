<?php

namespace App\Model\Scores;

use Nette\Database\Explorer;

class ScoresModel
{

    /** @var Explorer $database */
    private $database;

    public function __construct(Explorer $d)
    {
        $this->database = $d;
    }


    /** @return Score[] */
    public function getScores($limit = 10): array
    {
        $scores = $this->database->table('score')->order('score DESC')->limit($limit);

        $return = [];
        foreach ($scores as $item) {
            $tmps           = new Score();
            $tmps->id       = $item['id'];
            $tmps->nick     = $item['nick'];
            $tmps->score    = $item['score'];

            $return[] = $tmps;
        }

        return $return;
    }


    public function saveScore(Score $score)
    {
        $insert = [
            'score' => $score->score,
            'nick' => $score->nick,
            'moves' => $score->moves,
            'time' => $score->time,
        ];
        $this->database->table('score')->insert($insert);
    }

}