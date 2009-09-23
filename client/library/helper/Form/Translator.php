<?php
class Form_Translator extends Zend_Translate {
    protected static $messages;

    public function __construct() {
        parent::__construct("Array", self::$messages, Zend_Registry::get("locale"));
    }

    public static function _initializeStrings() {
        self::$messages = array(
            Zend_Captcha_ReCaptcha::MISSING_VALUE               => _('Неверно введён текст с картинки'),
            Zend_Captcha_ReCaptcha::ERR_CAPTCHA                 => _('Внутренняя ошибка'),
            Zend_Captcha_ReCaptcha::BAD_CAPTCHA                 => _('Введён недопустимый текст: %value%'),
            Zend_Validate_NotEmpty::IS_EMPTY                    => _("Нужно что-нибудь ввести"),
            Zend_Validate_Alnum::STRING_EMPTY                   => _("Нужно что-нибудь ввести"),
            Zend_Validate_Alnum::NOT_ALNUM                      => _("Должны присутствовать только буквы и цифры"),
            Zend_Validate_Alpha::NOT_ALPHA                      => _("Должны присутствовать только буквы"),
            Zend_Validate_Between::NOT_BETWEEN                  => _("Значение должно быть между %min% и %max% включительно"),
            Zend_Validate_Between::NOT_BETWEEN_STRICT           => _("Значение должно быть между %min% и %max%"),
            Zend_Validate_Digits::NOT_DIGITS                    => _("Нужно ввести число"),
            Zend_Validate_Float::NOT_FLOAT                      => _("Нужно ввести вещественное число"),
            Zend_Validate_GreaterThan::NOT_GREATER              => _("Значение должно превышать %min%"),
            Zend_Validate_InArray::NOT_IN_ARRAY                 => _("Не является допустимым значением"),
            Zend_Validate_Int::NOT_INT                          => _("Значение не является целым числом"),
            Zend_Validate_Ip::NOT_IP_ADDRESS                    => _("Значение не является IP-адресом"),
            Zend_Validate_LessThan::NOT_LESS                    => _("Значение должно быть меньше %max%"),
            Zend_Validate_Regex::NOT_MATCH                      => _("Значение не совпадает с шаблоном «%pattern%»"),
            Zend_Validate_StringLength::TOO_SHORT               => _("Строка не должна быть короче %min% символов"),
            Zend_Validate_StringLength::TOO_LONG                => _("Строка не должна быть длиннее %max% символов"),
            Zend_Validate_EmailAddress::INVALID                 => _("Неправильный адрес e-mail"),
            Zend_Validate_EmailAddress::INVALID_HOSTNAME        => _("Неверное доменное имя для e-mail"),
            Zend_Validate_EmailAddress::INVALID_MX_RECORD       => _("Адресу e-mail не соответствует правильная MX-запись"),
            Zend_Validate_EmailAddress::DOT_ATOM                => _("Неправильный адрес e-mail"),
            Zend_Validate_EmailAddress::QUOTED_STRING           => _("Неправильный адрес e-mail"),
            Zend_Validate_EmailAddress::INVALID_LOCAL_PART      => _("Неправильная локальная часть e-mail адреса"),
            Zend_Validate_RepeatPassword::DONT_MATCH            => _("Введённые пароли не совпадают"),
            Zend_Validate_Url::WRONG_URL                        => _("Неверный формат URL-адреса!"),
            Zend_Validate_Username::ALREADY_EXISTS              => _("Пользователь с таким именем уже существует"),
            Zend_Validate_Username::PROHIBITED                  => _("Использование этого имени пользователя запрещено"),
            Zend_Validate_Year::WRONG_NUMBER                    => _('Неверно указан год'),
            Zend_Validate_Year::NOT_GREATER                     => _('Неправильно указан диапазон лет'),
        );
    }
}

Form_Translator::_initializeStrings();