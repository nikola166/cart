<?php 
namespace Versus\Cart;

use Illuminate\Support\Collection as IlluminateCollection;
use Exception;

class Collection extends IlluminateCollection
{
    // Все элементы в корзине
    protected $items;

    // Необходимые поля
    protected $fields = [
        'id',
        'title',
        'price',
        'count'
    ];


    public function setItems(array $items) {
        $this->items = $items;
    }


    public function getItems() {
        return $this->items;
    }

    public function findItem($key) {
        return isset($this->items[$key])? $this->items[$key] : null;
    }


    public function has($item) {
        $result = false;

        if ($this->findItem($item['id'])) $result = true;

        return $result;
    }

    public function insert(array $item) {
        $this->validate($item);

        $this->items[$item['id']] = (object) $item;

        return $this->items;
    }

    public function update(array $item) {
        return $this->insert($item);
    }

    /**
     * Валидация добавляемого товара
     *
     * @param array $item
     * @return bool
     */
    public function validate (array $item) {
        $result = true;

        $fields = array_diff_key(array_flip($this->fields), $item);

        if ($fields || $item['count'] < 1 || !is_numeric($item['price'])) {
            $result = false;
        }

        return $result;
    }
}