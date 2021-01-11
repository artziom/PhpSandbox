<?php


class XhprofExample implements SandboxExample
{

    public function run()
    {
        // https://github.com/longxinH/xhprof/blob/master/examples/sample.php
        xhprof_enable();

        /**
         * @param int $i
         * @return array
         */
        function takesAnInt(int $i): array
        {
            return [$i, "hello"];
        }

        $data = [1, "test2"];
        $a = takesAnInt($data[0]);

        var_dump($a);

        $condition = rand(0, 5);
        if ($condition) {
            var_dump($condition);
        }

        $data = xhprof_disable();
        var_dump($data);
    }
}