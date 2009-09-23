<?php
/**
 * Валидатор для полей, предназначенных для ввода года. Поддерживает диапазоны лет
 */
class Zend_Validate_Year extends Zend_Validate_Abstract {
    const MIN_YEAR      = 1800;
    const MAX_YEAR      = 2050;

    const WRONG_NUMBER  = 'Неверно указан год';
    const NOT_GREATER   = 'Неправильно указан диапазон лет';

    protected $_messageTemplates = array(
        self::WRONG_NUMBER  => 'Неверно указан год',
        self::NOT_GREATER   => 'Неправильно указан диапазон лет',
    );

    /** @var string|null для второго года в диапазоне — имя элемента формы для первого года */
    private $after;

    public function __construct($after = NULL) {
        $this->after = $after;
    }

    public function isValid($value, $context = NULL) {
        $this->_setValue($value);

        if (((string)$value === (string)(int)$value) && (self::MIN_YEAR <= $value) && ($value <= self::MAX_YEAR)) {
            if (!empty($this->after) && !empty($context)) {
                if (isset($context[$this->after]) && ($value >= $context[$this->after])) {
                    return TRUE;
                } else {
                    $this->_error(self::NOT_GREATER);
                }
            } else {
                return TRUE;
            }
        } else {
            $this->_error(self::WRONG_NUMBER);
        }

        return FALSE;
    }
}