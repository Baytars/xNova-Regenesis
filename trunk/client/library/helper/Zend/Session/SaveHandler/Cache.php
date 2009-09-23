<?php
class Zend_Session_SaveHandler_Cache extends Zend_Session_SaveHandler_Decorator {
    protected $cache;

    public function __construct(Zend_Session_SaveHandler_Interface $handler, Zend_Cache_Core $cache) {
        $this->cache = $cache;
        parent::__construct($handler);
    }

    /**
     * Читает данные сессии
     * @param string $id идентификатор сессии
     * @return mixed
     */
    public function read($id) {
        if (! $data = $this->cache->load($this->getCacheId($id))) {
            $data = parent::read($id);
            $this->cache->save($data, $this->getCacheId($id));
        }
        return $data;
    }

    /**
     * Записывает данные сессии
     * @param string $id идентификатор сессии
     * @param mixed $data
     * @return bool
     */
    public function write($id, $data) {
        if ($cached_data = $this->cache->load($this->getCacheId($id))) {
            $need_cache = $data !== $cached_data;
        } else {
            $need_cache = TRUE;
        }

        if ($need_cache) {
            $this->cache->save($data, $this->getCacheId($id));
            return parent::write($id, $data);
        } else {
            return TRUE;
        }
    }

    /**
     * Уничтожает сессию — удаляет данные
     * @param string $id идентификатор сессии
     * @return bool
     */
    public function destroy($id) {
        $this->cache->remove($this->getCacheId($id));
        return parent::destroy($id);
    }

    /**
     * @param string $id идентификатор сессии
     * @return string
     */
    protected function getCacheId($id) {
        return "session_$id";
    }
}