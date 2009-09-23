<?php
class Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive_NoDiacritics extends Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive {
    public function __construct() {
        parent::__construct();
        $this->addFilter(new Zend_Search_Lucene_Analysis_TokenFilter_NoDiacritics());
    }
}