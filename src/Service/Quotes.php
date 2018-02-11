<?php

namespace App\Service;


use Psr\Log\LoggerInterface;

class Quotes
{
    protected $quotes = [
        'Есть преступления хуже, чем сжигать книги. Например — не читать их.',
        '«Нет, — быстро сказал он. — Только не это. Остаться друзьями? Развести огородик на остывшей лаве угасших чувств? Нет, это не для нас с тобой. Так бывает только после маленьких интрижек, да и то получается довольно фальшиво. Любовь не пятнают дружбой. Конец есть конец.»',
        'А что подумал по этому поводу Кролик, никто так и не узнал, потому что Кролик был очень воспитанный.',
        'Мы не выносим людей с теми же недостатками, что и у нас.',
        'Мне наплевать, что вы обо мне думаете. Я о вас не думаю вообще.'
    ];
    protected $log;

    public function __construct($str, $tokinazer, LoggerInterface $log)
    {
        dump($tokinazer->generateToken()); die;
        $this->log = $log;
    }

    public function getQuotes()
    {
        $q = $this->quotes[array_rand($this->quotes)];
        $this->log->info($q);
        
        return $q;
    }
}