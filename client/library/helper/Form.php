<?php
/**
  * Класс формы - базовый класс для всех наших форм
  * позволяет загружать элементы, находящиеся в папочке Form/Elements
*/
class Form extends Zend_Form {

    /** @var bool Чтобы все элементы были внутри массива (если указано имя) */
    protected $_isArray = TRUE;

    /**
     * @var готова ли форма к проверке валидности и обработке
     * @see Form::isReadyToProcess
     * @see Form::setReadyToProcess
     */
    private $is_ready_to_process = TRUE;

    protected $default_element_decorators = array(  "ViewHelper",
                                                    array("Errors", array("placement" => "PREPEND")),
                                                    array("HtmlTag", array("tag" => "dd")),
                                                    array("Label", array("tag" => "dt"))
                                                  );

    /**
     * @param array $options
     */
    public function __construct($options = NULL) {
        parent::__construct($options);

        $translator = new Form_Translator();
        $this->setTranslator(new Form_Translator());
    }

    /**
     * Готова ли форма к проверке валидности и обработке.
     * Используется в многоэтапных формах для определения, отправлена ли форма окончательно
     * или пока находится на одном из этапов заполнения
     */
    final public function isReadyToProcess() {
        return $this->is_ready_to_process;
    }

    /**
     * Указать, готова ли форма к проверке валидности и обработке.
     * @param bool $ready готова ли
     */
    final protected function setReadyToProcess($ready = TRUE) {
        $this->is_ready_to_process = (bool)$ready;
    }

    /**
     * Проверяет, были ли форме переданы входные данные (т. е. был ли произведён сабмит)
     */
    public function hasInput() {
        $key = $this->getElementsBelongTo();
        return empty($key) ? !empty($_POST) : !empty($_POST[$key]);
    }

    /**
     * Предварительная обработка формы - до проверки валидности.
     * Может вызывать setReadyToProcess
     * @see Form::setReadyToProcess
     */
    protected function preProcess() {

    }

    /**
     * Основная обработка формы
     */
    protected function mainProcess() {

    }

    /** @var bool закончилась ли обработка формы */
    private $processed = FALSE;

    /**
     * Закончилась ли обработка формы
     * @return bool
     */
    final public function hasBeenProcessed() {
        return $this->processed;
    }

    /**
     * Полная обработка формы — включает предварительную и основную
     * @return mixed возвращает то же, что mainProcess, или NULL, если форма не готова. Следует учесть, что mainProcess также может возвращать NULL, поэтому для проверки готовности формы следует использовать метод hasBeenProcessed
     * @throws Zend_Validate_Exception если входные данные не валидны
     */
    final public function process() {
        $this->processed = FALSE;
        if ($this->hasInput()) {
            $this->preProcess();
            if ($this->isReadyToProcess()) {
                if ($this->isValid($_POST)) {
                    $this->processed = TRUE;
                    return $this->mainProcess();
                } else {
                    throw new Zend_Validate_Exception(_("Форма не прошла валидацию"));
                }
            }
        }
    }

    protected function getDefaultElementDecorators() {
        return $this->default_element_decorators;
    }

    /*******************     Валидация         ****************/

    private $has_error_holder;
    private $validation_messages = array();

    protected function addValidationMessage($message) {
        if( !$this->has_error_holder) {
            $this->addElement("errorHolder", "error_holder", array("order" => -100));
            $this->has_error_holder = TRUE;
        }
        $this->getElement("error_holder")->addMessage($message);
        if ($this->isArray()) {
            $messages = $this->_attachToArray(array($message), $this->getElementsBelongTo());
        } else {
            $messages = array($message);
        }
        $this->validation_messages = $this->validation_messages + $messages;
    }

    public function getMessages() {
        return parent::getMessages(); + $this->validation_messages;
    }

    /*******************      Кнопки сабмитов       *****************/

    /**
     * Возвращает невидимую кнопочку сабмита чтобы при отправке формы по enter не передавались лишние кнопки
     * @return Zend_Form_Element_Submit
     */
    protected function getFakeSubmit() {
        return new Zend_Form_Element_Submit("i_dont_wanna_submit_first_button", array(
            "class" => "hidden",
            "decorators" => array("viewHelper")
        ));
    }

    /**
     * Была ли нажата кнопка самбита
     * @param string | Zend_Form_Element $button кнопка или её имя
     * @return bool
     */
    protected function buttonHasBeenPressed($button) {
        $pressed_submits = self::getPressedSubmits($this);
        if( count($pressed_submits) == 1) {
            foreach($pressed_submits as $submit) {
                if( is_string($button) && $submit->getName() == $button) {
                    return TRUE;
                } else if( $button === $submit ) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Получить массив нажатых сабмитов
     * @return array of string
     */
    private static function getPressedSubmits($form) {
        $pressed_submits = array();
        foreach($form->getElements() as $element) {
            if( ($element instanceOf Zend_Form_Element_Submit || ($element instanceOf Zend_Form_Element_Button && $element->getAttrib("type") == "submit"))
                     && $element->getValue() ) {
                $pressed_submits[] = $element;
            }
        }
        foreach($form->getSubForms() as $subform) {
            $pressed_submits = array_merge($pressed_submits, self::getPressedSubmits($subform));
        }
        return $pressed_submits;
    }

    /*******************      AUTH TOKEN       *****************/

    /** Имя элемента формы для токена авторизации */
    const AUTH_TOKEN = "__auth_token";

    public static $DISABLE_AUTH_TOKEN = FALSE;

    /**
     * Эта функция требуется при конструировании формы, требующей удостоверения токеном.
     * По умолчанию вызывается для всех форм — для тех, где токен не требуется, следует использовать removeAuthToken
     * @see Form::removeAuthToken
     * @see Zend_Validate_AuthToken
     */
    protected function addAuthToken() {
        if (self::$DISABLE_AUTH_TOKEN) {
            return;
        }
        $this->addElement("hidden", self::AUTH_TOKEN, array(
            "value"         => Zend_Validate_AuthToken::getToken(),
            "validators"    => array("AuthToken"),
            "required"      => FALSE,
            "decorators"    => array("ViewHelper", "Errors"),
        ));
    }

    /**
     * Вызовите эту функцию при конструировании формы, не требующей удостоверения токеном
     * @see Form::addAuthToken
     * @see Zend_Validate_AuthToken
     */
    protected function removeAuthToken() {
        $this->removeElement(self::AUTH_TOKEN);
    }


    /*******************      MVC       *****************/

    /**
     * @return Zend_View_Interface|null
     */
    public function getView() {
        if ($view = parent::getView()) {
            return $view;
        } else {
            if ($layout = Zend_Registry::get("layout")) {
                $this->setView($view = $layout->getView());
                return $view;
            }
        }
        return $this->_view;
    }

}