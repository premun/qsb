<?php

class findLink {
    protected function _link_www($matches) {
        $url = $matches[2];
        $url = findLink::cleanURL($url);
        if(empty($url)) {
            return $matches[0];
        }

        return "{$matches[1]}<a href='{$url}' target='_blank'>{$url}</a>";
    }

    public function cleanURL($url) {
        if($url == '') {
            return $url;
        }

        $url = preg_replace("|[^a-z0-9-~+_.?#=!&;,/:%@$*'()x80-xff]|i", '', $url);
        $url = str_replace(array( "%0d", "%0a" ), '', $url);
        $url = str_replace(";//", "://", $url);

        if(strpos($url, ":") === false && substr($url, 0, 1) != "/" && !preg_match("|^[a-z0-9-]+?.php|i", $url)) {
            $url = "http://{$url}";
        }

        $url = preg_replace("|&([^#])(?![a-z]{2,8};)|", "&#038;$1", $url);
        $url = str_replace("'", "&#039;", $url);

        return $url;
    }

    public function transform( $text ) {
        $text = " {$text}";

        $text = preg_replace_callback('#(?<=[\s>])(\()?([\w]+?://(?:[\w\\x80-\\xff\#$%&~/\-=?@\[\](+]|[.,;:](?![\s<])|(?(1)\)(?![\s<])|\)))*)#is',array('findLink', '_link_www'),$text);

        $text = preg_replace('#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i', "$1$3</a>", $text);
        $text = trim($text);

        return $text;
    }
}
?>