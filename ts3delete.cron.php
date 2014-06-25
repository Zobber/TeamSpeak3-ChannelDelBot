<?php
	require_once(dirname(__FILE__).'/ts3admin.class.php');
	require_once(dirname(__FILE__).'/ts3delete.functions.php');
	require_once(dirname(__FILE__).'/ts3delete.settings.php');

	$ts3    = new ts3admin(settingsTS3::HostName, settingsTS3::QueryPort);
	$ts3del = new ts3delete();

	if ($ts3->getElement('success', $ts3->connect())) {
		$ts3->login(settingsTS3::UserName, settingsTS3::PassWord);
		$ts3->selectServer(settingsTS3::VoicePort);
		$ts3->setName(settingsTS3::BotName);

		$ts3del->db_host  = settingsSQL::HostName;
		$ts3del->db_user  = settingsSQL::UserName;
		$ts3del->db_pass  = settingsSQL::PassWord;
		$ts3del->db_name  = settingsSQL::DataBase;
		$ts3del->db_table = settingsSQL::Table;
		$ts3del->db_char  = settingsSQL::CharSet;
		$ts3del->ignore   = settingsTS3::ignoreChannelID();

		// ChannelCrawl
		$row = $ts3->getElement('data', $ts3->channelList());
		if (is_array($row)) {
			foreach ($row as $key => $value) {
				$ts3del->channel    = $value['channel_name'];
				$ts3del->channel_id = $value['cid'];

				if ($value['total_clients'] > 0) {
					if ($ts3del->getDbFoundChannel() && !$ts3del->channelIgnore()) {
						$ts3del->setDbDeleteChannel();
					}
				} else {
					if (!$ts3del->channelIsSpacer() && !$ts3del->getDbFoundChannel() && !$ts3del->channelIgnore()) {
						$ts3del->setDbAddChannel();
					}
				}
			}
		}

		// ChannelDelete
		$row2 = $ts3del->getDbAllData();
		if (is_array($row2)) {
			foreach ($row2 as $key => $value) {
				if ((time() - $value['lastTime']) >= settingsTS3::DeleteTime && !$ts3del->channelIgnore()) {
					$ts3del->channel_id = $value['channelID'];
					$ts3del->setDbDeleteChannel();
					$ts3->channelDelete($value['channelID'], 0);
				}
			}
		}
	}