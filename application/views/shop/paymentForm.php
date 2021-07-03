<?php
$m_shop = '12345'; // id мерчанта
$m_orderid = '1'; // номер счета в системе учета мерчанта
$m_amount = number_format(100, 2, '.', ''); // сумма счета с двумя знаками после точки
$m_curr = 'RUB'; // валюта счета
$m_desc = base64_encode('Test'); // описание счета, закодированное с помощью
алгоритма base64
$m_key = 'Ваш секретный ключ';
// Формируем массив для генерации подписи
$arHash = array(
$m_shop,
$m_orderid,
$m_amount,
$m_curr,
$m_desc
);
/*
// Формируем массив дополнительных параметров
$arParams = array(
'success_url' => 'http://google.com/new_success_url',
'fail_url' => 'http://google.com/new_fail_url',
'status_url' => 'http://google.com/new_status_url',
// Формируем массив дополнительных полей
'reference' => array(
'var1' => '1',
'var2' => '2',
'var3' => '3',
'var4' => '4',
'var5' => '5',
),
//'submerchant' => 'mail.com',
);
// Формируем ключ для шифрования
$key = md5('Ключ для шифрования дополнительных параметров'.$m_orderid);
// Шифруем дополнительные параметры
$m_params = urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
$key, json_encode($arParams), MCRYPT_MODE_ECB)));
// Шифруем дополнительные параметры с помощью AES-256-CBC (для >= PHP 7)
// $m_params = @urlencode(base64_encode(openssl_encrypt(json_encode($arParams),
'AES-256-CBC', $key, OPENSSL_RAW_DATA)));
// Добавляем параметры в массив для формирования подписи
$arHash[] = $m_params;
*/
// Добавляем в массив для формирования подписи секретный ключ
$arHash[] = $m_key;
// Формируем подпись
$sign = strtoupper(hash('sha256', implode(':', $arHash)));
?>
<form method="post" action="https://payeer.com/merchant/">
<input type="hidden" name="m_shop" value="<?=$m_shop?>">
<input type="hidden" name="m_orderid" value="<?=$m_orderid?>">
<input type="hidden" name="m_amount" value="<?=$m_amount?>">
<input type="hidden" name="m_curr" value="<?=$m_curr?>">
<input type="hidden" name="m_desc" value="<?=$m_desc?>">
<input type="hidden" name="m_sign" value="<?=$sign?>">
<?php /*
<input type="hidden" name="form[ps]" value="2609">
<input type="hidden" name="form[curr[2609]]" value="USD">
*/ ?>
<?php /*
<input type="hidden" name="m_params" value="<?=$m_params?>">
*/ ?>
<?php /*
<input type="hidden" name="m_cipher_method" value="AES-256-CBC">
*/ ?>
<input type="submit" name="m_process" value="send" />
</form>
