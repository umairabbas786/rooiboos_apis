<?php


abstract class ApiDoc {

    private string $unique_class;
    private int $unique_class_access_count;

    public function __construct() {
        $this->unique_class = "key_" . bin2hex(openssl_random_pseudo_bytes(30));
        $this->unique_class_access_count = 0;
    }

    function getUniqueClass() {
        if ($this->unique_class_access_count == 2) {
            $this->unique_class = "key_" . bin2hex(openssl_random_pseudo_bytes(30));
            $this->unique_class_access_count = 0;
        }
        $this->unique_class_access_count++;
        echo $this->unique_class;
    }

    abstract function onGeneralMeta();
    abstract function onParamsDoc();
    abstract function onResponseDoc();

    function show() {
        ?> <hr /> <div class="container"> <?php
        $this->onGeneralMeta();
        $this->onParamsDoc();
        ?> <h2 class="mt-5">Responses</h2> <?php
        $this->onResponseDoc();
        ?> </div> <?php
    }
}