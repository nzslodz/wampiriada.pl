<?php

if (! function_exists('elixir_dist')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string  $file
     * @param  string  $buildDirectory
     * @param  string  $productionDirectory
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    function elixir_dist($file, $buildDirectory = 'build', $productionDirectory = 'dist')
    {
        if(App::environment('production')) {
            return elixir($productionDirectory . '/' . $file, $buildDirectory);
        }

        return elixir($file, $buildDirectory);
    }
}

?>
