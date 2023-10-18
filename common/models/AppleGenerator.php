<?php

namespace common\models;

class AppleGenerator
{
    const COLORS = [
        'red',
        'yellow',
        'green',
    ];

    public static function generate(string|int $number): bool
    {
        if ($number === 'random') {
            $number = random_int(0, 100);
        }

        if (is_numeric($number)) {
            $number = (int)$number;
            $apples = [];
            for ($i = 0; $i < $number; $i++) {
                $apples[] = new Apple([
                    'color' => static::generateColor(),
                    'created_at' => date("Y-m-d H:i:s", static::generateTimestamp())
                ]);
            }

            $success = true;
            $transaction = \Yii::$app->db->beginTransaction();

            foreach ($apples as $apple) {
                $success &= $apple->save();
            }

            if ($success) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }

            return $success;
        }
        return false;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    protected static function generateColor(): string
    {
        return static::COLORS[random_int(0, count(static::COLORS) - 1)];
    }

    /**
     * По тз зачем-то надо генерить дату создания в unixTimestamp
     *
     * @return int
     *
     * @throws \Exception
     */
    protected static function generateTimestamp(): int
    {
        return random_int(0, time());
    }
}