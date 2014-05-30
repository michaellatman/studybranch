<?php
use Symfony\Component\Finder\Finder;
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('tests')
    ->in('app')
;

return new sami\Sami($iterator, array(
    'title'                => 'Symfony2 API',
    'build_dir'            => __DIR__.'/public/docs',
    'cache_dir'            => __DIR__.'/cache',
    'default_opened_level' => 2
));