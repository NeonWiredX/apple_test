<?php

namespace console\controllers;

use common\exceptions\CantEatException;
use common\exceptions\CantFallException;
use common\models\Apple;
use Yii;
use yii\console\Controller;
use yii\log\Logger;

class TestController extends Controller
{
    public function actionApple()
    {
        $apple = new Apple(['color' => 'red']);
        $this->log($apple->status->name);
        $this->log($apple->color);

        try {
            $apple->eat(80);
        } catch (CantEatException $exception) {
            $this->log('Catched exeption: ' . $exception->getMessage());
        }

        $apple->fallToGround();

        $this->log($apple->status->name);

        $this->log(
            $apple
                ->eat(25)
                ->size
        );

        $this->log($apple->status->name);

        try {
            $apple->eat(80);
        } catch (CantEatException $exception) {
            $this->log('Catched exeption: ' . $exception->getMessage());
        }


        try {
            $apple->fallToGround();
        } catch (CantFallException $exception) {
            $this->log('Catched exeption: ' . $exception->getMessage());
        }

        $this->log(
            $apple
                ->eat(75)
                ->size
        );

        $this->log($apple->status->name);

        $apple2 = new Apple([
            'color' => 'yellow',
            'fell_at' => date('Y-m-d H:i:s', strtotime('-' . Apple::ROTTEN_AFTER_HOURS + 1 . ' hours'))
        ]);

        $this->log($apple2->status->name);

    }

    protected function log(string $message): void
    {
        echo $message . PHP_EOL;
    }
}