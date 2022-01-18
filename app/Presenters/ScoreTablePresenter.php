<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Scores\Score;
use App\Model\Scores\ScoresModel;
use Nette;


final class ScoreTablePresenter extends Nette\Application\UI\Presenter
{

    public ScoresModel $scoresModel;

    public function __construct(ScoresModel $sm)
    {
        $this->scoresModel = $sm;
    }


    public function startup()
    {
        parent::startup();
        $this->getHttpResponse()->addHeader('Access-Control-Allow-Origin', '*');
    }


    public function renderGetScores()
    {
        $scores = $this->scoresModel->getScores();
        $this->sendJson($scores);
    }

}