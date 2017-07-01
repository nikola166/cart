<?php
namespace Versus\Cart;

class Coupon {

    public $summa;
    public $percent;

    /**
     * Конструктор
     * @param float $summa - Сумма скидки
     * @param integer $percent - Процент скидки
     */
    public function __construct(float $summa = 0, int $percent = 0) {
        $this->summa = $summa;
        $this->percent = $percent;
    }
}