<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input):string
    {
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $output=str_replace(" ","-",$input);
        return $output;
    }

}
