<?php
	class ts3delete
	{
		public $channel;
		public $channel_id;
		public $db_host;
		public $db_user;
		public $db_pass;
		public $db_name;
		public $db_table;
		public $db_char;
		public $ignore;

		public function channelIsSpacer()
		{
			return (preg_match('/\[[^\]]*spacer[^\]]*\]/', $this->channel)) ? true : false;
		}

		public function channelIgnore()
		{
			return in_array($this->channel_id, $this->ignore);
		}

		private function PDOConnect()
		{
			return 'mysql:host='.$this->db_host.'; dbname='.$this->db_name.'; charset='.$this->db_char.';';
		}

		public function getDbFoundChannel()
		{
			$pdo = new PDO($this->PDOConnect(), $this->db_user, $this->db_pass);
			$sth = $pdo->prepare('SELECT * FROM `'.$this->db_table.'` WHERE channelID = :id');
			$sth->bindValue(':id', $this->channel_id, PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			$pdo = null;
			return ($row == false) ? false : true;
		}

		public function getDbAllData()
		{
			$pdo = new PDO($this->PDOConnect(), $this->db_user, $this->db_pass);
			$sth = $pdo->query('SELECT * FROM `'.$this->db_table.'`');
			$row = $sth->fetchAll(PDO::FETCH_ASSOC);
			$pdo = null;
			return $row;
		}

		public function setDbAddChannel()
		{
			$pdo = new PDO($this->PDOConnect(), $this->db_user, $this->db_pass);
			$sth = $pdo->prepare('INSERT INTO `'.$this->db_table.'` (channelID, channelName, lastTime) VALUES (:id, :name, :time)');
			$sth->bindValue(':id', $this->channel_id, PDO::PARAM_INT);
			$sth->bindValue(':name', $this->channel, PDO::PARAM_INT);
			$sth->bindValue(':time', time(), PDO::PARAM_INT);
			$sth = $sth->execute();
			$pdo = null;
			return $sth;
		}

		public function setDbDeleteChannel()
		{
			$pdo = new PDO($this->PDOConnect(), $this->db_user, $this->db_pass);
			$sth = $pdo->prepare('DELETE FROM `'.$this->db_table.'` WHERE channelID = :id');
			$sth->bindValue(':id', $this->channel_id, PDO::PARAM_INT);
			$sth = $sth->execute();
			$pdo = null;
			return $sth;
		}
	}