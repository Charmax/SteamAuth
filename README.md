# SteamAuth
A simple openid steam login class

# Installation:
Put your steam dev API key into the inc/api.php file

# How to use
Create an object of the SteamAuth class wherever you want users to be authenticated
e.g.
```php
require_once("classes/SteamAuth.php");
$SteamAuth = new SteamAuth("index.php");
```
To check if a user is logged in, check the isUserLoggedIn() boolean from the SteamAuth object.
e.g.
```php
$SteamAuth = new SteamAuth("index.php");
if ($SteamAuth->isUserLoggedIn())
{
	// user is logged in
}
else
{
	// user is not logged in
}
```
