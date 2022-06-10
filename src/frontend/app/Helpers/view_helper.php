<?php

use Config\Services;
use ScssPhp\ScssPhp\Compiler;
use Tholu\Packer\Packer;

function set_view_files($type = '', $name = '')
{
    $ci   = new Config\Services;
    $resp = $ci->response()->view_files;

    $resp[$type][$name]         = 1;
    $ci->response()->view_files = $resp;
}

function get_view_files()
{
    $ci   = new Config\Services;
    $resp = $ci->response()->view_files;
    return $resp;
}

function view_block($name = '', $data = [])
{
    set_view_files('blocks', $name);
    return view('blocks/' . $name . '/' . $name, ['z' => $data]);
}

function view_page($name = '', $data = [])
{
    set_view_files('pages', $name);
    return view('pages/' . $name . '/' . $name, ['z' => $data]);
}

function view_popup($name = '', $data = [])
{
    $file_js  = file_get_contents(APPPATH . '/Views/popups/popup/js/popup.js');
    $file_js .= file_get_contents(APPPATH . '/Views/popups/' . $name . '/js/' . $name . '.js');

    $name_id  = 'popup-' . generateHash(8);
    $content  = '<div data-id="' . $name_id . '" class="popup__wrap"><div data-id="' . $name_id . '" class="popup__bg"></div><div class="popup popup' . ucfirst($name) . '__contentWrap"><div data-id="' . $name_id . '" class="popup__close popup' . ucfirst($name) . '__close"></div><div class="popup__blockWrap ' . $name . '__blockWrap">';
    $content .= view('popups/' . $name . '/' . $name, ['z' => $data]);
    $content .= '</div></div>';
    $content .= '<script type="text/javascript">' . $file_js . '</script>';
    $content .= '</div>';
    return base64_encode(compress_html($content));
}

function view_main($name = 'index', $data = [])
{
    $data['_bundles'] = [
        'js' => $data['content'],
    ];

    $return = view($name, $data, ['saveData' => true]);

    $cache      = Services::cache();
    $javascript = get_javascript_data();
    //$scss       = get_styles_data();
    $cache->save('view.bundle.js.' . md5($data['content']), $javascript, 120);
    //$cache->save('view.bundle.css.' . md5($data['content']), $scss, 120);

    /*if ($name === 'pjax')
    {
        //$data['pjax_javascript'] = $javascript;
        $return = view($name, $data, ['saveData' => true]);
        return base64_encode(compress_html($return));
    }*/
    return $return;
}

function get_javascript_data()
{
    $view_files = get_view_files();

    $files = [];
    foreach ($view_files['blocks'] as $name => $k)
    {
        $file = APPPATH . '/Views/blocks/' . $name . '/js/' . $name . '.js';
        if (file_exists($file))
        {
            $files[$file] = file_get_contents($file);
        }
    }
    foreach ($view_files['pages'] as $name => $k)
    {
        $file = APPPATH . '/Views/pages/' . $name . '/js/' . $name . '.js';
        if (file_exists($file))
        {
            $files[$file] = file_get_contents($file);
        }
    }

    $file = '';
    foreach ($files as $row)
    {
        if (empty($row))
        {
            continue;
        }

        $file .= $row;
    }
    $packer    = new Packer($file, 'Normal', true, false, true);
    $packed_js = $packer->pack();
    return $packed_js;
}
function get_styles_data()
{
    $view_files = get_view_files();
    $scss       = new Compiler();

    $files           = [];
    $files['global'] = file_get_contents('../app/Views/modules/globalData/global.scss');
    foreach ($view_files['blocks'] as $name => $k)
    {
        $file = APPPATH . '/Views/blocks/' . $name . '/css/' . $name;
        if (file_exists($file . '.scss'))
        {
            $files[$file]  = file_get_contents($file . '.scss');
            $files[$file] .= file_get_contents($file . '_mobile.scss');
        }
    }
    foreach ($view_files['pages'] as $name => $k)
    {
        $file = APPPATH . '/app/Views/pages/' . $name . '/css/' . $name;
        if (file_exists($file . '.scss'))
        {
            $files[$file]  = file_get_contents($file . '.scss');
            $files[$file] .= file_get_contents($file . '_mobile.scss');
        }
    }

    $file = '';
    foreach ($files as $row)
    {
        if (empty($row))
        {
            continue;
        }

        $file .= $row;
    }
    $file = preg_replace('/@import ".*";/', '', $file);
    $resp = $scss->compile($file);
    return $resp;
}

function compress_html($data = '')
{
    ini_set('pcre.recursion_limit', '16777');
    $buffer     = $data;
    $new_buffer = $buffer;
    $search     = [
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s',
    ];
    $replace    = [
        '>',
        '<',
        '\\1',
    ];
    $new_buffer = preg_replace($search, $replace, $new_buffer);
    $new_buffer = preg_replace('#<!--(.*)-->#Us', '', $new_buffer);
    $new_buffer = str_replace(['> <', '>  <', '>   <', '>    <'], ['><', '><', '><', '><'], $new_buffer);
    if ($new_buffer === null)
    {
        $new_buffer = $buffer;
    }
    return $new_buffer;
}

function renderBlog($array = [])
{
    $html = '';
    foreach ($array as $qq => $row)
    {
        if (is_string($row))
        {
            $html .= $row;
        }
        if (is_object($row))
        {
            // Если тэг незакрывающий
            if (empty($row->children))
            {
                $html .= '<' . $row->tag;
                if (! empty($row->attrs))
                {
                    foreach ($row->attrs as $key_attr => $attr)
                    {
                        $html .= ' ' . $key_attr . '="' . $attr . '"';
                    }
                }
                $html .= ' />';
            }
            // Если тэг закрывающий
            else
            {
                $html .= '<' . $row->tag;

                if ($row->tag === 'h2' && ! empty($row->attrs->id))
                {
                    $row->attrs->id = 'h2-' . md5($qq);
                }
                if ($row->tag === 'h3' && ! empty($row->attrs->id))
                {
                    $row->attrs->id = 'h3-' . md5($qq);
                }

                if ($row->tag === 'a' && ! empty($row->attrs->href))
                {
                    if (! preg_match('#reestrgov\.ru#Us', $row->attrs->href) && substr($row->attrs->href, 0, 1) !== '/')
                    {
                        $row->attrs->rel = 'nofollow';
                    }
                }

                if (! empty($row->attrs))
                {
                    foreach ($row->attrs as $key_attr => $attr)
                    {
                        $html .= ' ' . $key_attr . '="' . $attr . '"';
                    }
                }
                $html .= '>';

                $html .= renderBlog($row->children);

                $html .= '</' . $row->tag . '>';
            }
        }
    }

    return $html;
}

function renderDescrBlog($json_string = '', $length = 1000)
{
    $data = renderBlog(json_decode($json_string));
    preg_match_all('#<p.*>(.*)<\/p>#Usi', $data, $p);

    $text = '';
    foreach ($p[1] as $row)
    {
        $text .= strip_tags($row) . ' ';
    }
    $text = trim($text);

    if (mb_strlen($text) > $length)
    {
        $text = mb_substr($text, 0, $length) . '...';
    }

    return $text;
}

function renderH2Blog($json_string = '', $length = 1000)
{
    $data = renderBlog(json_decode($json_string));
    preg_match_all('#<h2 id="(.*)".*>(.*)<\/h2>#Usi', $data, $content);

    if (empty($content[1]))
    {
        return [];
    }
    $return = [];
    foreach ($content[1] as $k => $row)
    {
        $return[$k]['id']    = $row;
        $return[$k]['title'] = $content[2][$k];
    }

    return $return;
}


function renderH2Menu($html = '') {
    preg_match_all('#<h2.*>(.*)<\/h2>#Usi', $html, $data);;
    return $data[1];
}
