<?php


namespace model;

use database\ConnectionSingleton;
use Exception;
use stdClass;

class Cat
{
    const TABLE = "test.cat";
    private stdClass $data;
    private stdClass $changedData;

    public function setNameValue(string $name)
    {
        $this->changedData->name = $name;
    }

    public function setParentId(int $id)
    {
        $this->changedData->parentId = $id;
    }

    public function getId():int
    {
        return $this->data->id;
    }

    public function getNameValue():string
    {
        return $this->data->name;
    }

    public function getParentId():int
    {
        return $this->data->parentId;
    }

    public function __construct(int $id)//select one
    {
        $table = static::TABLE;
        $data = ConnectionSingleton::getPgConnection()->query("SELECT id, name, parent_id FROM $table ".($id !== null ? "WHERE id = $id":""));
        if (count($data) !== 1)
            throw new Exception("database error");
        $this->data = new stdClass();
        $this->data->id = $data[0]["id"];
        $this->data->name = $data[0]["name"];
        $this->data->parentId = $data[0]["parent_id"];
        $this->changedData = clone $this->data;
    }

    public function update():Cat
    {
        if ($this->data !== $this->changedData)
        {
            ConnectionSingleton::getPgConnection()->update(static::TABLE, ["name"=>$this->changedData->name, "parent_id"=>$this->changedData->parentId], "where id={$this->data->id}");
            $this->data = $this->changedData;
            $this->changedData = clone $this->data;
        }
        return $this;
    }

    public static function create(string $name, int $parentId):Cat
    {
        $res = ConnectionSingleton::getPgConnection()->insert(static::TABLE, ["name"=>$name, "parent_id"=>$parentId], "id");
        if (count($res) == 1)
            $res = $res[0]["id"];
        return new Cat($res);
    }

    public static function list(string $orderBy = "", $json = false):array|string
    {
        $result = [];
        if ($orderBy !== "")
        {
            //todo: try catch
            $param = $orderBy[0];
            $data = ConnectionSingleton::getPgConnection()->query("SELECT id FROM ".static::TABLE." ORDER BY :param ", ["param"=>$param]);
        } else {
            $data = ConnectionSingleton::getPgConnection()->query("SELECT id FROM ".static::TABLE);
        }
        foreach ($data as $item)
        {
            try {
                if ($json)
                {
                    $cat = new static($item["id"]);
                    $result[] = [
                        "id"=>$cat->getId(),
                        "name"=>$cat->getNameValue(),
                        "parentId"=>$cat->getParentId(),
                    ];
                } else {
                    $result[] = new static($item["id"]);
                }
            } catch (Exception $e) {
                echo $e->__toString();
            }
        }

        if ($json)
            return json_encode($result)??"";

        return $result;
    }
}