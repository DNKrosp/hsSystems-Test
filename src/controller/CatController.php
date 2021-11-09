<?php

namespace controller;

use model\Cat;

class CatController
{
    public function listStructByParent(): array
    {
        $result = [];

        $cats = Cat::list("parent_id");
        foreach ($cats as $cat)
            $result[$cat->getParentId()][] = ["id"=>$cat->getId(), "name"=>$cat->getNameValue()];
        return $result;
    }
}