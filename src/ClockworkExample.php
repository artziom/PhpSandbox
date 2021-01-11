<?php


class ClockworkExample implements SandboxExample
{
    public function __construct()
    {
        clock()->event("Run Clockwork example")->color("green")->begin();
    }

    public function run()
    {
        clock("This is a test");
        clock()->info("This is a test");
        clock()->warning("Hmmm.", [0,1,2,3]);
        clock()->info("Api request, took too long!", [ 'performance' => true ]);

        $this->useUserData();
    }

    private function useUserData(){
        clock()->event("Run Clockwork userData example")->color("red")->begin();
        $cart = clock()->userData('cart')
            ->title('Cart');

        $cart->counters([
            'Products' => 3,
            'Value' => '949.80€'
        ]);

        $cart->table('Products', [
            [ 'Product' => 'iPad Pro 10.5" 256G Silver', 'Price' => '849 €' ],
            [ 'Product' => 'Smart Cover iPad Pro 10.5 White', 'Price' => '61.90 €' ],
            [ 'Product' => 'Apple Lightning to USB 3 Camera Adapter', 'Price' => '38.90 €' ]
        ]);
        clock()->event("Run Clockwork userData example")->end();
    }

    public function __destruct()
    {
        clock()->event("Run Clockwork example")->end();
    }
}