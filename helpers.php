<?php
if (!function_exists('dd')) {
    /**
     * Just a debug function
     */
    function dd()
    {
        $args = func_get_args();
        if (1 === count($args)) {
            var_dump($args[0]);
        } else {
            var_dump($args);
        }
        die;
    }
}