<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Transfer;

class TransferTableSeeder extends Seeder
{

    public function run()
    {

        if (App::environment() !== 'production') {
            DB::disableQueryLog();

            $this->command->info('Transfers table deleted...');
            DB::table('transfers')->delete();

            $this->command->info('Transfers seed starting...');
            for ($i=0; $i<100000000; $i++) {
                $ip      = "".mt_rand(0, 255).".".mt_rand(0, 255).".".mt_rand(0, 255).".".mt_rand(0, 255);
                $address = md5(rand(0, 1000));
                $amount  = rand(0, 1200);
                $diffTime = rand(0, 10800);
                $date = new \DateTime();
                $date = $date->modify('-'.$diffTime.' minutes');

                Transfer::insert(['ip' => $ip,
                    'address' => $address,
                    'amount'  => $amount,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
            $this->command->info('Transfers seed completed...');
        }
    }
}
