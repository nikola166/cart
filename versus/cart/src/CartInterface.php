<?php
namespace Versus\Cart;

interface CartInterface {
    /*
     * Добавить товар
     * @param array $product
     * @return Versus\Cart\Collection
     */
    public function addItem (array $product);

    /*
     * Удалить товар
     * @param int $id
     * @return Versus\Cart\Collection
     */
    public function removeItem (int $id);

    /*
     * Возвращает список товаров из корзине
     * @return Versus\Cart\Collection
     */
	public function getItemList();

    /*
    * Изменить товар в корзине
    * @return Versus\Cart\Collection
    */
	public function updateItem(array $product);

    /**
     * Возвращает товар из корзины по его id
     * @param int $id
     * @return Versus\Cart\Collection
     */
    public function getItemById(int $id);

    /**
     * Проверяет существования товара в корзины по его id
     * @param int $id
     * @return boolean
     */
    public function hasItemById(int $id);

    /*
    * Очистка корзины
    * @return bool
    */
    public function clearCart();

    /*
    * Возвращает сумму корзины
    * @return float
    */
    public function getTotalPrice();

    /*
    * Возвращает кол-во товаров в корзине
    * @return integer
    */
    public function getTotalCount();

    /**
     * Возвращает общее кол-во товаров в корзине
     * @return integer
     */
    public function getTotalQuantity();

    /**
     * Применить скидку в процентах
     * @param $percent
     * @return void
     */
    public function setСouponPercent(int $percent);

    /**
     * Применить скидку в рублях
     * @param float $price
     * @return void
     */
    public function setСouponPrice(float $price);

    /**
     * Обновить кол-во товара в корзине
     * @param int $id
     * @param int $count
     * @return Versus\Cart\Collection
     */
    public function updateCount(int $id, int $count);


    /**
     * Изменение цены товара корзине
     * @param int $id
     * @param float $price
     * @return Versus\Cart\Collection
     */
    public function updatePrice(int $id, float $price);

    /**
     * Добавление кол-ва товара корзине
     * @param int $id
     * @param int $count
     * @return Versus\Cart\Collection
     */
    public function addCountByItem (int $id, int $count);
}