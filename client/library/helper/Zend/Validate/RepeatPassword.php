<?php
/**
 * Валидатор для форм, где нужно ввести пароль два раза. Назначается второму полю для ввода пароля.
 */
class Zend_Validate_RepeatPassword extends Zend_Validate_Abstract {
    const DONT_MATCH = "Введённые пароли не совпадают";

    protected $_messageTemplates = array(
        self::DONT_MATCH => "Введённые пароли не совпадают",
    );

    private $main_field;

    /**
     * @param string $main_field имя поля для ввода пароля (с которым будет сверяться данное)
     */
    public function __construct($main_field = "password") {
        $this->main_field = $main_field;
    }

    public function isValid($value, $context = NULL) {
        $this->_setValue($value);

        if (isset($context[$this->main_field])) {
            if ($context[$this->main_field] == $value) {
                return TRUE;
            } else {
                $this->_error(self::DONT_MATCH);
                return FALSE;
            }
        }

        return TRUE;
    }
}