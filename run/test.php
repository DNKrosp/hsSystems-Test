<?php

use controller\CatController;
use database\ConnectionSingleton;
use model\Cat;
use view\CatUtils;

require_once("../vendor/autoload.php");

//file_put_contents(__CONFIG__."/startProject.txt", date("h:i:s", time()));

//$result = ConnectionSingleton::getPgConnection()->query("SELECT * FROM test.cat");
//var_dump($result);


//$newEl = Cat::create("test1111", 1);
//$newEl->setNameParam(md5(random_bytes(random_int(10, 16))));
//$newEl->update();
//var_dump($newEl);

//$all = Cat::list("", true);
//var_dump($item);


//$result = [];
//мне кажется, что цикл будет явно быстрее рекурсии, по крайней мере в php ;)
//$children = $allCats;
//foreach ($allCats as $category => $cats)
//{
//    /**
//     * Вообще бы я эту штуку делал на фронте, отдав данные и нагружал бы клиентские устройства, а не беке сделал бы ограничение по вложенности
//     * И запрашивал бы с фронта конечную глуюину,
//     * Закешировал бы первый результат дл...
//     */
//    unset($children[array_key_first($children)]);
//    foreach ($cats as $catNum => $cat)
//    {
//        $result[$category][$catNum] = [
//            "id"=>$cat["id"],
//            "name"=>$cat["name"],
//        ];
//        foreach ($children as $childCategory => $childCats)
//            $result[$category][$catNum]["children"][$childCategory] = $childCats;
//    }
//}


//function getCatHierarchyRender(array $allCatsCategory): string
//{
//    $allCatsCategoryCopy = $allCatsCategory;
//    $prevousBlocks = null;
//    while (count($allCatsCategory) - 1 !== 0) {
//        $category = array_key_first($allCatsCategory);
//        array_pop($allCatsCategory);
//        $chunk = array_chunk($allCatsCategoryCopy, $category, true);
//        foreach ($chunk as $cats) {
//            $prevousBlocks = getTemplateWithVars($cats, $prevousBlocks);
//        }
//    }
//    return implode($prevousBlocks);
//}
//
//function getTemplateWithVars(array $allCats, ?array $prevousBlocks): array
//{
//    $isFirst = $prevousBlocks == null;
//    $template = file_get_contents(__DATA__ . "/template.html") ?? "";
//    $templates = [];
//    foreach ($allCats as $cats) {
//        $vars = explode("{{", $template);
//        if ($vars > 1)
//            array_shift($vars);
//        foreach ($vars as $var) {
//            $var = explode("}}", $var)[0] ?? "";
//            foreach ($cats as $numCat => $cat) {
//                if (key_exists($var, $cat)) {
//                    $templates[$numCat] = str_replace("{{" . $var . "}}", $cat[$var], (isset($templates[$numCat]) ? $templates[$numCat] : $template));
//                } elseif ($var == "children" && !$isFirst) {
//                    $templates[$numCat] = str_replace("{{" . $var . "}}", implode($prevousBlocks), (isset($templates[$numCat]) ? $templates[$numCat] : $template));
//                } else {
//                    $templates[$numCat] = str_replace("{{" . $var . "}}", "", (isset($templates[$numCat]) ? $templates[$numCat] : $template));
//                }
//            }
//        }
//    }
//    return $templates;
//}

//$contr = new CatController();
//$allCats = $contr->listStructByParent();
//$catsHierarchyRender = CatUtils::getCatHierarchyRender($contr->listStructByParent());;
//echo $catsHierarchyRender;




