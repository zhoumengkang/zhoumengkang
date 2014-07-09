<?php
class friendlinksWidget extends Widget{
    protected static function getData(){
        echo "getData";
    }
    public static function widgetFetch(){
        self::getData();
    }
}