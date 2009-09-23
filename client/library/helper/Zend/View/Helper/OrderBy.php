<?php
class Zend_View_Helper_OrderBy extends Zend_View_Helper_Abstract {
    /**
     * Вывод списка сортировки
     *
     * @param array $order_terms Хеш "поле сортировки" => ( "название", "сортировка по-умолчанию" )
     *
     * @return string
     */
    public function orderBy( array $order_terms, $page, $cur_order = NULL, $direction = NULL ) {
        if( empty($page) ) {
            $page = getCurrentPage();
        }
        if( empty($cur_order) ) {
            $cur_order = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'orderby' );
        }
        if( empty($direction) ) {
            $direction = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'direction' );
        }

        $str = "<p class='selectors'>";
        $str .= "Сортировать по: ";
        foreach ( $order_terms as $field => $value ) {
            list( $title, $def_direction ) = $value;
            $new_direction = ( $field == $cur_order )
                             ? ( $direction == ORDER_ASC )
                                ? ORDER_DESC
                                : ORDER_ASC
                            : $def_direction;
            $amp = ( strpos($page, '?') === FALSE ) ? '?' : '&';
            $url = $page . $amp . 'orderby=' . htmlspecialchars($field) . '&direction=' . htmlspecialchars($new_direction);
            $str .= sprintf(
                "<span class='selector ". (($field == $cur_order) ? "selected" : "") ."'><a class='link' orderby='".$field."' direction='".$new_direction."' href='%s'>%s</a> %s</span>",
                $url,
                $title,
                ( $field == $cur_order )
                    ? ( $direction == ORDER_ASC )
                        ? "▲"
                        : "▼"
                    : ""
            );
        }

        $str .= "</p>";
        return $str;
    }
}