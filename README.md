TeamSpeak3-ChannelDelBot
========================

TeamSpeak3 Channel Delete Bot. VeryEasy and VeryFast.


----------

Lachesis
------------

チャンネルの削除を素早く、正確に。  
このスクリプトは、TeamSpeak3向けのチャンネル監視Botです。  
cronに登録し、設定ファイルを少し書き換えるだけ。

導入手順  
1. DBにテーブルを作成  
2. ファイルを転送  
3. 設定ファイルを編集  
4. cronに登録


**MySQLのデータベース作成サンプル**  
テーブル名は設定ファイルで変更可能です。

    CREATE TABLE IF NOT EXISTS `list` (`channelID` int(11) NOT NULL, `channelName` text NOT NULL, `lastTime` bigint(20) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ALTER TABLE `list` ADD UNIQUE KEY `channelID` (`channelID`);

**cron サンプル**  
OSにより、phpのパス等が異なるので注意してください。

    */5	*	*	*	*	/usr/local/bin/php	/foo/var/ts3delete.cron.php	>/dev/null	2>&1

**アクセス制限サンプル**  
Bot本体にアクセス出来ないようにアクセス制限をしておくことをオススメします。

    # Apache ~2.2
    <Files ~ "^ts3delete\.cron\.php$">
    	Deny from all
    </Files>

    # Apache 2.4~
    <Files ~ "^ts3delete\.cron\.php$">
    	Require all denied
    </Files>


----------


License
-------

GPL v3 License  
please see LICENSE file.
