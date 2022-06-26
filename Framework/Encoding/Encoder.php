<?php declare(strict_types=1);

namespace Automation\Framework\Encoding;

use Automation\Framework\Application;

class Encoder
{
    public const SUPPORTED_TYPES = ['base64', 'url', 'html'];

    private array $formats = [
        'html' => '&#x%s;',
        'url' => '%%%s'
    ];

    public function __construct(
        private Application $app
    ) {
        
    }

    public function encode(string $string, string $as): string
    {
        if (!in_array($as, static::SUPPORTED_TYPES)):
            throw new Exception(sprintf('"%s" is not supported.', $as));
        endif;

        if ('base64' === $as) {
            return base64_encode($string);
        }

        return implode(
            array_map(
                function (string $item) use ($as): string {
                    return sprintf($this->formats[$as], $item);
                }, str_split(bin2hex($string), 2)
            )
        );

        throw new Exception('Something went wrong with the encoder!');
    }

    public function decode(string $string, string $as): string
    {
        if (!in_array($as, static::SUPPORTED_TYPES)):
            throw new Exception(sprintf('"%s" is not supported.', $as));
        endif;

        if ('base64' === $as) {
            $result = base64_decode($string);
        }
        if ('url' === $as) {
            $result = urldecode($string);
        }
        if ('html' === $as) {
            $result = html_entity_decode($string);
        }

        return $result;
    }

    /**
     * Detect the encoding type of a string.
     * 
     * @param  string  $string
     * @return string
     */
    public function detect(string $string): string|false
    {
        $patterns = [
            'base64' => '/^(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=?)?$/',
            'html'    => '/\&\#x[a-z0-9]{2}\;/',
            'url'   => '/\%[a-z0-9]{2}/'
        ];

        foreach ($patterns as $key => $pattern) {
            if (preg_match($pattern, $string)) {
                return $key;
            }
        }

        return false;
    }

    public function supportedTypes(): array
    {
        return static::SUPPORTED_TYPES;
    }
}
