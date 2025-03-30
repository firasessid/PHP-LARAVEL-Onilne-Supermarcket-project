<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and products
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No users or products found in the database.');
            return;
        }

        $remainingProducts = $products->toArray();
        $userCount = $users->count();
        $userIndex = 0;

        while (!empty($remainingProducts)) {
            // Get the current user
            $user = $users[$userIndex];

            // Determine how many products the user will order (random between 5 and 10)
            $productCount = rand(5, 10);

            // Get products for this order
            $orderProducts = array_splice($remainingProducts, 0, $productCount);

            if (empty($orderProducts)) {
                break;
            }

            // Possible payment methods
            $paymentMethods = ['card', 'paypal', 'cod'];

            // Generate a random shipped_date in the last 3 months
            $shippedDate = $this->generateRandomShippedDate();

            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => 0, // Will be calculated
                'shipping' => 10.00, // Example fixed shipping cost
                'grand_total' => 0, // Will be calculated
                'payment_status' => 'paid', // Payment status is "paid"
                'status' => 'delivered', // Order status is "delivered"
                'payment_method' => 'paypal', // Random payment method
                'country_id' => rand(76, 86), // Random city_id between 1 and 10
                'adresse' => '123 Main St',
                'adresse2' => '',
                'phone' => '123456789',
                'zip' => '1245',
                'shipped_date' => $shippedDate, // Add shipped_date
                'created_at' => $this->generateRandomCreatedAt(), // Add random created_at date for the last 3 months
            ]);

            $subtotal = 0;

            foreach ($orderProducts as $productData) {
                $product = Product::find($productData['id']);

                if (!$product) {
                    $this->command->warn("Product with ID {$productData['id']} not found. Skipping...");
                    continue;
                }

                if (is_null($product->sale_price)) {
                    $this->command->error("Product with ID {$product->id} has a NULL sale_price! Skipping...");
                    continue;
                }

                $qty = rand(5, 15); // Random quantity for each product

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'qty' => $qty,
                    'price' => $product->sale_price, // Use sale_price here
                    'total' => $product->sale_price * $qty,
                ]);

                // Update the subtotal
                $subtotal += $product->sale_price * $qty;
            }

            // Update the order totals
            $order->update([
                'subtotal' => $subtotal,
                'grand_total' => $subtotal + $order->shipping,
            ]);

            // Move to the next user
            $userIndex = ($userIndex + 1) % $userCount;
        }
    }

    /**
     * Generate a random shipped date within the last 3 months.
     */
    private function generateRandomShippedDate()
    {
        // Choose a random month between 3 months ago and the current month
        $randomMonth = rand(0, 2); // 0 for current month, 1 for last month, 2 for two months ago

        $shippedDate = Carbon::now()->subMonths($randomMonth)->startOfMonth()->addDays(rand(0, Carbon::now()->subMonths($randomMonth)->daysInMonth - 1));

        // Return the generated random shipped date
        return $shippedDate;
    }

    /**
     * Generate a random created_at date within the last 3 months.
     */
    private function generateRandomCreatedAt()
    {
        // Choose a random month between 3 months ago and the current month
        $randomMonth = rand(0, 2); // 0 for current month, 1 for last month, 2 for two months ago

        $date = Carbon::now()->subMonths($randomMonth)->startOfMonth()->addDays(rand(0, Carbon::now()->subMonths($randomMonth)->daysInMonth - 1));

        // Return a random time in the day (optional)
        return $date->setTime(rand(0, 23), rand(0, 59));
    }
}



// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\Order;
// use App\Models\OrderItem;
// use App\Models\Product;
// use App\Models\User;
// use Carbon\Carbon;

// class OrdersTableSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         // Get all users and products
//         $users = User::all();
//         $products = Product::all();

//         if ($users->isEmpty() || $products->isEmpty()) {
//             $this->command->info('No users or products found in the database.');
//             return;
//         }

//         $remainingProducts = $products->toArray();
//         $userCount = $users->count();
//         $userIndex = 0;

//         while (!empty($remainingProducts)) {
//             // Get the current user
//             $user = $users[$userIndex];

//             // Determine how many products the user will order (random between 5 and 10)
//             $productCount = rand(5, 10);

//             // Get products for this order
//             $orderProducts = array_splice($remainingProducts, 0, $productCount);

//             if (empty($orderProducts)) {
//                 break;
//             }

//             // Possible payment methods
//             $paymentMethods = ['card', 'paypal', 'cod'];

//             // Generate a random shipped_date in the previous month
//             $shippedDate = Carbon::now()->subMonth()->startOfMonth()->addDays(rand(0, Carbon::now()->subMonth()->daysInMonth - 1));

//             // Create the order
//             $order = Order::create([
//                 'user_id' => $user->id,
//                 'subtotal' => 0, // Will be calculated
//                 'shipping' => 10.00, // Example fixed shipping cost
//                 'grand_total' => 0, // Will be calculated
//                 'payment_status' => 'paid', // Payment status is "paid"
//                 'status' => 'delivered', // Order status is "delivered"
//                 'payment_method' => $paymentMethods[array_rand($paymentMethods)], // Random payment method
//                 'country_id' => rand(1, 10), // Random city_id between 1 and 10
//                 'adresse' => '123 Main St',
//                 'adresse2' => '',
//                 'phone' => '123456789',
//                 'zip' => '12345',
//                 'shipped_date' => $shippedDate, // Add shipped_date
//                 'created_at' => $this->generateRandomCreatedAt(), // Add random created_at date for the previous month
//             ]);

//             $subtotal = 0;

//             foreach ($orderProducts as $productData) {
//                 $product = Product::find($productData['id']);

//                 if (!$product) {
//                     $this->command->warn("Product with ID {$productData['id']} not found. Skipping...");
//                     continue;
//                 }

//                 if (is_null($product->sale_price)) {
//                     $this->command->error("Product with ID {$product->id} has a NULL sale_price! Skipping...");
//                     continue;
//                 }

//                 $qty = rand(5, 15); // Random quantity for each product

//                 // Create order item
//                 OrderItem::create([
//                     'order_id' => $order->id,
//                     'product_id' => $product->id,
//                     'name' => $product->name,
//                     'qty' => $qty,
//                     'price' => $product->sale_price, // Use sale_price here
//                     'total' => $product->sale_price * $qty,
//                 ]);

//                 // Update the subtotal
//                 $subtotal += $product->sale_price * $qty;
//             }

//             // Update the order totals
//             $order->update([
//                 'subtotal' => $subtotal,
//                 'grand_total' => $subtotal + $order->shipping,
//             ]);

//             // Move to the next user
//             $userIndex = ($userIndex + 1) % $userCount;
//         }
//     }

//     /**
//      * Generate a random created_at date within the previous month.
//      */
//     private function generateRandomCreatedAt()
//     {
//         // Generate a random date in the previous month
//         $date = Carbon::now()->subMonth()->startOfMonth()->addDays(rand(0, Carbon::now()->subMonth()->daysInMonth - 1));
        
//         // Return a random time in the day
//         return $date->setTime(rand(0, 23), rand(0, 59));
//     }
// }
