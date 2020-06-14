<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input):string
    {
        $input = preg_replace("/[^0-9a-zA-Z\:_|+-]/","",$input);
        $input = preg_replace("/['-|+]+/","-",$input);

        return $input;
//        $newinput=explode("-",$input);
//        ;
//        $input=implode($newinput);
//        $newinput = strtolower($newinput);
//        return $newinput;
    }

}
