<?php

use Illuminate\Support\Arr;

if (!function_exists('transliterate')) {
    /**
     * Заменяет русские буквы, на буквы английского алфавита
     * @param string $text
     * @return string
     */
    function transliterate(string $text = ''): string
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];

        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya'
        ];

        return str_replace($cyr, $lat, $text);
    }
}

if (!function_exists('admin_path')) {
    /**
     * Возвращает URL на админку
     * @return string
     */
    function admin_path(): string
    {
        return route('platform.main');
    }
}

if (!function_exists('cache_key')) {
    /**
     * Формирует ключ для сохранения данных в кеше
     * @param string $prefixAction
     * @param array $parameters
     * @return string
     */
    function cache_key(string $prefixAction, array $parameters = []): string
    {
        return md5(serialize("{$prefixAction}:" . Arr::query($parameters)));
    }
}
