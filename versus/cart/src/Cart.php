<?php
namespace Versus\Cart;

use Exception;
use \Session;
use Versus\Cart\Coupon;

class Cart implements CartInterface {
    // Коллекция для работы с товарами в корзине
    protected $collection;

    // Имя ключа для корзины
    private $name = 'versus_cart';

    // Купон на скидку
    protected $coupon;

    public function __construct() {
        $this->collection = new Collection();
        $this->coupon = new Coupon();
    }


    public function addItem(array $product) {
        if ($this->collection->validate($product)) {
            // Если товар есть в корзине просто добавляем ему кол-во
            if ($this->hasItemById($product['id'])) {
                $item = $this->getItemById($product['id']);
                return $this->updateCount($item->id, $item->count + $product['count']);
            }
        }

        $this->collection->setItems(Session::get($this->name, []));

        $items = $this->collection->insert($product);

        Session::set($this->name, $items);

        return $this->collection->make($items);
    }


    public function removeItem (int $id) {
        $items = Session::get($this->name, []);

        unset($items[$id]);

        Session::set($this->name, $items);

        return $this->collection->make($items);
    }


    public function getCart () {
        return $this;
    }


    public function getItemList() {
        return $this->collection->make(Session::get($this->name));
    }


    public function updateItem(array $product) {
        $this->collection->setItems(Session::get($this->name, []));

        if (!isset($product['id']) || $this->hasItemById($product['id'])) {
            $item = array_merge((array) $this->getItemById($product['id']), $product);

            $items = $this->collection->insert($item);

            Session::set($this->name, $items);
        } else {
            throw new Exception('Произошла ошибка при обновлении продукта');
        }

        return $this->collection->make($items);
    }


    public function updateCount (int $id, int $count) {
        $item = (array) $this->getItemById($id);

        $item['count'] = $count;

        return $this->updateItem($item);
    }


    public function updatePrice(int $id, float $price) {
        $item = (array)$this->getItemById($id);

        $item['price'] = $price;

        return $this->updateItem($item);
    }


    public function getItemById(int $id) {
        $this->collection->setItems(Session::get($this->name, []));

        return $this->collection->findItem($id);
    }


    public function hasItemById(int $id) {
        $this->collection->setItems(Session::get($this->name, []));

        return $this->collection->findItem($id)? true : false;
    }


    public function getTotalCount() {
        $items = $this->getItemList();
        return $items->count();
    }


    public function getTotalPrice() {
        $result = 0;
        $items = $this->getItemList();

        $result = $items->sum(function($item) {
            return $item->price * $item->count;
        });

        if ($this->coupon->summa > 0) {
            $result -= $this->coupon->summa;
        }

        if ($this->coupon->percent > 0) {
            $result = $result - $result * ($this->coupon->percent / 100);
        }

        return $result;
    }


    public function getTotalQuantity() {
        $items = $this->getItemList();

        return $items->sum(function($item) {
            return $item->count;
        });
    }


    public function clearCart() {
        $result = false;

        Session::remove($this->name);
        if ($this->getTotalQuantity() == 0) {
            $result = true;
        }

        return $result;
    }

    public function addCountByItem (int $id, int $count) {
        $item = (array) $this->getItemById($id);

        if($item['count'] + $count > 0)
            $item['count'] = $item['count'] + $count;

        return $this->updateItem($item);
    }


    public function getCount($id) {
        $item = (array) $this->getItemById($id);

        if (!empty($item) && isset($item['count']))
            return  $item['count'];
        else
            return 0;
    }


    public function setСouponPercent(int $percent) {
        $this->coupon->percent = $percent;
    }

    public function setСouponPrice(float $price) {
        $this->coupon->summa = $price;
    }
}