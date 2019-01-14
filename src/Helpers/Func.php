<?php
namespace DenDroGram\Helpers;

class Func
{
    /**
     * 多条件查询二维数组 返回唯一值
     *
     * @param $array
     * @param array $params
     * @return array
     */
    public static function quadraticArrayQuery(array $array, array $params)
    {
        foreach ($array as $item) {
            $flag = true;
            foreach ($params as $field => $value) {
                if ($item[$field] != $value) {
                    $flag = false;
                }
            }
            if ($flag) {
                return $item;
            }
        }

        return [];
    }

    /**
     * 多条件查询二维数组 返回二维数组结构
     *
     * @param $array
     * @param array $params
     * @return array
     */
    public static function quadraticArrayQueryAll(array $array, array $params)
    {
        $data = [];
        foreach ($array as $item) {
            $add = true;
            foreach ($params as $field => $value) {
                if ($item[$field] != $value) {
                    $add = false;
                }
            }
            if ($add) {
                $data[] = $item;
            }
        }

        return $data;
    }

    /**
     * 多条件查询二维数组索引
     *
     * @param $array
     * @param array $params
     * @return bool|int|string
     */
    public static function quadraticArrayGetIndex(array $array, array $params)
    {
        $index = false;
        foreach ($array as $key => $item) {
            $add = true;
            foreach ($params as $field => $value) {
                if ($item[$field] != $value) {
                    $add = false;
                }
            }
            if ($add) {
                $index = $key;
                break;
            }
        }

        return $index;
    }

    /**
     * 二维数组分组
     * @param $array
     * @param array $keys
     * @return array
     */
    public static function quadraticArrayGroup(array $array, array $keys)
    {
        $data = [];
        foreach ($array as $item) {
            $group_key = '';
            foreach ($keys as $key) {
                $group_key .= $item[$key] . '|';
            }

            $data[$group_key][] = $item;
        }
        return $data;
    }

    /**
     * 根据值返回所有键
     * @param $array
     * @param $value
     * @return array
     */
    public static function keysQueryByValue(array $array, $value)
    {
        $keys = [];
        foreach ($array as $k => $v) {
            if ($v == $value) {
                $keys[] = $k;
            }
        }

        return $keys;
    }

    /**
     * 二维度数组排序
     * @param $array
     * @param $field
     * @param int $order
     * @return array
     */
    public static function quadraticArraySort(array $array, $field, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        foreach ($array as $k => $v) {

        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];
        }

        return $new_array;
    }

    /**
     *  $array = [
     *  ["id"=>1,"p_id"=>2,"name"=>"中国"],
     *  ["id"=>2,"p_id"=>1,"name"=>"四川"],
     *  ["id"=>3,"p_id"=>1,"name"=>"北京"],
     *  ["id"=>4,"p_id"=>2,"name"=>"成都"]];
     * 二维数组转树形结构
     * @param string $id
     * @param string $p_id
     * @param array $array
     * @param array $tree
     */
    public static function quadraticArrayToTree($id, $p_id, &$array, &$tree = [])
    {
        if (empty($array)) {
            return;
        }

        if (empty($tree)) {
            $item = array_shift($array);
            $tree[$item[$id]] = [];
        }

        foreach ($tree as $branch => &$leaves) {
            foreach ($array as $key => $value) {
                if ($value[$p_id] == $branch) {
                    $leaves[$value[$id]] = [];
                    unset($array[$key]);
                }
            }

            if (!empty($leaves) && $array) {
                self::quadraticArrayToTree($id, $p_id, $array, $leaves);
            }
        }
    }

    /**
     * 数组转json字符串(文本形式) 支持多维度
     * @param array $array
     * @return string
     */
    public static function arrayToJsonString(array $array)
    {
        $json = '';
        $is_object = true;
        foreach ($array as $name => $value) {
            if (self::arrayFirstKey($array) == $name && is_int($name)) {
                $json .= '[';
                $is_object = false;

                if (!is_array($value)) {
                    $json .= "\"$value\",";
                    continue;
                }
                $json .= self::arrayToJsonString($value) . ",";
                continue;
            } elseif (self::arrayFirstKey($array) == $name) {
                $json .= '{';

                if (!is_array($value)) {
                    $json .= "\"$name\":\"$value\",";
                    continue;
                }
                $json .= self::arrayToJsonString($value) . ",";
                continue;
            }

            if (self::arrayEndKey($array) == $name && $is_object) {
                if (!is_array($value)) {
                    $json .= "\"$name\":\"$value\"}";
                    continue;
                }
                $json .= self::arrayToJsonString($value) . "}";
                break;
            } elseif (self::arrayEndKey($array) == $name) {
                if (!is_array($value)) {
                    $json .= "\"$name\":\"$value\"]";
                    continue;
                }
                $json .= self::arrayToJsonString($value) . "]";
                break;
            }

            if ($is_object) {
                if (!is_array($value)) {
                    $json .= "\"$name\":\"$value\",";
                    continue;
                }
                $json .= self::arrayToJsonString($value) . ",";
                continue;
            }
            if (!is_array($value)) {
                $json .= "\"$value\",";
                continue;
            }
            $json .= self::arrayToJsonString($value) . ",";
        }

        return $json;
    }

    /**
     * @param array $array
     * @return int|null|string
     */
    public static function arrayFirstKey(array $array)
    {
        reset($array);
        return key($array);
    }

    /**
     * @param array $array
     * @return int|null|string
     */
    public static function arrayEndKey(array $array)
    {
        end($array);
        return key($array);
    }

    /**
     * 首位sprintf
     * @param $string
     * @param string $aim
     * @param $value
     * @return bool|string
     */
    public static function firstSprintf($string, $value, $aim = '%s')
    {
        $position = strpos($string, $aim);
        $len = strlen($aim);
        $left = substr($string, 0, $position + $len);
        $right = substr($string, $position + $len);
        return sprintf($left, $value) . $right;
    }
}