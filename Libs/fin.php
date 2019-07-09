<?php
/*
 * 終了処理
 */

// バッファリング終了
ob_end_flush();


echo $twig->render($template_file_name, $template_data);
