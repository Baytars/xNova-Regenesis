<?php

if ( ! function_exists( "ifsetor" ) ) {
    /**
     * PHP5-заменитель функции из РНР6
     *
     * @param mixed $val значение, присутствие которого следует проверить
     * @param mixed $alt значение, которое следует вернуть, если $val не существует
     * @return mixed
     */
    function ifsetor( &$val, $alt = NULL ) {
        return isset( $val ) ? $val : $alt;
    }
}

/**
 * Получить адрес текущей страницы с указанными параметрами.
 * Если параметры не указаны — берутся те, что есть
 *
 * @param array $params
 * @return string $path
 * @todo нуждается в переработке
 */
function getCurrentPage( array $params = NULL ) {
    $module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    $controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

    if ( !isset( $params ) ) {
        $params = Zend_Controller_Front::getInstance()->getRequest()->getUserParams();
    }
    if( !is_array($params) ) {
        $params = array();
    }

    unset( $params[ "action" ] );
    unset( $params[ "controller" ] );
    unset( $params[ "module" ] );
    $page = '';
    foreach ( $params as $name => $value ) {
        if( is_string($value) || is_int($value) ) {
            $page = '/'.$name.'/'.$value.$page;
        }
    }
    if ( $action != 'index' || ! empty( $page ) ) {
        $page = '/'.$action.$page;
    }
    if ( $controller != 'index' || ! empty( $page ) ) {
        $page = '/'.$controller.$page;
    }
    if ( $module != 'default' ) {
        $page = '/'.$module.$page;
    }
    if ( empty( $page ) ) {
        $page = '/';
    }
    return $page;
}

function populateFormInputs( $form, $fields = NULL ) {
    if ( ! $form instanceof DOMNode) {
        throw new Exception('The $form must be DOMNode but finded "'.get_class( $form ).'".');
    }

    $inputs = $form->getElementsByTagName('input');
    $selects = $form->getElementsByTagName('select');

    $post = array();
    foreach ( $inputs as $input ) {
        $post[ $input->getAttribute( 'name' ) ] = $input->getAttribute( 'value' );
    }

    foreach ( $selects as $select ) {
        $post[ $select->getAttribute( 'name' ) ] = "";
    }

    foreach ( $fields as $key => $value ) {
        $post[ $key ] = $value;
    }

    return $post;
}

function html_escape($text) {
    return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}

function unichr($c, $hex = FALSE) {
    if( $hex ) {
        $c = hexdec($c);
    }
    if ($c <= 0x7F) {
        return chr($c);
    } else if ($c <= 0x7FF) {
        return chr(0xC0 | $c >> 6) . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0xFFFF) {
        return chr(0xE0 | $c >> 12) . chr(0x80 | $c >> 6 & 0x3F)
        . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0x10FFFF) {
        return chr(0xF0 | $c >> 18) . chr(0x80 | $c >> 12 & 0x3F)
        . chr(0x80 | $c >> 6 & 0x3F)
        . chr(0x80 | $c & 0x3F);
    } else {
        return false;
    }
}

/**
* Возвращает DOMDocument, как результат обработки html-кода $html\
*
* @param $html string
* @param $is_do_tidy bool
* @return DOMDocument
*/
function getHTMLDoc($html, $is_do_tidy = TRUE) {
    if ($is_do_tidy) {
        $config = array('output-xhtml'   => TRUE);
        $tidy = new tidy();
        $tidy->parseString($html, $config, 'utf8');
        $tidy->cleanRepair();
        $html = $tidy;
    }

    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = FALSE;
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
    @$doc->loadHTML($html);

    return $doc;
}

function getDomNodeHtml(DOMNode $node) {
    $doc = new DOMDocument('1.0', 'utf-8');

    $doc->appendChild($doc->importNode($node,true));
    return mb_convert_encoding($doc->saveHTML(), "UTF-8", 'HTML-ENTITIES');
}

function html_unescape($text) {
    static $table = array(
        '&#151;'    => '—',
        '&mdash;'   => '—',
        '&#x27;'    => '\'',
        '&#133;'    => '…',
        # TODO дополнить
        #
        # PHP manual, get_html_translation_table
        # Note: Special characters can be encoded in several ways.
        # E.g. " can be encoded as &quot;, &#34; or &#x22.
        # get_html_translation_table() returns only the most common form for them.
    );

    static $table_complete;
    if (empty($table_complete)) {
        $raw = get_html_translation_table(HTML_ENTITIES);
        foreach ($raw as $key => $val) {
            $table[$val] = iconv('ISO-8859-1', 'UTF-8', $key);
        }
        $table_complete = TRUE;
    }

    $text = strtr($text, $table);
    $text = preg_replace('~&#([0-9]+);~e', 'unichr("\\1")', $text);
    $text = preg_replace('~&#x([0-9A-F]+);~e', 'unichr("\\1", TRUE)', $text);

    return $text;
}

function strtoarray($str) {
    $list = array();
    for($i = 0; $i < mb_strlen($str); ++$i) {
        $list[] = mb_substr($str, $i, 1);
    }
    return $list;
}

function trans($str) {
    static $tbl= array(
        'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё' => 'yo', 'ж'=>'g', 'з'=>'z',
        'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
        'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch' ,
        'ш' => 'sh' , 'щ' => 'sch', 'ъ' => '', 'ы'=>'y', 'ь' => '', 'э'=>'e', 'ю' => 'yu', 'я' => 'ya', ' ' => ' ',
    );
    $res = '';
    foreach(strtoarray($str) as $rus) {
        if( isset($tbl[$rus]) ) {
            $res .= $tbl[$rus];
        } else if( isset( $tbl[mb_strtolower($rus)] ) ) {
            $res .= mb_ucfirst($tbl[mb_strtolower($rus)]);
        } else {
            $res .= $rus;
        }
    }
    $res = iconv("utf-8", "ascii//TRANSLIT", $res); // Убираем всякие умляуты
    return $res;
}

// Убирает диакритические знаки, оставляя кириллические символы
function removeDiacritics($text) {
    $text = preg_replace_callback('#[^абвгдеёжзийклмнопрстуфхцчшщъыьэюяії]+#iu', create_function('$matches', 'return iconv("utf-8", "ascii//TRANSLIT", $matches[0]);'), $text);
    return $text;
}

if (!function_exists("mb_ucfirst")) {
    function mb_ucfirst($text) {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
}

if (!function_exists("mb_lcfirst")) {
    function mb_lcfirst($text) {
        return mb_strtolower(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
}

/**
 * Возвращает склонение числа
 *
 * @param integer $number
 * @param array $titles - массив значений. Например, array("гривна", "гривны", "гривен")
 * @return string
 */
function declOfNum( $number, $titles ) {
    $cases = array( 2, 0, 1, 1, 1, 2 );
    return $titles[ ( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[ min( $number % 10, 5 ) ] ];
}

function realFileSize($path) {
    return exec ('stat -c %s '. escapeshellarg ($path));
}


function resizeImage( $path, $max_width, $max_height ) {
    $image_info = getimagesize($path);

    if ( empty($image_info) ) {
        throw new Exception("Wrong image format");
    } else {
        list( $height, $width, $type ) = $image_info;

        $coeff = array();
        if ($width > $max_width) {
            $coeff[] = $max_width / $width;
        }
        if ($height > $max_height) {
            $coeff[] = $max_height / $height;
        }

        if (!empty($coeff)) { // если есть потребность в масштабировании
            $coeff = min($coeff);

            $new_width = floor( $coeff * $width );
            $new_height = floor( $coeff * $height );

            $image = imagecreatefromstring( file_get_contents( $path ) );
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            imageinterlace( $new_image );
            if ( IMAGETYPE_JPEG == $type ) {
                imagejpeg( $new_image, $path, 85 );
            } elseif ( IMAGETYPE_GIF == $type ) {
                imagegif( $new_image, $path);
            } elseif ( IMAGETYPE_PNG == $type ) {
                imagepng( $new_image, $path );
            } elseif ( IMAGETYPE_WBMP == $type ) {
                imagewbmp( $new_image, $path );
            } else {
                return FALSE;
            }
        }
    }
}

function sec2dhms( $sec ) {
    // holds formatted string
    $hms = new StdClass();

    $hms->days = intval( intval( $sec ) / 86400 );

    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hms->hours = intval( intval( $sec / 3600 ) % 24 );

    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in
    // minutes past the hour: to get that, we need to
    // divide by 60 again and keep the remainder
    $hms->minutes = intval( ( $sec / 60 ) % 60 );

    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $hms->seconds = intval( $sec % 60 );

    // done!
    return $hms;
}


