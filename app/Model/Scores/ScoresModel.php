<?php

namespace App\Model\Scores;

use App\Model\Exceptions\SpammerException;
use App\Model\Exceptions\ZeroScoreException;
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


    /** @noinspection PhpUndefinedFieldInspection */
    /**
     * @throws SpammerException
     * @throws ZeroScoreException
     */
    public function saveScore(Score $score)
    {
        // antispam check
        $last = $this->database->table('score')
            ->where('ip = ?', $_SERVER['REMOTE_ADDR'])
            ->order('time DESC')
            ->limit(1)
            ->fetch();

        if (time() - $last->time < 60) {
            throw new SpammerException();
        }

        if ($score->score = 0) {
            throw new ZeroScoreException();
        }

        $insert = [
            'score' => $score->score,
            'nick'  => $score->nick,
            'moves' => $score->moves,
            'time'  => $score->time,
            'ip'    => $_SERVER['REMOTE_ADDR'],
        ];
        $this->database->table('score')->insert($insert);
    }

}