<?php

namespace common\models;
class CustomTableRow
{
    public string $id;
    public string $nome;
    public ?string $serial;

    public function __construct($id, $nome, $serial)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->serial = $serial;
    }

}