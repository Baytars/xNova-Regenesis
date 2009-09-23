<?php
class Zend_View_Helper_Pager extends Zend_View_Helper_Abstract {

    /**
     * Возвращает пейджер
     *
     * @param integer $cur_page - текущая страница
     * @param integer $total    - всего страниц
     * @param string $page      - базовая страница (если не указана - берётся текущая страница)
     */
    public function pager($cur_page, $total_pages, $page = NULL)
    {
        //Нормализуем текущую страницу (от 1 до $total_pages)
        // $cur_page = min($total_pages, max(1, $cur_page));
        $cur_page = min(
            $total_pages,
            max(
                1,
                Zend_Controller_Front::getInstance()->getRequest()->getParam( 'page', 1 )
            )
        );

        //Если всего страниц меньше 2 - не выводим пейджер
        if( $total_pages < 2 )
            return '';

        //Выводимые страницы - по 4 в каждую сторону от текущей
        $start = max(1, $cur_page-2);
        //Если начальная страница - 2 делаем её равной 1
        if( $start == 2 ) {
            $start = 1;
        }
        $end = min($cur_page + 5, $total_pages + 1);
        //Если конечная страница = последняя-1, делаем её равной последней
        if( $end == $total_pages - 1 ) {
            $end = $total_pages;
        }

        if( empty($page) ) {
            $params = Zend_Controller_Front::getInstance()->getRequest()->getParams();
            unset($params["page"]);
            $page = getCurrentPage($params);
        }
        $page = rtrim($page, "/");
        $result = '<div class="navpages">';

        $has_left = $total_pages > 1 && $cur_page != 1;
        $has_right = $total_pages > 1 && $cur_page < $total_pages;

        if ( $has_left || $has_right ) {
            $result .= '<div class="leftright">';

            if ( $has_left  ) {
                $result .= $this->address($page, $cur_page - 1, "← Назад");
            }
            if ( $has_right ) {
                $result .= ' ' . $this->address($page, $cur_page + 1, "Вперёд →");
            }

            $result .= '</div>';
        }

        $result .= '<div class="numeric">';

        if( $start > 1 ) {
            $result .= $this->address($page, 1) . ' ... ';
        }
        for ($i = $start; $i < $end; ++$i)
        {
            $result .= ($i == $cur_page)
                    ? " <span class='current'>".$i."</span> "
                    : ($this->address($page, $i) . '');
        }
        if( $end < $total_pages ) {
            $result .= ' ... ' . $this->address($page, $total_pages);
        }
        $result .= '</div></div>';

        return $result;
    }

    protected function address($base, $page, $text = NULL) {
        if ( empty( $text ) ) {
            $text = $page;
        }
        $amp = ( strpos($base, '?') === FALSE ) ? '?' : '&';
        $url = $base . $amp . 'page=' . $page;

        $link = "<a class='link' page='" . $page . "' href='$url'>$text</a>";

        return $link;
    }

}