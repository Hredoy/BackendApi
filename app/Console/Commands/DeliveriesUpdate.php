<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Deliveries;

class DeliveriesUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DeliveriesUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replicate Delivered Rows In Deliveries Table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $delivered = Order::where(["is_active_status" => 1, "status" => 3, "schedule_Update" => 0])->get();

        foreach ($delivered as $d) {
            $order = Order::where('id', $d->id)->first();
            $order->schedule_Update = 1;
            $order->save();
            Deliveries::create([
                "stkId" => $d->stkId,
                "name" => $d->name,
                "address" => $d->address,
                "phone" => $d->phone,
                "product_id" => $d->product_id,
                "user_id" => $d->user_id,
                "price" => $d->price,
                "qty" => $d->qty
            ]);
        }

        return Command::SUCCESS;
    }
}
