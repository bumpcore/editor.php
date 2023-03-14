<?php

namespace BumpCore\EditorPhp;

use DOMDocument;

class Purifier
{
    /**
     * Strips unwanted tags from given string.
     *
     * @param string $string
     * @param array<string> $allowedTags
     *
     * @return string
     */
    public static function stripTags(string $string, array $allowedTags = []): string
    {
        return strip_tags($string, $allowedTags);
    }

    /**
     * Strips unwanted attributes from given tag and string.
     *
     * @param string $string
     * @param string $tag
     * @param array<string> $allowedAttributes
     *
     * @return string
     */
    public static function stripAttributes(string $string, string $tag, array $allowedAttributes = []): string
    {
        $domDocument = new DOMDocument();
        libxml_use_internal_errors(true);
        // We're using template tags only for wrapping. In normal case It would be `p`.
        $domDocument->loadHTML(implode('', ['<template>', $string, '</template>']), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        /**
         * @var \DOMElement $node
         */
        foreach ($domDocument->getElementsByTagName($tag) as $node)
        {
            /**
             * @var \DOMAttr $attribute
             */
            foreach ($node->attributes as $attribute)
            {
                if (!in_array($attribute->name, $allowedAttributes))
                {
                    $node->removeAttribute($attribute->name);
                }
            }
        }

        // DomDocument little bit old, isn't it?
        return str_replace(
            ['<template>', '</template>'],
            '',
            mb_convert_encoding($domDocument->saveHTML($domDocument->documentElement), 'ISO-8859-1', 'UTF-8')
        );
    }
}
