<?php

namespace view;

class CatUtils
{
    private static function getTemplateWithVars(array $allCats, ?array $prevousBlocks): array
    {
        $isFirst = $prevousBlocks == null;
        $template = file_get_contents(__DATA__ . "/template.html") ?? "";
        $templates = [];
        $vars = explode("{{", $template);
        if ($vars > 1)
            array_shift($vars);
        foreach ($vars as $var) {
            $var = explode("}}", $var)[0] ?? "";
            foreach ($allCats as $numCat => $cat) {
                if (key_exists($var, $cat)) {
                    $templates[$numCat] = str_replace("{{" . $var . "}}", $cat[$var], (isset($templates[$numCat]) ? $templates[$numCat] : $template));
                } elseif ($var == "children" && !$isFirst) {
                    $templates[$numCat] = str_replace("{{" . $var . "}}", implode($prevousBlocks), (isset($templates[$numCat]) ? $templates[$numCat] : $template));
                } else {
                    $templates[$numCat] = str_replace("{{" . $var . "}}", "", (isset($templates[$numCat]) ? $templates[$numCat] : $template));
                }
            }
        }
        return $templates;
    }


    public static function getCatHierarchyRender(array $allCatsCategory): string
    {
        $allCatsCategory = array_reverse($allCatsCategory);
        $prevousBlocks = null;
        while (count($allCatsCategory) !== 0) {
            $chunk = array_shift($allCatsCategory);
            $prevousBlocks = self::getTemplateWithVars($chunk, $prevousBlocks);
        }
        return implode($prevousBlocks);
    }

}