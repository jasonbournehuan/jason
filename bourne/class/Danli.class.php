<?php


class Danli
{

    static private $instance;
    private $config;

    private function __construct($config)
    {
               $this->config = $config;
    }

    private function __clone()
    {
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

    public static function getInstance($config)
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance  = new self($config);
        }
        return self::$instance;
    }


    public function getName()
    {
       echo  $this->config;
    }



    function __get($name)
    {
        if(!empty($this->$name))
        {
            echo   '越权访问';
        }else
        {
            echo  '不存在该属性'.$name;
        }
    }

    private $text = 22222;

    public function test()
    {

        echo  $this->text;
    }


}

$danli =  Danli::getInstance(2);
$danli->getName();



