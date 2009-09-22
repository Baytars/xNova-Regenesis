<?php
require realpath( dirname(__FILE__) . '/../bootstrap.php' );

function parse( $input, $options ) {
    if ( is_array( $input ) ) {
        foreach( $input as $dir ) {
            parse( $dir, $options );
        }

        return;
    }

    $dir = opendir($input);
    while( FALSE !== ( $item = readdir($dir) ) ) {
        if ( substr($item, 0, 1) == '.' ){
            continue;
        }

        if ( is_dir( $input . '/' . $item ) ) {
            parse( $input . '/' . $item, $options );
        } else {
            if ( isset($options['extensions']) ) {
                $found = FALSE;
                foreach( $options['extensions'] as $ext ) {
                    if ( strpos($item, $ext) !== FALSE ) {
                        $found = TRUE;
                    }
                }

                if ( !$found ) {
                    continue;
                }
            }
            exec( sprintf("xgettext -L php -o %1s -j --from-code=utf-8 %s ", $options['output'], $input . '/' . $item ) );
        }
    }
}

$dirs = array(
    ROOT . '/application',
    ROOT . '/models'
);

$exts = array(".phtml", ".php", ".js");
$locales = array("ru_RU", "ru_UA", "en_US");

foreach( $locales as $locale ) {
      parse( $dirs, array(
                "output" => ROOT . '/languages/gettext/' . $locale . '/LC_MESSAGES/novaesx.po',
                "extensions" => $exts
      ) );
}