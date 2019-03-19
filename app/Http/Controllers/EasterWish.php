<?php

namespace App\Http\Controllers;

class EasterWish extends EasterWishes{
     public static function init(){

          return new self;

     }

     public function wishes(Wish $wish){

          return Easter::now() ?:

     }

     private function IsEasterHoliday($year == '2018'){

          Carbon::macro('isHoliday', function ($date) {
               return in_array($date->format('Y-m-d'), [holidays]); 
           });
           
           Carbon::parse('some-date')->isHoliday();

          return Carbon::parse('some-date')->isHoliday() == ''

     }
}