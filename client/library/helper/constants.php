<?php
// Пути
define( "LOGS_PATH", ROOT . "/logs" );
define( "WEB_PATH", ROOT . "/public" );
define( "BIN_DIR", ROOT."/bin");
define( "TMP_DIR", "/tmp" );
define( "POSTERS_PATH",  WEB_PATH . '/img' );

// Сроки
define( "SECOND",    1 );
define( "MINUTE",    60 * SECOND );
define( "HOUR",      60 * MINUTE );
define( "DAY",       24 * HOUR );
define( "WEEK",      7  * DAY );
define( "MONTH",     30 * DAY );
define( "YEAR",      round( 365.242199 * DAY ) );

// Кратные единицы измерения объёма информации
define( "KIB", 1024 );
define( "MIB", 1024 * KIB);
define( "GIB", 1024 * MIB);
define( "TIB", 1024 * GIB);

// Ограничение на длину (максимальную, если не указано иное) текстовых данных
define( "LENGTH_NAME",              255  ); // обычное название или имя
define( "LENGTH_WORD",              60   ); // одно слово языка
define( "LENGTH_INFO",              200  ); // краткая информационная запись
define( "LENGTH_HOSTNAME",          255  );
define( "LENGTH_URL",               2048 );
define( "LENGTH_PATH",              2048 );
define( "LENGTH_EMAIL",             200  );
define( "LENGTH_USERNAME_MIN",      2    );
define( "LENGTH_USERNAME_MAX",      35   );
define( "LENGTH_PASSWORD",          200  );
define( "LENGTH_DESCRIPTION",       2500 ); // какой-либо описательный текст
define( "LENGTH_LANGUAGE_CODE",     17   );
define( "LENGTH_COUNTRY_CODE",      2    );
define( "LENGTH_MD5",               32   );
define( "LENGTH_SHA1",              40   );
define( "LENGTH_UNIXTIMESTAMP",     32   );
define( "LENGTH_DATA",              65000); // сериализованные данные

// Сессии
define( "SESSION_LIFETIME", 15 * DAY );

// Прочее
define( "REMOTE_SECRET_CODE", "ThIS((isMy00SecrEt.kEy" );
define( "ORDER_DESC", 'desc' );
define( "ORDER_ASC", 'asc' );
