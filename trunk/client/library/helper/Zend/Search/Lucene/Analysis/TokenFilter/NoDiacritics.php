<?php
class Zend_Search_Lucene_Analysis_TokenFilter_NoDiacritics extends Zend_Search_Lucene_Analysis_TokenFilter {
    /**
     * Normalize Token or remove it (if null is returned)
     *
     * @param Zend_Search_Lucene_Analysis_Token $srcToken
     * @return Zend_Search_Lucene_Analysis_Token
     */
    public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken) {
        $newToken = new Zend_Search_Lucene_Analysis_Token(
            removeDiacritics($srcToken->getTermText()),
            $srcToken->getStartOffset(),
            $srcToken->getEndOffset()
        );
        $newToken->setPositionIncrement($srcToken->getPositionIncrement());
        return $newToken;
    }
}