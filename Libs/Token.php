<?php

/**
 * 「推測困難なトークン」を作成するクラス
 */

class Token
{
    // 
    static public function make($len = 32)
    {
        return bin2hex(random_bytes($len));
    }
}
