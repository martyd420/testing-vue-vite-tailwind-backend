<?php

namespace App\Model\Scores;

use Nette\Database\Explorer;

class ScoresModel
{

    /** @var Explorer $database
    private $database;

    public function __construct(Explorer $d)
    {
        $this->database = $d;
    }
*/

    /** @return Score[] */
    public function getScores($limit = 10): array
    {
        $scoredb = [
            ['id' => 1, 'nick' => 'martyd420', 'score' => '9999'],
            ['id' => 5, 'nick' => 'Pan Ředitel', 'score' => '2048'],
            ['id' => 5, 'nick' => 'Pr00y4m', 'score' => '1024'],
            ['id' => 5, 'nick' => 'elixido', 'score' => '512'],
            ['id' => 5, 'nick' => '3x07', 'score' => '256'],
            ['id' => 5, 'nick' => 'marty.dee', 'score' => '128'],
            ['id' => 5, 'nick' => 'marty.dream', 'score' => '64'],
            ['id' => 2, 'nick' => 'muj-nyck', 'score' => '0' . (32 + mt_rand(8, 64)) ],
            ['id' => 3, 'nick' => 'Vykolej Rozkašil', 'score' => '16'],
            ['id' => 4, 'nick' => 'Hulitó Nakashi', 'score' => '8'],
        ];

        $return = [];
        foreach ($scoredb as $item) {
            $tmps           = new Score();
            $tmps->id       = $item['id'];
            $tmps->nick     = $item['nick'];
            $tmps->score    = $item['score'];

            $return[] = $tmps;
        }

        return $return;
    }

}