<?php

namespace backend\models;

use common\models\Apple;
use yii\helpers\Html;

class AppleAction extends \yii\base\Model
{
    public $action;
    public $id;
    public $percent;

    public function rules()
    {
        return [
            [['id', 'action'], 'required'],
            ['id', 'integer'],
            ['percent', 'required', 'when' => fn() => $this->action === 'eat'],
            ['percent', 'number', 'min' => 1, 'max' => 100],
            ['action', 'string'],
            [['action'], 'in', 'range' => ['delete', 'fall', 'eat']],
        ];
    }


    public function handle(): bool
    {
        $apple = Apple::findOne($this->id);
        if (!$apple) {
            $this->addError('id', 'Apple not found');
            return false;
        }


        try {
            switch ($this->action) {
                case 'fall':
                    $apple->fallToGround();
                    break;
                case 'eat':
                    $apple->eat($this->percent);
                    break;
                case 'delete':
                    $apple->delete();
                    break;
            }
        } catch (\Exception $e) {
            $this->addError('action', $e->getMessage());
            return false;
        }

        if ($this->action !== 'delete') {
            if (!$apple->save()) {
                $this->addErrors($apple->getErrors());
                return false;
            }
        }
        return true;
    }


    public function getJsonErrors()
    {
        $result = [];
        foreach ($this->getErrors() as $attribute => $errors) {
            $result += $errors;
        }

        return $result;
    }
}