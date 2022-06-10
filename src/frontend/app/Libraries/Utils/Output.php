<?php

namespace App\Libraries\Utils;

class Output
{
    public $errors = [
        10  => 'Произошла внутренняя ошибка сервера',
        11  => 'Один из необходимых параметров был не передан или неверен.',
        12  => 'Ошибка выполнения кода',
        13  => 'Ответ пуст',
        14  => 'Произошла ошибка записи',
        27  => 'Дубликация записей',
        222 => 'Введите все данные',
        225 => 'Не валидная ссылка',
        333 => 'К сожалению сейчас все аккаунты заняты, попробуйте попытку позже',
        380 => 'Такого аккаунта не существует. Возможно он был удален или введен с ошибкой',
        390 => 'Невалидный логин аккаунта',
        400 => 'плохой, неверный запрос',
        401 => 'Ошибка авторизации аккаунта',
        403 => 'Ошибка авторизации',
        404 => 'Нету данных по профилю',
        419 => 'ошибка проверки CSRF',
        500 => 'Время ожиданяи истекло',
        777 => 'Данный профиль уже загружается, попробуйте попытку позже',
    ];

    public function error($error_id = 1)
    {
        $resp = [
            'status' => false,
            'error'  => [
                'code'    => $error_id,
                'message' => (empty($this->errors[$error_id]) ? null : $this->errors[$error_id]),
            ],
        ];

        return $this->out($resp);
    }

    public function responseError($error_id = 1)
    {
        $resp = [
            'status' => false,
            'error'  => [
                'code'    => $error_id,
                'message' => (empty($this->errors[$error_id]) ? null : $this->errors[$error_id]),
            ],
        ];

        return $this->out($resp, true);
    }

    public function response($data = [])
    {
        $time = microtime(true);
        $resp = [
            'status'   => true,
            'response' => [
                'data'      => $data,
                'microtime' => $time,
            ],
        ];

        return $this->out($resp);
    }

    public function responseSuccess($data = [])
    {
        $time = microtime(true);
        $resp = [
            'status'   => true,
            'response' => [
                'data'      => $data,
                'microtime' => $time,
            ],
        ];

        return $this->out($resp, true);
    }

    public function collection($data = [])
    {
        return $this->out($data);
    }

    public function out($resp = [], $is_json = false)
    {
        $resp = json_encode($resp);
        if ( ! $is_json) {
            $resp = json_decode($resp);
        }

        return $resp;
    }

}
