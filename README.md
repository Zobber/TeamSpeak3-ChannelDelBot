TeamSpeak3-ChannelDelBot
========================

TeamSpeak3 Channel Delete Bot. VeryEasy and VeryFast.


----------

Lachesis
------------

チャンネルの削除を素早く、正確に。  
このスクリプトは、TeamSpeak3向けのチャンネル監視Botです。  
cronに登録し、設定ファイルを少し書き換えるだけ。

MySQLのデータベース作成サンプルクエリ。  
テーブル名は設定ファイルで変更可能です。

    CREATE TABLE IF NOT EXISTS `list` (`channelID` int(11) NOT NULL, `channelName` text NOT NULL, `lastTime` bigint(20) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ALTER TABLE `list` ADD UNIQUE KEY `channelID` (`channelID`);

導入手順  
1. DBにテーブルを作成  
2. ファイルを転送  
3. 設定ファイルを編集  
4. cronに登録

License
-------

GPL v3 License  
please see LICENSE file.