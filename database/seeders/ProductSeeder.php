<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Cold Drinks
            ['name' => 'Iced Caramel Macchiato',     'category' => 'Cold Drinks',   'description' => 'Freshly steamed milk with vanilla-flavoured syrup, espresso, and caramel drizzle.',      'price' => 5.75, 'calories' => 250, 'badge' => 'Fan Fave', 'image' => 'products/caramel_macchiato.png'],
            ['name' => 'Sweet Cream Cold Brew',       'category' => 'Cold Drinks',   'description' => 'Slow-steeped cold brew topped with a float of house-made vanilla sweet cream.',           'price' => 5.95, 'calories' => 185, 'badge' => 'Trending', 'image' => 'products/cold_brew.png'],
            ['name' => 'Iced Matcha Latte',           'category' => 'Cold Drinks',   'description' => 'Smooth premium matcha blended with creamy oat milk over a bed of ice.',                   'price' => 5.45, 'calories' => 200, 'badge' => null,       'image' => 'products/matcha_latte.png'],
            ['name' => 'Mango Dragonfruit Refresher', 'category' => 'Cold Drinks',   'description' => 'A tropical blend of sweet mango and dragonfruit flavours with real fruit pieces.',        'price' => 5.25, 'calories' => 90,  'badge' => 'New',      'image' => null],
            ['name' => 'Strawberry Acai Refresher',   'category' => 'Cold Drinks',   'description' => 'A delicious combination of sweet strawberry flavours, acai, and a hint of passionfruit.', 'price' => 5.25, 'calories' => 100, 'badge' => 'Fan Fave', 'image' => null],

            // Hot Drinks
            ['name' => 'Caramel Latte',               'category' => 'Hot Drinks',    'description' => 'Rich espresso with steamed milk and buttery caramel syrup.',                              'price' => 5.25, 'calories' => 280, 'badge' => null,       'image' => null],
            ['name' => 'Flat White',                  'category' => 'Hot Drinks',    'description' => 'Smooth ristretto shots with velvety steamed whole milk.',                                 'price' => 5.00, 'calories' => 170, 'badge' => 'Fan Fave', 'image' => null],
            ['name' => 'Classic Cappuccino',           'category' => 'Hot Drinks',    'description' => 'Dark espresso with perfectly frothed foam on top.',                                       'price' => 4.75, 'calories' => 120, 'badge' => null,       'image' => null],
            ['name' => 'Pike Place Roast',             'category' => 'Hot Drinks',    'description' => 'A smooth, well-rounded blend of Latin American coffees with subtle notes of cocoa.',     'price' => 3.75, 'calories' => 5,   'badge' => null,       'image' => null],

            // Frappuccino
            ['name' => 'Caramel Frappuccino',         'category' => 'Frappuccino',   'description' => 'Coffee blended with milk and ice, topped with whipped cream and buttery caramel sauce.',  'price' => 6.25, 'calories' => 380, 'badge' => 'New',      'image' => 'products/frappuccino.png'],
            ['name' => 'Mocha Frappuccino',            'category' => 'Frappuccino',   'description' => 'Coffee and mocha sauce blended with milk and ice, topped with whipped cream.',            'price' => 6.25, 'calories' => 400, 'badge' => 'Fan Fave', 'image' => null],
            ['name' => 'Vanilla Bean Frappuccino',     'category' => 'Frappuccino',   'description' => 'A cream-based frappuccino with vanilla bean powder blended with milk and ice.',           'price' => 5.95, 'calories' => 350, 'badge' => null,       'image' => null],

            // Teas & Chai
            ['name' => 'Chai Tea Latte',               'category' => 'Teas & Chai',   'description' => 'Black tea infused with cinnamon, clove, and other warming spices with steamed milk.',    'price' => 5.25, 'calories' => 240, 'badge' => 'Fan Fave', 'image' => null],
            ['name' => 'Iced Green Tea Latte',          'category' => 'Teas & Chai',   'description' => 'Sweetened premium matcha whisked into cold milk served over ice.',                       'price' => 4.95, 'calories' => 190, 'badge' => null,       'image' => null],
            ['name' => 'Peach Green Tea Lemonade',      'category' => 'Teas & Chai',   'description' => 'Shaken together with lemonade and ice for a delightfully refreshing combination.',       'price' => 4.75, 'calories' => 130, 'badge' => 'Seasonal', 'image' => null],

            // Bakery
            ['name' => 'Butter Croissant',             'category' => 'Bakery',        'description' => 'Layers of buttery, flaky pastry baked to a perfect golden brown.',                       'price' => 3.50, 'calories' => 290, 'badge' => null,       'image' => null],
            ['name' => 'Chocolate Muffin',             'category' => 'Bakery',        'description' => 'Rich moist chocolate cake with chocolate chips throughout.',                              'price' => 3.75, 'calories' => 420, 'badge' => 'Fan Fave', 'image' => null],
            ['name' => 'Cinnamon Roll',                'category' => 'Bakery',        'description' => 'A tender, gooey pastry swirled with cinnamon sugar and topped with cream cheese icing.',  'price' => 4.25, 'calories' => 430, 'badge' => 'New',      'image' => null],

            // Food & Snacks
            ['name' => 'Egg & Cheese Sandwich',        'category' => 'Food & Snacks', 'description' => 'Fluffy cage-free egg and aged cheddar on an artisan roll.',                              'price' => 4.95, 'calories' => 470, 'badge' => null,       'image' => null],
            ['name' => 'Protein Box',                  'category' => 'Food & Snacks', 'description' => 'Hard boiled eggs, sliced apples, white cheddar, and multigrain crackers.',               'price' => 7.95, 'calories' => 470, 'badge' => 'New',      'image' => null],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['is_available' => true]));
        }
    }
}
