<?php

function unicode_convert($str){
    if(!$str) return false;
    // Convert to lowercase
    $slug = mb_strtolower($str, 'UTF-8');
    
    // Transliterate characters with accents to ASCII equivalents
    $slug = transliterator_transliterate('Any-Latin; Latin-ASCII', $slug);

    // Replace any non-alphanumeric characters with a hyphen
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);

    // Trim hyphens from the beginning and end
    $slug = trim($slug, '-');

    return $slug;
}
?>