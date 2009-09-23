<?php
class Zend_Controller_Action_Helper_FormProcessor extends Zend_Controller_Action_Helper_Abstract {

    private $redirect_to;
    private $result;
    private $messages;
    private $form;

    /**
     * Обработать форму
     */
    public function process(Form $form, $handleResponse = TRUE, $redirect_to = NULL, $additional_json_params = array()) {

        $this->form = $form;

        if ( ! isset( $redirect_to ) ) {
            $redirect_to = getCurrentPage();
        }
        $this->redirect_to = $redirect_to;

        try {
            $result = $form->process();
            if ($form->hasBeenProcessed()) {
                $this->result = TRUE;
            }
        } catch (Zend_Validate_Exception $e) {
            $this->result = FALSE;
            $this->messages = $this->convertMessages($form->getMessages());
        }

        if( $handleResponse ) {
            $this->handleResponse($additional_json_params);
        }

        return ifsetor($result, NULL);
    }

    public function handleResponse($additional_json_params = FALSE) {
        if( !isset($this->result) ) {
            //Если форма не обрабатывалась - не трогаем ответ сервера
            return;
        }

        if ( $this->getRequest()->isXmlHttpRequest() ) {
            $this->getActionController()->getHelper("layout")->disableLayout();
            $this->getActionController()->getHelper("viewRenderer")->setNoRender(TRUE);
        }

        if( $this->result ) {
            if( $this->getRequest()->isXmlHttpRequest()) {
                $result = array("result" => $this->result, "redirect_to" => $this->redirect_to, "form" => $this->form->render());
                $result = $result + $additional_json_params;
                echo json_encode($result);
                exit();
            } else {
                $this->getActionController()->getHelper("redirector")->gotoUrl($this->redirect_to);
            }
        } else {
            if( $this->getRequest()->isXmlHttpRequest()) {
                echo json_encode(array("result" => FALSE, "messages" => $this->messages));
                exit();
            }
        }
        unset($this->result); //На случай, если хелпер будет вызываться несколько раз
    }

    /**
     * Преобразует сообщения об ошибках формы из многомерного массива в массив id => message
     */
    private function convertMessages($messages, $root = '') {
        $result = array();
        foreach($messages as $id => $value) {
            if( is_array($value) ) {
                $result = $result + $this->convertMessages($value, $root.(empty($root) ? '' : '-').$id);
            } else {
                $result[$root][] = $value;
            }
        }
        return $result;
    }

}