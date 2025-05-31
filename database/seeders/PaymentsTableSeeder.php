<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $paymentMethods = ['credit_card', 'paypal', 'upi', 'net_banking'];
        $paymentType = ['By Online', 'By Cash'];
        $statuses = ['pending', 'completed', 'failed'];

        foreach (range(1, 10) as $index) {
            DB::table('payments')->insert([
                'user_id' => rand(1, 5),
                'payment_type' => $faker->randomElement($paymentType),
                'order_id' => 'ORD-' . strtoupper($faker->lexify('??????')),
                'transaction_id' => strtoupper($faker->regexify('TXN-[A-Z0-9]{12}')),
                'payment_method' => $faker->randomElement($paymentMethods),
                'amount' => $faker->randomFloat(2, 10, 500), // Amount between 10 and 500
                'currency' => 'INR',
                'status' => $faker->randomElement($statuses),
                'gateway_response' => json_encode([
                    'response_code' => 200,
                    'response_message' => $faker->sentence,
                ]),
                'payment_date' => $faker->dateTimeBetween('-30 days', 'now'),
                'refund_status' => 'not_requested',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
