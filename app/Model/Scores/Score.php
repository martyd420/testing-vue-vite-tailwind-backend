<?php

namespace App\Model\Scores;

use Nette\SmartObject;

/**
 * @property int $radius
 * @property string $nick
 * @property string $score
 */

class Score
{

    use SmartObject;

    public int $id;
    public int $moves;
    public int $time;
    public string $nick;
    public string $score; // string, because can contains "The KING", etc.


}