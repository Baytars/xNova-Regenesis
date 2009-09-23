<?php
/**
 * Валидатор для форм, выполняющих пользовательские действия и потому требующих токен
 * @see Form::addAuthToken
 */
class Zend_Validate_AuthToken extends Zend_Validate_Abstract {
    /** Первая часть секретного ключа (соли) */
    const SECRET1 = '\\n*F+@tg/%&d=H\'S,<jdN4';

    /** Вторая часть секретного ключа (соли) */
    const SECRET2 = ']R%zH5k3S9y6@fPwln28lIKJu\'(s';

    /** Длина подписи */
    const SIGNATURE_LENGTH = LENGTH_SHA1;

    /**
     * Электронная подпись
     * @param int $time таймштамп
     * @return string подпись (строка длиной SIGNATURE_LENGTH символов)
     */
    private static function getSignature($time) {
        if ($user = Zend_Auth::getInstance()->getIdentity()) {
            $user_id = $user->id;
        } else {
            $user_id = NULL;
        }
        return sha1(self::SECRET1 . '|' . $time . '|' . $user_id . '|' . self::SECRET2);
    }

    /**
     * Получить токен
     * @return string
     */
    public static function getToken() {
        $time = time();
        $signature = self::getSignature($time);
        return $signature . dechex($time);
    }

    /**
     * Проверить правильность токена
     * @param string $value проверяемое значение
     * @return bool
     */
    public function isValid($value) {
        $this->_setValue($value);

        $signature = substr($value, 0, self::SIGNATURE_LENGTH);
        $time = (int)hexdec(substr($value, self::SIGNATURE_LENGTH));

        $now = time();

        if (($time >= $now - 3 * HOUR) && ($time <= $now) && (self::getSignature($time) == $signature)) {
            return TRUE;
        } else {
            $this->_error();
            return FALSE;
        }
    }
}