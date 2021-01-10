<?php

namespace app\lib;


class HttpParameters
{
    private $get;

    private $post;

    public function __construct($get, $post)
    {
        $this->get = $get;
        $this->post = $post;
    }

    public function getParameter($key)
    {
        if (isset($this->get[$key])) {
            return $this->get[$key];
        }

        return "";
    }

    public function getPostParemeter()
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }

        return "";
    }

    public function getParameters()
    {
        return $this->get;
    }

    public function getPostParamters()
    {
        return $this->post;
    }

    public function all() {
        return array_merge($this->get, $this->post);
    }
}