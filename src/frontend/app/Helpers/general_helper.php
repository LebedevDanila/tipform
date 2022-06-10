<?php

function loc_redirect($path = '')
{
    $this->response->setStatusCode(301);
    $this->response->setHeader('Location', $path);
    return;
}
function generateHash($count = 50, $separator = '-')
{
    $k = sha1(microtime());
    for ($i = 0; $i < 40; $i++)
    {
        $f[] = substr($k, $i, $i + 1);
    }
    shuffle($f);
    $t = '';
    foreach ($f as $k => $row)
    {
        if ($k < 11)
        {
            $t .= $row . $separator;
        }
    }
    $result = substr($t, 0, $count);
    if (substr($result, -1) === $separator)
    {
        $result = substr($result, 0, -1) . '7';
    }
    return $result;
}

function getBaseUri() {
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    return $url[0];
}

function microtime_float()
{
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}

function n_format($sum = 0, $cli = 0, $st = ',', $su = ' ')
{
    return number_format($sum, $cli, $st, $su);
}
function x2lon($x = 0)
{
    return $x / (pi() / 180.0) / 6378137.0;
}
function y2lat($y = 0)
{
    return (2 * atan(exp($y / 6378137)) - pi() / 2) / (pi() / 180);
}
/**
 * Скрываем рандомно половину символов в строке звёздочками.
 */
function hiddenNumber($password = '')
{
    //$password = str_replace([':','-','/','\\'], '', $number);
    $password   = substr($password, 0, 23);
    $count      = mb_strlen($password);
    $count_half = floor($count / 2);

    $string = '';
    $array  = [];
    for ($i = 0; $i < $count; $i++)
    {
        $array[] = $i;
    }
    $array      = explode(',', '13,16,1,24,3,4,0,21,22,5,2,31,14,19,9,27,28,7,29,6,25,23,20,12,11,26,17,15,8,18,10,30');
    $array_falf = [];
    foreach ($array as $k => $row)
    {
        if ($k < $count_half)
        {
            $array_falf[] = $row;
        }
    }

    for ($i = 0; $i < $count; $i++)
    {
        $hidden = 0;
        foreach ($array_falf as $row)
        {
            if ((int)$i === (int)$row)
            {
                $hidden = 1;
            }
        }
        $d       = mb_substr($password, $i, 1);
        $string .= ((int)$hidden === 1 && is_numeric($d) ? '*' : $d);
    }

    return $string;
}

function countDaysOwner($date_start = 0)
{
    $time   = time()-$date_start;
    $resp   = fromSeconds($time);
    $return = [
        'days'      => round($time/86400),
        'format'    => $resp
    ];
    return $return;
}

function fromSeconds($seconds)
{
    $seconds = (int)$seconds;
    $dateTime = new DateTime();
    $dateTime->sub(new DateInterval("PT{$seconds}S"));
    $interval = (new DateTime())->diff($dateTime);
    $pieces = explode(' ', $interval->format('%y %m %d %h %i %s'));
    $intervals = ['year', 'month', 'day', 'hour', 'minute', 'second'];
    $result = [];
    foreach ($pieces as $i => $value) {
        $periodName = $intervals[$i];
        $result[$periodName] = $value;
    }
    return $result;
}

function convertTimeSec($secunds = 0)
{
    $hour = floor($secunds/3600);
    $sec = $secunds - ($hour*3600);
    $min = floor($sec/60);
    $sec = $sec - ($min*60);

    return [
        'H' => $hour,
        's' => $min,
        'i' => $sec
    ];
}

function checkEgrnNumber($egrn = '')
{
    if (preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{4,8}:[0-9]{1,}$/', $egrn))
    {
        return true;
    }
    return false;
}

function egrnInLink($egrn = '')
{
    return str_replace(":", '-', $egrn);
}
function linkInEgrn($egrn = '')
{
    return str_replace("-", ':', $egrn);
}

function getLinktranslit($s)
{
    $s = (string) $s;
    $s = strip_tags($s);
    $s = str_replace(["\n", "\r"], ' ', $s);
    $s = preg_replace('/\s+/', ' ', $s);
    $s = trim($s);
    $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
    $s = strtr($s, ['а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => '']);
    $s = preg_replace('/[^0-9a-z-_ ]/i', '', $s);
    $s = str_replace(' ', '-', $s);
    $s = str_replace('----', '-', $s);
    $s = str_replace('---', '-', $s);
    $s = str_replace('--', '-', $s);
    return $s;
}

function convertArrayForKey($array = [], $key = '')
{
    $return = [];
    foreach ($array as $row)
    {
        if (is_array($row))
        {
            $return[$row[$key]] = $row;
        }
        if (is_object($row))
        {
            $return[$row->{$key}] = $row;
        }
    }

    return $return;
}

function sklonenie($n, $ds)
{
    $d  = explode('|', $ds);
    $s1 = $d[0];
    $s2 = $d[1];
    $s3 = $d[2];
    $m  = $n % 10;
    $j  = $n % 100;
    if ($m === 0 || $m >= 5 || ($j >= 10 && $j <= 20))
    {
        return $s3;
    }
    if ($m >= 2 && $m <= 4)
    {
        return  $s2;
    }
    return $s1;
}

function getTypeObject($type = '')
{
    $return = [
        1 => 'земельный участок',
        2 => 'здание',
        3 => 'помещение',
        4 => 'сооружение',
        5 => 'объект незавершенного строительства',
        6 => 'машино-место',
        7 => 'единый недвижимый комплекс',
        8 => 'предприятие как имущественный комплекс',
        9 => 'квартира',
    ];
    if (empty($return[$type]))
    {
        return $type;
    }
    return $return[$type];
}

function getLinkByEgrn($egrn = '')
{
    return '/reestr/' . str_replace(':', '-', $egrn);
}

function switcher_ru($value = '')
{
    $converter = [
        'f' => 'а',
        ',' => 'б',
        'd' => 'в',
        'u' => 'г',
        'l' => 'д',
        't' => 'е',
        '`' => 'ё',
        ';' => 'ж',
        'p' => 'з',
        'b' => 'и',
        'q' => 'й',
        'r' => 'к',
        'k' => 'л',
        'v' => 'м',
        'y' => 'н',
        'j' => 'о',
        'g' => 'п',
        'h' => 'р',
        'c' => 'с',
        'n' => 'т',
        'e' => 'у',
        'a' => 'ф',
        '[' => 'х',
        'w' => 'ц',
        'x' => 'ч',
        'i' => 'ш',
        'o' => 'щ',
        'm' => 'ь',
        's' => 'ы',
        ']' => 'ъ',
        "'" => 'э',
        '.' => 'ю',
        'z' => 'я',
        'F' => 'А',
        '<' => 'Б',
        'D' => 'В',
        'U' => 'Г',
        'L' => 'Д',
        'E' => 'Е',
        '~' => 'Ё',
        ':' => 'Ж',
        'P' => 'З',
        'B' => 'И',
        'Q' => 'Й',
        'R' => 'К',
        'K' => 'Л',
        'V' => 'М',
        'Y' => 'Н',
        'J' => 'О',
        'G' => 'П',
        'H' => 'Р',
        'C' => 'С',
        'N' => 'Т',
        'E' => 'У',
        'A' => 'Ф',
        '{' => 'Х',
        'W' => 'Ц',
        'X' => 'Ч',
        'I' => 'Ш',
        'O' => 'Щ',
        'M' => 'Ь',
        'S' => 'Ы',
        '}' => 'Ъ',
        '"' => 'Э',
        '>' => 'Ю',
        'Z' => 'Я',
        '@' => '"',
        '#' => '№',
        '$' => ';',
        '^' => ':',
        '&' => '?',
        '/' => '.',
        '?' => ',',
    ];

    $value = strtr($value, $converter);
    return $value;
}

if (! function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     *
     * @param  string $str      - строка
     * @param  string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}

/**
 * Функция для view - page - manageList
 */
function ui_reputation($rep = 0)
{
    if ($rep === 0)
    {
        return '';
    }
    if ($rep > 0 && $rep < 25)
    {
        return 'manageList__dataItem_danger';
    }
    if ($rep >= 25 && $rep < 33)
    {
        return 'manageList__dataItem_warning';
    }
    if ($rep >= 33)
    {
        return 'manageList__dataItem_success';
    }
}

/**
 * Функция для view - page - manageListComp
 */
function ui_ratingManageListComp($rep = 0)
{
    $rep = (double)ui_covnertRatingManageListComp($rep);
    if ($rep >= 0 && $rep < 3.9)
    {
        return '';
    }
    if ($rep >= 3.9 && $rep < 6.8)
    {
        return 'manageListComp__tableTdRating_warning';
    }
    if ($rep >= 6.8)
    {
        return 'manageListComp__tableTdRating_success';
    }
}

function ui_ratingManageCompany($rep = 0)
{
    $rep = (double)ui_covnertRatingManageListComp($rep);
    if ($rep >= 0 && $rep < 3.9)
    {
        return 'manageCompany__contactsStatusReput_danger';
    }
    if ($rep >= 3.9 && $rep < 6.8)
    {
        return 'manageCompany__contactsStatusReput_warning';
    }
    if ($rep >= 6.8)
    {
        return 'manageCompany__contactsStatusReput_success';
    }
}
function ui_ratingHouseManageCompany($rep = 0)
{
    $rep = (double)ui_covnertRatingManageListComp($rep);
    if ($rep >= 0 && $rep < 3.9)
    {
        return 'house__ukStatusReput_danger';
    }
    if ($rep >= 3.9 && $rep < 6.8)
    {
        return 'house__ukStatusReput_warning';
    }
    if ($rep >= 6.8)
    {
        return 'house__ukStatusReput_success';
    }
}

function ui_covnertRatingManageListComp($rep = 0)
{
    $rating = $rep * 10 / 100;
    $data   = round($rating, 1);
    if (strlen($data) === 1)
    {
        $data = $data . '.0';
    }
    return $data;
}
function ui_standartOperationMode($text = '')
{
    $text = str_replace("\n", '<br />', $text);
    $text = str_replace(';', '<br />', $text);
    return $text;
}

function ui_registerNameUk($name = '')
{
    //$name = ucfirst(mb_strtolower($name));
    return $name;
}

function getTextMonth($month = 1)
{
    switch($month)
    {
        case 1 :
            return [
                'январь',
                'января',
            ];
            break;
        case 2 :
            return [
                'февраль',
                'февраля',
            ];
            break;
        case 3 :
            return [
                'март',
                'марта',
            ];
            break;
        case 4 :
            return [
                'апрель',
                'апреля',
            ];
            break;
        case 5 :
            return [
                'май',
                'мая',
            ];
            break;
        case 6 :
            return [
                'июнь',
                'июня',
            ];
            break;
        case 7 :
            return [
                'июль',
                'июля',
            ];
            break;
        case 8 :
            return [
                'август',
                'августа',
            ];
            break;
        case 9 :
            return [
                'сентябрь',
                'сентября',
            ];
            break;
        case 10 :
            return [
                'октябрь',
                'октября',
            ];
            break;
        case 11 :
            return [
                'ноябрь',
                'ноября',
            ];
            break;
        case 12 :
            return [
                'декабрь',
                'декабря',
            ];
            break;
    }
}

function getInfoFileManagement($filename = '')
{
    $return = [
        'cdn'      => false,
        'format'   => 'pdf',
        'filename' => $filename,
    ];
    if (empty($filename))
    {
        return $return;
    }
    if ($filename === 'nocdn')
    {
        return $return;
    }
    $return['filename'] = CDN_DOMAIN . $filename;
    $return['cdn']      = true;
    $exp                = explode('.', $filename);
    $exp                = array_reverse($exp);
    $format             = $exp[0];
    if (preg_match('#pdf#Usi', $format))
    {
        $return['format'] = 'pdf';
    }
    if (preg_match('#html#Usi', $format))
    {
        $return['format'] = 'html';
    }
    if (preg_match('#jpg#Usi', $format) || preg_match('#jpeg#Usi', $format))
    {
        $return['format'] = 'jpg';
    }
    if (preg_match('#png#Usi', $format))
    {
        $return['format'] = 'png';
    }
    if (preg_match('#ppt#Usi', $format))
    {
        $return['format'] = 'powerpoint';
    }
    if (preg_match('#txt#Usi', $format))
    {
        $return['format'] = 'txt';
    }
    if (preg_match('#xls#Usi', $format) || preg_match('#xlsx#Usi', $format))
    {
        $return['format'] = 'xls';
    }
    if (preg_match('#doc#Usi', $format) || preg_match('#docx#Usi', $format))
    {
        $return['format'] = 'doc';
    }
    if (preg_match('#zip#Usi', $format))
    {
        $return['format'] = 'zip';
    }

    return $return;
}

function recursiveComment($comments = [], $parent_id = null, $parent = [])
{
    $return = '';
    foreach ($comments as $row)
    {
        if ((int)$row->parent_id === (int)$parent_id)
        {
            $return .= view('blocks/comments/commentsItem', ['comment' => ['data' => $row, 'parent' => $parent]]);
        }
    }

    return $return;
}

function getAvaratIdByUserId($user_id = 0)
{
    for ($i = 15; $i > 0; $i--)
    {
        if ($user_id % $i === 0)
        {
            return $i;
        }
    }
    return 1;
}

function hiddenFIO($name = '')
{
    $explode = explode(' ', $name);
    $name    = '';
    if (! empty($explode[0]))
    {
        $name = mb_substr($explode[0], 0, 1);
        for ($i = 1; $i < mb_strlen($explode[0]); $i++)
        {
            if ($i > 8)
            {
                continue;
            }
            $name .= '*';
        }
    }
    if (! empty($explode[1]))
    {
        $name .= ' *.';
    }
    if (! empty($explode[2]))
    {
        $name .= '*.';
    }
    return $name;
}

function generateHashLink($count = 6)
{
    $arr = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
        'A',
        'B',
        'C',
        'D',
        'E',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        'F',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '0',
    ];
    $url = '';
    for ($i = 0; $i < $count; $i++)
    {
        $random = rand(0, count($arr) - 1);
        $url   .= $arr[$random];
    }
    return $url;
}

function createPassword()
{
    $array_1 = [
        'a',
        'e',
        'o',
        'u',
        'i',
    ];
    $array_2 = [
        'b',
        'c',
        'd',
        'f',
        'g',
        'h',
        'j',
        'k',
        'l',
        'm',
        'n',
        'p',
        'q',
        'r',
        's',
        't',
        'v',
        'w',
        'x',
        'y',
        'z',
    ];

    $text = '';
    for ($i = 0; $i < 6; $i++)
    {
        shuffle($array_1);
        shuffle($array_2);
        if ($i % 2 === 0)
        {
            $text .= $array_2[0];
        }
        else
        {
            $text .= $array_1[0];
        }
    }
    $text .= mt_rand(10, 99);
    return ucfirst($text);
}

function createProxyUrl($url)
{
    $url = base64_encode($url);
    return PROXY_IMAGE_URL . $url;
}


function getTextFormatDate($time)
{
    $year    = date('Y', $time);
    $month   = getTextMonth(date('n', $time))[1];
    $day     = date('j', $time);
    $hours   = date('H', $time);
    $minutes = date('i', $time);
    return $hours . ':' . $minutes . ' ' .$day . ' ' . $month . ' ' . $year;
}

function createShortNumber($number)
{
    $result = 0;
    
    if($number >= 1000000){
        $result = round($number / 1000000, 1, PHP_ROUND_HALF_DOWN) . 'М';
    } else if($number >= 10000) {
        $result = round($number / 1000, 1, PHP_ROUND_HALF_DOWN) . 'К';
    } else {
        $result = $number;
    }
    
    return $result;
}

function getReadtime($text) {
    $average_word = 1500;
    $count_word   = mb_strlen(strip_tags($text));
    $readtime     = ceil($count_word / $average_word);
    return $readtime;
}

function sortArrayByUniqueId($a, $b)
{
    $a = (array) $a;
    $b = (array) $b;
    $num1 = $a['unique_id'];
    $num2 = $b['unique_id'];

    if ($num1 == $num2) {
        return 0;
    }
    return ($num1 < $num2) ? 1 : -1;
}

function url_get_contents($url) {
    if (function_exists('curl_exec')){
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $url_get_contents_data = (curl_exec($conn));
        curl_close($conn);
    }elseif(function_exists('file_get_contents')){
        $url_get_contents_data = file_get_contents($url);
    }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
        $handle = fopen ($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
    }else{
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}