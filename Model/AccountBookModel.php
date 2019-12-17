<?php
require_once(BASEPATH . "/Model/ModelBase.php");

class AccountBookModel extends ModelBase
{
    // テーブル名
    protected static $table = "account_book";
    // Primary Key
    protected static $pk = "account_book_id";

    //
    public static function getList()
    {
        // DBハンドルの取得
        $dbh = static::getDbHandle();

        // プリペアードステートメントの作成
        $sql = "SELECT * FROM account_book
                WHERE user_id=:user_id
                ORDER BY created_at DESC;";
        $pre = $dbh->prepare($sql);

        // プレースホルダにバインド
        $pre->bindValue(":user_id", $_SESSION["auth"]["user_id"], \PDO::PARAM_INT);

        // 実行
        $res = $pre->execute();
        //
        return $pre->fetchAll(\PDO::FETCH_ASSOC);
    }
}
