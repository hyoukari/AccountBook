<?php
require_once(BASEPATH . "/Model/ModelBase.php");

class AccountBookModel extends ModelBase
{
    // テーブル名
    protected static $table = "account_book";
    // Primary Key
    protected static $pk = "account_book_id";

    //
    public static function getList($y, $m)
    {
        // DBハンドルの取得
        $dbh = static::getDbHandle();

        // 軽くvalidate
        $m = (int) $m;
        $y = (int) $y;
        if (false === checkdate($m, 1, $y)) {
            return [];
        }

        // 日付範囲のfromとtoを作成
        $date_from = "{$y}-{$m}-1 00:00:00";
        $date_to = date("Y-m-d 23:59:59", strtotime("last day of this month", strtotime($date_from)));

        // プリペアードステートメントの作成
        $sql = "SELECT * FROM account_book
                WHERE user_id=:user_id AND created_at BETWEEN :date_from AND :date_to
                ORDER BY created_at DESC;";
        $pre = $dbh->prepare($sql);

        // プレースホルダにバインド
        $pre->bindValue(":user_id", $_SESSION["auth"]["user_id"], \PDO::PARAM_INT);
        $pre->bindValue(":date_from", $date_from, \PDO::PARAM_STR);
        $pre->bindValue(":date_to", $date_to, \PDO::PARAM_STR);

        // 実行
        $res = $pre->execute();
        //
        return $pre->fetchAll(\PDO::FETCH_ASSOC);
    }
}
