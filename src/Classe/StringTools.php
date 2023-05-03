<?php

namespace App\Classe;

class StringTools
{
    public static function generateUniqueFileName($category)
    {
        $fileName = $category . '-' . uniqid() . '.png';
        return $fileName;
    }
}