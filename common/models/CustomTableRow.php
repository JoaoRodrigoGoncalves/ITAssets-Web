<?php

namespace common\models;
class CustomTableRow
{
    public string $id;
    public string $nome;
    public ?string $info_adicional;

    public function __construct($id, $nome, $info_adicional)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->info_adicional = $info_adicional;
    }

}