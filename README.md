# SteamAuth
A simple openid steam login class

# Dependencies
* OpenID (http://openid.net/), MIT License - part of the distribution

# Installation
Put your steam dev API key into the inc/api.php file

The directory "cache/" is required.

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
To use users steam info, such as their nickname on steam, you can check the steaminfo variable. Below is an example that will show the logged in users "personaname" on Steam. The name is fetched from a local cache of the users data which is fetched whenever the user logs in.

e.g.
```php
echo $SteamAuth->steaminfo['personaname'];
```
