<?php
/**
 * User: lp
 * Date: 2019/11/13--16:16
 */
namespace m;

use framework\core\Db;

/**
 * 这是一个数据库备份类
 * Class DataBase
 * @package m
 */
class DataBase
{

    /**
     *
     * @name php备份数据库
     * @param string $DbHost 连接主机
     * @param string $DbUser 用户名
     * @param string $DbPwd 连接密码
     * @param string $DbName 要备份的数据库
     * @param string $saveFileName 要保存的文件名, 默认文件保存在当前文件夹中,以日期作区分
     * @return Null
     * @example backupMySqlData('localhost', 'root', '123456', 'YourDbName');
     *
     */
    function backupMySqlData($DbHost, $DbUser, $DbPwd, $DbName, $saveFileName = '')
    {
        error_reporting(0);
        set_time_limit(0);
        $db = Db::getInstance();

        echo '数据备份中，请稍候......<br />';

        // 声明变量
        $tableStructure = '';
        $fileName = ($saveFileName ? $saveFileName : 'MySQL_data_bakeup_') . date('YmdHis') . '.sql';

        // 枚举该数据库所有的表
        $tables = $db->fetch_all("SHOW TABLES FROM $DbName");
        $tables = array_column($tables, 'Tables_in_'.$DbName);

        // 枚举所有表的创建语句
        $tableStructure .= '# 创建数据表开始'."\r\n";
        foreach ($tables as $val) {
            $table_create_info = $db->fetch("show create table $val");
            $main_info = $table_create_info['Create Table'];
            $isDropInfo = "DROP TABLE IF EXISTS `" . $val . "`;\r\n";
            $tableStructure .= $isDropInfo . $main_info . ";\r\n";
            $tableStructure .= "\r\n";
        }
        $tableStructure .= '# 创建数据表结束'."\r\n";
        $tableStructure .= "\r\n";
        file_put_contents($fileName, $tableStructure, FILE_APPEND);

        // 枚举所有表的INSERT语句
        $sqlStr = '# 插入语句开始'."\r\n";
        foreach ($tables as $val) {
            $res = $db->fetch_all("select * from $val");
            $sqlStr .= "# {$val}表数据开始 \r\n";
            foreach ($res as $one) {
                $sqlStr .= "INSERT INTO `" . $val . "` VALUES ('";
                $sqlStr .= implode("','", array_values($one));
                $sqlStr .= "');\r\n";
            }
            $sqlStr .= "# {$val}表数据结束 \r\n";
            $sqlStr .= "\r\n";
        }
        file_put_contents($fileName, $sqlStr, FILE_APPEND);
        echo '数据备份成功！';
    }

}
