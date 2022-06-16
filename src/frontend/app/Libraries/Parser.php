<?php
namespace App\Libraries;

use App\Libraries\Utils\Curl;
use PHPHtmlParser\Dom;

class Parser
{
    private $errors = [
        1 => 'Пустой url.',
        2 => 'Не валидный url.',
        3 => 'Ошибка парсинга.',
    ];
    private $news_count = 15;

    public function run($url = '')
    {
        /* Проверка url */
        if ($url === '') {
            return $this->error(1);
        }
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return $this->error(2);
        }

        /* Получение новостей */
        try {
            $html = (new Curl())->send($url);
        } catch (\Exception $e) {
            return $this->error(3);
        }

        $dom = (new Dom)->loadStr($html);

        $links = $dom->find('.js-news-feed-list a');
        $news  = [];
        foreach ($links as $key => $link) {
            if ($key === $this->news_count) {
                break;
            }

            $title = $link->find('.news-feed__item__title');
            $news[] = [
                'href'  => $link->getAttribute('href'),
                'title' => $title,
            ];
        }

        echo json_encode($news);
        die();
        die();
    }

    public function error($code)
    {
        $resp = [
            'status' => false,
            'error'  => [
                'code'    => $code,
                'message' => $this->errors[$code] ?? null,
            ],
        ];

        return $resp;
    }

    public function response($data)
    {
        $resp = [
            'status'   => true,
            'response' => [
                'data' => $data,
            ],
        ];

        return $resp;
    }

}
