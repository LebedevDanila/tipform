<?php namespace App\Libraries\Notify\SmsLibraries;

use \App\Libraries\Utils\Curl;

class SmsCenter{

    const SMSC_POST     = 0;
    const SMSC_HTTPS    = 1;
    const SMSC_CHARSET  = 'utf-8';
    const SMSC_DEBUG    = 0;
    const SMTP_FROM     = 'api@smsc.ru';

    public function send($data = [])
    {
        $resp = $this->send_sms($data['phone'], $data['text'], 0, 0, 0, 0,'ReestrGov');

        if(empty($resp[1]))
        {
            return false;
        }
        if($resp[1] == -6)
        {
            $resp = $this->send_sms($data['phone'], $data['text'], 0, 0, 0, 0,'Kibers');
        }
        if($resp[1] == -6)
        {
            $resp = $this->send_sms($data['phone'], $data['text'], 0, 0, 0, 0,'SMSC.RU');
        }
        if($resp[1] == -6)
        {
            $resp = $this->send_sms($data['phone'], $data['text'], 0, 0, 0, 0,'Perezvoni');
        }

        if(empty($resp[1]))
        {
            return false;
        }

        $return  = [
            'id'     => $resp[0],
            'status' => (int)$resp[1],
            'cost'   => (empty($resp[2])?NULL:(double)$resp[2])
        ];
        return $return;
    }

    public function send_sms($phones, $message, $translit = 0, $time = 0, $id = 0, $format = 0, $sender = false, $query = '', $files = [])
    {
        static $formats = [
            'flash=1',
            'push=1',
            'hlr=1',
            'bin=1',
            'bin=2',
            'ping=1',
            'mms=1',
            'mail=1',
            'call=1',
        ];

        $m = $this->_smsc_send_cmd('send', 'cost=3&phones=' . urlencode($phones) . '&mes=' . urlencode($message) .
                                         "&translit=$translit&id=$id" . ($format > 0 ? '&' . $formats[$format] : '') .
                                         ($sender === false ? '' : '&sender=' . urlencode($sender)) .
                                         ($time ? '&time=' . urlencode($time) : '') . ($query ? "&$query" : ''), $files);

        if (self::SMSC_DEBUG)
        {
            if ($m[1] > 0)
            {
                echo "Сообщение отправлено успешно. ID: $m[0], всего SMS: $m[1], стоимость: $m[2], баланс: $m[3].\n";
            }
            else
            {
                echo 'Ошибка №', -$m[1], $m[0] ? ', ID: ' . $m[0] : '', "\n";
            }
        }

        return $m;
    }

    public function get_sms_cost($phones, $message, $translit = 0, $format = 0, $sender = false, $query = '')
    {
        static $formats = [
            'flash=1',
            'push=1',
            'hlr=1',
            'bin=1',
            'bin=2',
            'ping=1',
            'mms=1',
            'mail=1',
            'call=1',
        ];

        $m = $this->_smsc_send_cmd('send', 'cost=1&phones=' . urlencode($phones) . '&mes=' . urlencode($message) .
                                         ($sender === false ? '' : '&sender=' . urlencode($sender)) .
                                         "&translit=$translit" . ($format > 0 ? '&' . $formats[$format] : '') . ($query ? "&$query" : ''));

        if (self::SMSC_DEBUG)
        {
            if ($m[1] > 0)
            {
                return $m[0];
            }
            else
            {
                return 0;
            }
        }

        return $m;
    }

    public function get_status($id, $phone, $all = 0)
    {
        $m = $this->_smsc_send_cmd('status', 'phone=' . urlencode($phone) . '&id=' . urlencode($id) . '&all=' . (int)$all);

        // (status, time, err, ...) или (0, -error)

        if (! strpos($id, ','))
        {
            if (self::SMSC_DEBUG)
            {
                if ($m[1] !== '' && $m[1] >= 0)
                {
                    echo "Статус SMS = $m[0]", $m[1] ? ', время изменения статуса - ' . date('d.m.Y H:i:s', $m[1]) : '', "\n";
                }
                else
                {
                    echo 'Ошибка №', -$m[1], "\n";
                }
            }

            if ($all && count($m) > 9 && (! isset($m[$idx = $all === 1 ? 14 : 17]) || $m[$idx] !== 'HLR'))
            {
                // ',' в сообщении
                $m = explode(',', implode(',', $m), $all === 1 ? 9 : 12);
            }
        }
        else
        {
            if (count($m) === 1 && strpos($m[0], '-') === 2)
            {
                return explode(',', $m[0]);
            }

            foreach ($m as $k => $v)
            {
                $m[$k] = explode(',', $v);
            }
        }

        return $m;
    }

    public function get_balance()
    {
        $m = $this->_smsc_send_cmd('balance'); // (balance) или (0, -error)

        if (self::SMSC_DEBUG)
        {
            if (! isset($m[1]))
            {
                echo 'Сумма на счете: ', $m[0], "\n";
            }
            else
            {
                echo 'Ошибка №', -$m[1], "\n";
            }
        }

        return isset($m[1]) ? false : $m[0];
    }

    public function _smsc_send_cmd($cmd, $arg = '', $files = [])
    {
        $url = (self::SMSC_HTTPS ? 'https' : 'http') . "://www.smsc.ru/sys/$cmd.php?login=" . urlencode(env('services.smsc.login')) . '&psw=' . urlencode(env('services.smsc.password')) . '&fmt=1&charset=' . self::SMSC_CHARSET . '&' . $arg;
        $i   = 0;
        do
        {
            if ($i)
            {
                sleep(2 + $i);

                if ($i === 2)
                {
                    $url = str_replace('://smsc.ua/', '://www3.smsc.ru/', $url);
                }
            }
            $ret = (new Curl([
                                 CURLOPT_CONNECTTIMEOUT => 10,
                                 CURLOPT_TIMEOUT        => 60,
                             ]))->send($url);
        }
        while ($ret === '' && ++$i < 4);
        if ($ret === '')
        {
            if (self::SMSC_DEBUG)
            {
                echo "Ошибка чтения адреса: $url\n";
            }

            $ret = ','; // фиктивный ответ
        }
        $delim = ',';
        if ($cmd === 'status')
        {
            parse_str($arg);

            if (strpos($id, ','))
            {
                $delim = "\n";
            }
        }
        return explode($delim, $ret);
    }
}
