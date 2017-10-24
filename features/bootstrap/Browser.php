<?php

use Behat\Mink\Session;

/**
 * Window
 */
class Browser extends Session
{
    /**
     * Time to wait before use after selecting an element.
     * To avoid click or get information about an element that
     * is still beeing proceesed by javascript.
     *
     * @var integer
     */
    public $waitForJavascriptProcessing=500;

    /**
     * Get an element by id.
     *
     * @param string $id
     * @return \Behat\Mink\Element\NodeElement
     */
    public function getElementByXpath($xpath, $wait = true)
    {
        $wait ? $this->waitFor($xpath) : null;
        $found = $this->getDriver()->find($xpath);
        return $found ? $found[0] : null;
    }

    /**
     * Get an element by id.
     *
     * @param string $id
     * @return \Behat\Mink\Element\NodeElement
     */
    public function getElementById($id, $wait = true)
    {
        $xpath = "//*[@id=".
            $this->encodeXpathString($id).
            "]";
        $wait ? $this->waitFor($xpath) : null;
        $found = $this->getDriver()->find($xpath);
        if(!$found) {
            throw new Exception("Id: $id not found");
        }
        return $found[0];
    }

    /**
     * Get an element by id.
     *
     * @param string $id
     * @return \Behat\Mink\Element\NodeElement
     */
    public function getElementByIdLike($id, $wait = true)
    {
        $xpath = "//*[contains(@id, ".
            $this->encodeXpathString($id).
            ")]";
        $wait ? $this->waitFor($xpath) : null;
        $found = $this->getDriver()->find($xpath);
        if(!$found) {
            throw new Exception("Like Id: $id not found");
        }
        return $found[0];
    }

    /**
     * Get the elements that contains and specific text.
     *
     * @param string $textContent
     * @return \Behat\Mink\Element\NodeElement[]
     */
    public function getElementsByTextContent(
        $textContent,
        $base = '//*',
        $wait = true
    ) {
        $xpath = $base.
            "[contains(., ".
            $this->encodeXpathString($textContent).
            ")]";
        $wait ? $this->waitFor($xpath) : null;
        return $this->getDriver()->find($xpath);
    }

    /**
     * Get the elements that contains and specific text.
     *
     * @param string $textContent
     * @return \Behat\Mink\Element\NodeElement[]
     */
    public function waitElementsByTextContent(
        $textContent,
        $time = 5000,
        $base = '//*'
    ) {
        $xpath = $base.
            "[contains(., ".
            $this->encodeXpathString($textContent).
            ")]";
        return $this->waitFor($xpath, $time);
    }

    /**
     * Encodes and string to be used inside an xpath expression.
     *
     * @param string $string
     * @return string
     */
    public function encodeXpathString($string)
    {
        if (strpos($string, '"') !== false && strpos($string, "'") !== false) {
            $parts = preg_split(
                '/(\'|")/', $string, -1,
                PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
            );
            $encoded = [];
            foreach ($parts as $str) {
                $encoded[] = $this->encodeXpathString($str);
            }
            return 'concat('.implode(',', $encoded).')';
        } elseif (strpos($string, '"') !== false) {
            return "'".$string."'";
        } else {
            return '"'.$string.'"';
        }
    }

    /**
     * Wait until elements defined with a xpath expression are present.
     *
     * @param string $xpath
     * @param int $time
     */
    public function waitFor($xpath, $time = 5000)
    {
        $jxpath = json_encode($xpath);
        $condition = 'document.evaluate('.$jxpath.', document, null, XPathResult.ANY_TYPE, null).iterateNext()!==null';
        $this->wait($time, $condition);
        //Wait for javascript event handlers
        $this->wait($this->waitForJavascriptProcessing);
    }

    /**
     * Get the last element that match a text.
     *
     * @param string $text
     * @return \Behat\Mink\Element\NodeElement
     */
    public function getElementByTextContent($text, $cssClass = '')
    {
        if ($cssClass) {
            $base = '//*[contains(@class, '.$this->encodeXpathString($cssClass).')]';
        } else {
            $base = '//*';
        }
        $tags = $this->getElementsByTextContent($text, $base);
        if(!$tags) {
            throw new Exception("Text '$text' not found");
        }
        return $tags ? $tags[count($tags) - 1] : null;
    }

    /**
     * Get the last element that match a text.
     *
     * @param string $text
     * @return \Behat\Mink\Element\NodeElement
     */
    public function getElementByValue($selector, $value)
    {
        $base = '//'.$selector;
        $tags = $this->getDriver()->find($base);
        $regexp = '/'.str_replace('\*', '.*', preg_quote($value, '/')).'/';
        foreach ($tags as $tag) {
            if (preg_match($regexp, $tag->getValue())) {
                return $tag;
            }
        }
        return $tags ? $tags[count($tags)-1] : null;
    }

    /**
     * Returns Session ID of WebDriver or `null`, when session not started yet.
     *
     * @return string|null
     */
    public function getWebDriverSessionId()
    {
        return $this->getDriver()->getWebDriverSessionId();
    }
}
