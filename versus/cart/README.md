# Cart
Пакет для работы с корзиной

        $cart = new Cart();

        $cart->addItem([
            'id' => 1,
            'title' => 'Product 1',
            'price' => 100,
            'count' => 1
        ]);

        $cart->addItem([
            'id' => 2,
            'title' => 'Product 2',
            'price' => 200,
            'count' => 1
        ]);

        $cart->updateItem([
            'id' => 2,
            'title' => 'Product 2',
            'price' => 300,
            'count' => 2
        ]);

        // Применить скидку в рублях
        $cart->setСouponPrice(100);
        // Применить скидку в процентах
        $cart->setСouponPercent(10);

        // кол-во товаров в корзине
        $cart->getTotalCount();
        
        // Общее кол-во товаров в корзине
        $cart->getTotalQuantity();

        // Цена товаров в корзине с учетом всех скидок
        $cart->getTotalPrice();