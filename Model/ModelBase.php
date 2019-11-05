<?php

class ModelBase
{
    /* // テーブル名
     * protected static $table = "my_table";
     *
     * // Primary Key
     * protected static $pk = "key";
     */

    // データの扱い
    public function __get($name)
    {
        return $this->datum[$name];
    }
    public function __set($name, $value)
    {
        $this->datum[$name] = $value;
    }
    //
    protected static function getDbHandle()
    {
        return DB::getHandle();
    }
    //
    public function insert()
    {
        // DBハンドルの取得
        $dbh = $this::getDbHandle();

        // プリペアードステートメントの作成
        $key_array = array_keys($this->datum);
        // XXX 厳密には「識別子をエスケープしていない」ので注意
        // XXX いったん「PHPの構文」でひっかけてる
        $cols = implode(", ", $key_array);
        $awk = [];
        foreach ($key_array as $s) {
            $awk[] = ":{$s}";
        }
        $holders = implode(", ", $awk);
        //
        $sql = "INSERT INTO {$this::$table}({$cols}) VALUES({$holders})";
        $pre = $dbh->prepare($sql);

        // 値のバインド
        foreach ($key_array as $s) {
            $this::bindValue($pre, $s, $this->datum[$s]);
        }

        // SQLの実行(INSERT)
        $res = $pre->execute();
        return $res;
    }

    public static function find($v)
    {
        // プリペアードステートメントの作成
        $table = static::$table;
        $sql = "SELECT * FROM {$table}";
        $pre = static::makeWhere($sql, $v);

        // SQLの実行(SELECT)
        $res = $pre->execute();

        // データの入れ込み
        $row = $pre->fetch(\PDO::FETCH_ASSOC);
        if (empty($row)) {
            return null;
        }
        // else
        $ret = new static();
        foreach ($row as $k => $v) {
            $ret->$k = $v;
        }
        //
        return $ret;
    }
    // public static function findBy([key => val]);

    public function delete()
    {
        //
        $table = static::$table;
        $sql = "DELETE FROM {$table}";
        $pre = static::makeWhere($sql, $this->datum[static::$pk]);

        // SQLの実行(DELETE)
        $res = $pre->execute();
        return $res;
    }

    public function update()
    {
        //
        $table = static::$table;
        $sql = "UPDATE {$table} SET ";
        foreach ($this->datum as $k => $v) {
            if ($k !== $this::$pk) {
                $awk[] = "{$k}=:{$k}";
            }
        }
        $set = implode(", ", $awk);
        $sql .= $set;
        //
        $pre = static::makeWhere($sql, $this->datum[static::$pk]);
        foreach ($this->datum as $k => $v) {
            $this::bindValue($pre, $k, $v);
        }
        // SQLの実行(UPDATE)
        $res = $pre->execute();
        return $res;
    }

    // 内部用メソッド
    protected static function bindValue($pre, $h_name, $v)
    {
        if ((is_int($v)) || (is_float($v))) {
            $type = \PDO::PARAM_INT;
        } else {
            $type = \PDO::PARAM_STR;
        }
        $pre->bindValue(":{$h_name}", $v, $type);
    }

    protected static function makeWhere($sql, $v)
    {
        // DBハンドルの取得
        $dbh = static::getDbHandle();

        // プリペアードステートメントの作成
        $pk = static::$pk;
        $sql = $sql . " WHERE {$pk}=:{$pk}";
        $pre = $dbh->prepare($sql);
        // 値のバインド
        static::bindValue($pre, $pk, $v);

        return $pre;
    }

    //
    private $datum = [];
}
