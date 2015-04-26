<?php
	require_once("inc/api.php");
	require_once("inc/openid.php");
	require_once("classes/SteamAuth.php");

	$SteamAuth = new SteamAuth("index.php");

	if ($SteamAuth->isUserLoggedIn())
	{
		include("views/logged_in.php");
	}
	else
	{
		include("views/logged_out.php");
	}
?>