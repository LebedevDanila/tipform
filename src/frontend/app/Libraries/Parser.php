<?php
namespace App\Libraries;

use App\Libraries\Utils\Curl;

class Parser
{
    private $errors = [
        1 => 'Пустой url.',
        2 => 'Не валидный url.',
        3 => 'Ошибка парсинга.',
    ];

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
            $response = (new Curl())->send($url);
        } catch (\Exception $e) {
            return $this->error(3);
        }
        echo $response;
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
