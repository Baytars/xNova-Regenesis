<?php
class Zend_Session_SaveHandler_Decorator implements Zend_Session_SaveHandler_Interface {
    protected $cache;

    public function __construct(Zend_Session_SaveHandler_Interface $handler) {
        $this->handler = $handler;
    }

    /**
     * Открывает хранилище сессии
     * @param string $save_path
     * @param string $name
     * @return bool
     */
    public function open($save_path, $name) {
        return $this->handler->open($save_path, $name);
    }

    /**
     * Закрывает хранилище сессии
     * @return bool
     */
    public function close() {
        return $this->handler->close();
    }

    /**
     * Читает данные сессии
     * @param string $id идентификатор сессии
     * @return mixed
     */
    public function read($id) {
        return $this->handler->read($id);
    }

    /**
     * Записывает данные сессии
     * @param string $id идентификатор сессии
     * @param mixed $data
     * @return bool
     */
    public function write($id, $data) {
        return $this->handler->write($id, $data);
    }

    /**
     * Уничтожает сессию — удаляет данные
     * @param string $id идентификатор сессии
     * @return bool
     */
    public function destroy($id) {
        return $this->handler->destroy($id);
    }

    /**
     * Сборщик мусора — уничтожает устаревшие данные сессии
     * @param int $maxlifetime время жизни данных (в секундах)
     * @return bool
     */
    public function gc($maxlifetime) {
        return $this->handler->gc($maxlifetime);
    }
}