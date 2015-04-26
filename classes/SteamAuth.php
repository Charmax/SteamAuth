<?php

	class SteamAuth
	{

		public $errors = array();
		public $messages = array();
		private $loggedin = false;
		public $steaminfo = null;

		public function __construct($url)
		{

			session_start();

			if (isset($_GET['logout']))
			{
				$this->logout();
			}
			else if (isset($_SESSION['T2SteamAuth']))
			{
				$content = json_decode(file_get_contents("cache/{$_SESSION['T2SteamID64']}.json"));

				$this->steaminfo['steamid'] = $content->response->players[0]->steamid;
				$this->steaminfo['communityvisibilitystate'] = $content->response->players[0]->communityvisibilitystate;
				$this->steaminfo['profilestate'] = $content->response->players[0]->profilestate;
				$this->steaminfo['personaname'] = $content->response->players[0]->personaname;
				$this->steaminfo['lastlogoff'] = $content->response->players[0]->lastlogoff;
				$this->steaminfo['profileurl'] = $content->response->players[0]->profileurl;
				$this->steaminfo['avatar'] = $content->response->players[0]->avatar;
				$this->steaminfo['avatarmedium'] = $content->response->players[0]->avatarmedium;
				$this->steaminfo['avatarfull'] = $content->response->players[0]->avatarfull;
				$this->steaminfo['personastate'] = $content->response->players[0]->personastate;
				if (isset($content->response->players[0]->realname))
				{
					$this->steaminfo['realname'] = $content->response->players[0]->realname;
				}
				else
				{
					$this->steaminfo['realname'] = "Real name not given.";
				}
				$this->steaminfo['primaryclanid'] = $content->response->players[0]->primaryclanid;
				$this->steaminfo['timecreated'] = $content->response->players[0]->timecreated;

				$this->loggedin = true;

			}
			else
			{
				$this->login($url);
			}

		}

		private function login($url)
		{

			$openid = new LightOpenID("localhost");

			if (!$openid->mode)
			{
				if (isset($_GET['login']))
				{
					$openid->identity = "http://steamcommunity.com/openid";
					header("Location: {$openid->authUrl()}");
				}
			}
			else if ($openid->mode == "cancel")
			{
				$this->errors[] = "User has canceled authentication.";
			}
			else if (!isset($_SESSION['T2SteamAuth']))
			{
				$_SESSION['T2SteamAuth'] = $openid->validate() ? $openid->identity : null;
				$_SESSION['T2SteamID64'] = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION['T2SteamAuth']);

				if ($_SESSION['T2SteamAuth'] !== null)
				{
					$Steam64 = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION['T2SteamAuth']);
					$profile = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . API_KEY . "&steamids={$Steam64}");
					$buffer = fopen("cache/{$Steam64}.json", "w+");
					fwrite($buffer, $profile);
					fclose($buffer);
				}

				$this->loggedin = true;
				header("Location: {$url}");
			}
		}

		private function logout()
		{
			$_SESSION = array();
			session_destroy();
			$this->messages[] = "You have been logged out.";
			$this->loggedin = false;
		}

		public function isUserLoggedIn()
		{
			return $this->loggedin;
		}

	}


?>