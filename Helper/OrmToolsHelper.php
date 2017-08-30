<?php


namespace OrmTools\Helper;


use QuickPdo\QuickPdoInfoTool;

class OrmToolsHelper
{
    public static function getPhpDefaultValuesByTables(array $tables, array $callbacks = [])
    {


        $ret = [];
        $defaultDb = QuickPdoInfoTool::getDatabase();
        $callbacks = array_merge([
            '*' => function ($type, $isNullable, $isAutoIncremented, $nbColumns) {
                if ($isAutoIncremented) {
                    return null;
                }

                if (true === $isNullable) {
                    return null;
                } else {
                    switch ($type) {
                        case 'int':
                        case 'tinyint':
                        case 'decimal':
                            return 0;
                            break;
                        default:
                            return '';
                            break;
                    }
                }
            },
        ], $callbacks);


        foreach ($tables as $table) {

            list($fullTable, $db, $table) = self::explodeTable($table, $defaultDb);


            $nullables = QuickPdoInfoTool::getColumnNullabilities($fullTable);
            $types = QuickPdoInfoTool::getColumnDataTypes($fullTable);
            $ai = QuickPdoInfoTool::getAutoIncrementedField($table, $db);

            $nbColumns = count($types);

            foreach ($types as $column => $type) {
                $cb = (array_key_exists($type, $callbacks)) ? $callbacks[$type] : $callbacks['*'];
                $isNullable = (true === $nullables[$column]);
                $isAutoIncremented = ($ai === $column);
                $phpVal = call_user_func($cb, $type, $isNullable, $isAutoIncremented, $nbColumns);
                $ret[$column] = $phpVal;
            }
        }
        return $ret;
    }


    //--------------------------------------------
    //
    //--------------------------------------------
    private static function explodeTable($table, $defaultDb)
    {
        $p = explode(".", $table);
        if (1 === count($p)) {
            $db = $defaultDb;
            $table = $p[0];
        } else {
            $db = $p[0];
            $table = $p[1];
        }


        return [
            $db . "." . $table,
            $db,
            $table,
        ];
    }
}