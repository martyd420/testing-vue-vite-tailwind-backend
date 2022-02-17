<?php
/** @noinspection PhpMissingParentConstructorInspection */

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Exceptions\SpammerException;
use App\Model\Scores\Score;
use App\Model\Scores\ScoresModel;
use Nette;
use stdClass;


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

        // this is public api
        $response = $this->getHttpResponse();
        $response->addHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'Accept, Content-Type, Authorization');
        $response->setHeader('Access-Control-Allow-Methods', 'POST, GET, PATCH, OPTIONS, HEAD');


        $req = $this->getHttpRequest();
        if ($req->isMethod('OPTIONS')) {
            die();
        }
    }


    /**
     * @throws Nette\Application\AbortException
     */
    public function renderGetScores()
    {
        $scores = $this->scoresModel->getScores();
        $this->sendJson($scores);
    }


    /**
     * @throws Nette\Application\AbortException
     */
    public function renderUploadScore()
    {
        $time = time();
        // get data from ajax request
        $input = json_decode(file_get_contents('php://input'), true);
        $input = json_encode($input);
        $score_data = json_decode($input);

        $ret = new stdClass();

        if ($score_data->speed == floor(1 + $score_data->score / $score_data->moves)) {
            $ret->scorestatus = 'ok';
            $ret->time = $time;

            $score = new Score;
            $score->nick = $score_data->nick;
            $score->score = $score_data->score;
            $score->moves = (int)$score_data->moves;
            $score->time = $time;

            try {
                $this->scoresModel->saveScore($score);
            } catch (SpammerException $e) {
                $ret->scorestatus = 'err';
                $ret->message = 'ANTISPAM: Zdá se, že příliš rychle za sebou odesíláte nové score.';
                $ret->time = 0;
            }

        } else {
            $ret->scorestatus = 'err';
            $ret->time = 0;
        }


        $this->sendJson($ret);
    }
    

}