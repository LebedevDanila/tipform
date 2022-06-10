
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,width=device-width,height=device-height,target-densitydpi=device-dpi,user-scalable=no">
    <title><?=$subject?></title>
    <style type="text/css">
        * {
            -webkit-text-size-adjust: none;
        }

        .ExternalClass * {
            line-height: 100%;
        }
        td {
            mso-line-height-rule: exactly;
        }
        body {
            margin: 0 !important;
            font-family: 'Noto Sans', Verdana, Calibri, Trebuchet, Arial, sans serif !important;
            font-weight: normal;
            font-style: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .greyLink a:link {
            color: #949595;
        }

        .applefix a {
            color: inherit;
            text-decoration: none;
        }
        .content_wrap{
            display: block !important;
            max-width: 660px !important;
            margin: 0 auto !important;
            clear: both !important;
            margin: 0;
            padding: 0;
        }
        .content{
            padding: 15px;
            max-width: 660px;
            margin: 0 auto;
            display: block;
        }
        .header__btn{
            display: inline-block;
            color: #fff !important;
            background: #3b4a61;
            margin-bottom: 0;
            font-size: 12px;
            font-weight: 400;
            text-align: center;
            border-radius: 4px;
            padding: 4px;
            text-decoration: none !important;
        }
        
        .content_footerItem{
            display:inline-block;
            margin:0;
            width:100%;
            max-width:290px;
            vertical-align:top;
        }
        .footer__text{
            text-align: center;
            padding: 0 10px !important;
            font-size: 12px;
            line-height: 18px;
            color: #676767;
        }
        .title{
            line-height: 1.3;
            margin-bottom: 20px;
            color: #000;
            font-weight: 500;
            font-size: 21px;
            margin-top: 10px;
        }
        .a{
            color:#00274b !important;
            text-decoration:underline !important;
        }
        
        .text{
            margin-bottom: 10px;
            font-weight: normal;
            font-size: 14px;
            line-height: 1.6;
            color: #000 !important;
        }
        
        @media only screen and (max-width: 414px) {
            body {
                width: 100%;
                min-width: 100%;
                position: relative;
                top: 0;
                left: 0;
                right: 0;
                margin: 0;
                padding: 0;
            }

            .marginFix {
                position: relative;
                top: 0;
                left: 0;
                right: 0;
            }
        }
    </style>
</head>

<body style="padding:0; margin:0; background:#f2f2f2;">
    <!--
    <div style="display:none; display:none !important; color:#fff; font-size:1pt;">
        Текст для робота
    </div>
    -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: #00274b" class="marginFix">
        <tr>
            <td></td>
            <td class="content_wrap">
                <div class="content">
                    <table>
                        <tr>
                            <td><a style="font-weight: 600;font-size: 18px;line-height: 20px;color: #fff;text-decoration: none" href="<?=enc('app.baseURL')?>/">Reestrgov.ru</a></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    
    <table style="margin-top: 30px">
        <tr>
            <td></td>
            <td class="content_wrap" bgcolor="#FFFFFF">
                <div class="content">
                    <table>
                        <tr>
                            <td>
                                <?php echo view('emails/blocks/'.$block); ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    <table>
        <tr>
            <td></td>
            <td class="content_wrap">
                <div class="content">
                    <div class="footer__text">Вы получили это письмо, так как подтвердили добавление вашего адреса электронной почты ({{to_email}}) в список адресатов нашей рассылки, зарегистрировались на Reestrgov.ru, либо согласились получать новостные обновления, когда запрашивали цены на Reestrgov.ru</div>
                    <table style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td align="center">
                                <p style="margin-bottom: 10px;font-weight: normal;font-size: 12px;line-height: 1.6;">
                                    <a style="color: #00274b;" href="<?=enc('app.baseURL')?>/dogovor-oferta">Пользовательское соглашение</a> |
                                    <a style="color: #00274b;" href="<?=enc('app.baseURL')?>/politica-conf">Политика конфиденциальности</a> |
                                    <a style="color: #00274b;" href="<?=enc('app.baseURL')?>/unsubscribe?code={{id_}}">
                                        <unsubscribe>Отписаться</unsubscribe>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td>
            </td>
        </tr>
    </table>
</body>
</html>