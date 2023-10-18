<?php

namespace common\models;

use common\enums\AppleStatus;
use common\exceptions\CantEatException;
use common\exceptions\CantFallException;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $color
 * @property string $fell_at
 * @property string $created_at
 * @property float $eaten_percent
 *
 * @property-read AppleStatus $status
 * @property-read float $size
 */
class Apple extends ActiveRecord
{
    const ROTTEN_AFTER_HOURS = 5;

    public function rules()
    {
        return [
            [['color'], 'required'],
            ['color', 'string'],
            [['fell_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s']
        ];
    }


    public function getStatus(): AppleStatus
    {
        if ($this->eaten_percent == 1.0) {
            return AppleStatus::Eaten;
        }

        if ($this->fell_at) {
            if ($this->fell_at < date('Y-m-d H:i:s', strtotime('-' . static::ROTTEN_AFTER_HOURS . ' hours'))) {
                return AppleStatus::Rotten;
            }

            return AppleStatus::Fresh;
        }

        return AppleStatus::OnTree;
    }

    public function fallToGround(): Apple
    {
        if ($this->fell_at) {
            throw new CantFallException('apple cant fall twice');
        }

        $this->fell_at = date('Y-m-d H:i:s');

        return $this;
    }

    public function eat(int $percent): Apple
    {
        if (!$this->fell_at) {
            throw new CantEatException('apple still on tree');
        }
        if (($percent * 0.01 + $this->eaten_percent) > 1) {
            throw new CantEatException('you cant eat more than full apple');
        }
        $this->eaten_percent += $percent * 0.01;

        return $this;
    }

    public function getSize(): float
    {
        return 1.0 - $this->eaten_percent;
    }
}