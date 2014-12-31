PHP RCon
version 2.40

Requirements:
 Server side: Apache webserver with PHP5 support
 Client side: Javascript, AJAX and cookies enabled browser (Opera, Chrome, Firefox, IE7+)


This is a PHP interface for remote console administration to:
- Call Of Duty 1
- Call Of Duty: United Offensive
- Call Of Duty 2
- Call Of Duty 4: Modern Warfare
- Call Of Duty 5: World At War
- Call Of Duty 6: Modern Warfare 2 (not possible to use until there is rcon)
- Call Of Duty 7: Black Ops (very limited on ranked, no changing maps, etc.)

Those games share the same rcon protocol with Quake3, so many others may be compatible. Just try it.

What does it do?
It gives you a list of players currently on the server along with colors - rcon status. You may then send any command to the game, including messages to all, private messages, map changes, map restarting, and any other rcon command. Suggests will guide you with a hint on command and variable names and their default values. Next to all players there are links for 'one-click kick' and 'one-click message'. Screenshots taken by PunkBuster on the server can also be retrieved, remotely and securely.

PHP Rcon works everywhere, even if you are sitting at a network with blocked UDP packets - the webserver does the job. That's why you would need to find a webhosting, that would allow you to use UDP connections made by PHP. I recommend to put it on the same machine the gameserver runs on.



Installation:
- Unpack the directory and upload it to your webserver.
- Download and extract http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz ; upload GeoIP.dat to the main folder.
- Edit config.inc.php - general settings - language, country code resolution, custom commands...
- Edit servers/myserver.inc.php - enter ip, port and rcon password of target gameserver
- Edit users.inc.php - make a list of allowed users along with their passwords and rights
- Add your new language - if you translate the tool to a new language, send your work back to me
- Make the directory writeable to webserver if you use logging or changing passwords.

Open your browser, enter correct URL, login and have fun administering your game.



Adding more gameservers:
Edit servers.inc.php - add new server on each line, the first one on the list is default. Server string syntax is '(game) (server_name) (Friendly name)', where game is 'cod1', 'cod1uo', 'cod2', 'cod4' or 'cod5', server_name is name of configuration file located in servers/ (eg. myserver -> servers/myserver.inc.php), Friendly name is the one you see in combo-box selecting other servers (and logging uses it as well).
Create configuration file in servers/ subdirectory. Enter at least IP, port and rcon password, other configuration may be used from cascaded configuration files.



Understanding cascaded configuration files:
All settings are defined in four levels, any setting defined in more specific configuration files adds/overwrites others.
- Lowest priority is defined by general config (config.inc.php)
- Lower priority is defined by access config (config.access.*.inc.php)
- Medium are defined as common for games (games/cod2.inc.php)
- Highest are in server specific config (servers/myserver.inc.php)
Eg. use Servers to define gameserver IP and port, common Games to define maps you might have added to all your gameservers of each game, Access to enable ban buttons or other preset only for users with particular access level, and Config to set language and resolving IP to country codes for the whole application.

To add an entry to array, use $array_name[] = 'value';
To clear a whole array, use unset($array_name); and then you can begin adding new items. Some arrays must be non-empty (map list, gametype list, ...).



User rights:
Users are divided into two groups - Full and Limited access. Limited ones can execute only commands to get playerlist and gametype, and all commands from $commands_enabled[]. Full access admins can execute all commands except those in $commands_disabled[]. Those variables can be set separately in different scopes.
Limited access users can also have different preset configuration (config.access.full.inc.php / config.access.limited.inc.php), so you can enable showing eg. Ban button only for users with full access.
By default, nobody can read RCon password or squeeze it trough the var dump (game specific).





History:
2.40
Added: Russian language (thx. Anarhist & Koosh87).
Fixed: Serious security issue.
Added: Call of Duty: Black Ops support - gametype list, maplist (thx. Anarhist), new map screenshots, dvarlist.
Changed: AJAX communication protocol, uses jQuery exclusively (increased compatibility).
Changed: RCON communication protocol, may be faster, but needs testing on older games, works very fast with COD:BO. $server_buffer_results and $server_extra_wait are deprecated.
Added: Game name aliases (codbo=cod7, codmw=cod4, codwaw=cod5, codmw2=cod6), use whatever you like.
Fixed: Suggest returns focus to input box when selected.
Fixed: Response messages now return OK in COD:BO as it should.
Added: %a in custom commands can be used, admin's name will be used.
Updated: French translation (thx. Dh0mp5eur).

2.351
Fixed: Output of log was not html escaped (thx. Moustache).

2.35
Added: It is now possible to use %m in $custom_cmd[], popping up a dialog window for user input - non-user-specific command.

2.34
Fixed: Screenshot related problems (thx. Moustache). Limited rights users can also see screenshots if they are allowed to make them ($commands_enabled[] = 'pb_sv_getss';).
Fixed: Colored nicknames username detection (different length based on number of colors).
Added: Command can use text only, icons or both. Now $custom_cmd in addition to $custom_cmds is compatible with this syntax, see config.
Fixed: Custom commands with icons in playerlist were line-wrapped.
Added: Custom commands in playerlist ($custom_cmds[]) might be supplied with a javascript (starting with *), see config.
Added: Suggest window gets resized horizontally to match the input box above.

2.33
Added: Screeshot explorer (local and remote).
Changed: CSS was split in two, one site-specific (may be replaced by site-specific design) and one directly involving PHP Rcon elements.
Fixed: Finnish translation was lost in another source.

2.32
Added: Crystal project icons used instead of several links (replaced by jQuery on the fly, can be turned off).
Fixed: code cleaning, moving hardcoded stuff to external css.
Added: GeoIP.dat included with the package, default config resolves countries with internal library.
Changed: Many javascript scripts were replaced by typically only one jQuery line, some elements are now faded slowly.
Added: Country codes are now located in a textfile with their full name alternative and automatically resolved to the mouse hover title.
Added: Country code is now logged with other userinfo, large part of the code had to be moved.
Added: Inline log, re-loaded using ajax everytime the box is opened, automatically scrolled to the bottom.

2.31
Fixed: Corrupted character was not replaced correctly.
Fixed: Headers already sent warning message on login (re-loading user-specific list of servers).
Fixed: The raw UDP command fix was lost in another source.
Updated: Dutch translation (thx. Moustache).

2.3 - new translated strings needed
Fixed: Multiple server configuration was broken by separating scripts from main script.
Updated: JQuery library to 1.4.3pre.
Added: Two variables that could be filled with HTML to use selected map and gametype. New links can be added next to map/gtype select boxes - javascript is used to fill a specific game mod variable with selected map. We use it along with Kafemlynek mod to choose next map forced in upcoming vote menu.
Added: Finnish translation (thx. TunTuri).
Changed: Raw UDP command prefix changed - removed "x\02" as it probably was a bug in all COD games and was fixed in COD5 (WaW) patch 1.5 (thx. Brit_FK, Jimbo). Please report whether this version works on older games.
Changed: Limited access users have most controls hidden.
Added: Checking for available functions in PHP configuration.
Added: Users can be limited to their own servers, they can have more than one, the server config filename must begin with the user's name and $match_user_and_server must be enabled in config.inc.php.
Fixed: Deprecated ereg functions were replaced by preg alternatives (PHP 5.3+).
Added: Log now contains extra data, username and IP info on kicked player. All $custom_cmds (including the command 'tell') also include this data, fully compatible with punkbuster's ID offset.

2.2
Added: Limited user rights, see above.
Added: New error message for the case of invalid Rcon password.
Added: Users can set their own language, other than interface default.
Fixed: Security bugs.
Changed: Log is now accessible for Full access users only.
Changed: Some variables were changed/deleted, you may consider upgrading with data based on attached config files.
Added: Two new config file variants added. Either full or limited access can have different preset buttons, etc.
Added: .htaccess file to configure basic webserver settings (php flag register_globals must be off!)
Changed: Header and footer of the page HTML code is now extracted to separate files, better for incorporating into other systems and menus. The same header is also used in login and userconfig pages.
Changed: Updated link to GeoIP country codes.
Changed: 10k of javascript was extracted from index into separate file.
Fixed: The Colorize results checkbox will now not wrap if the window is smaller, added #phprcon container for more precise styling.
Fixed: If an error occurs, an error message pops up in the results. Now if playerlist updates successfully, this error message is deleted.
Changed: Logfile shares the same header and footer, data is in an extra file, prevented reading from.

2.1
Updated: Spanish translation (thx. Hades).
Fixed: A minor change should take language specific variables (weapon names) in effect - if anyone decides to translate $lang['scr_weapon_allowclaymores'] etc.
Added: New COD4 post-1.6-patch maps and preview screenshots (thx. PietroTC).
Updated: Dutch translation (thx. HippoTraxius).
Updated: Polish translation (thx. JaReK).
Fixed: A minor bug causing an error to pop up if an invalid game name is set and hence no maps are set.
Added: COD5 World at War support (thx. TaRTeSSio for config file to polish). New map screenshots, new command and variable lists.
Added: Montenegro flag (ME).

2.0
Added: Polish translation (thx. JaReK & HanSolo).
Added: Serbian translation (thx. Fanatic).
Fixed: German translation (thx. Scratch).
Added: The button to Change the gametype now (thx. Scratch).
Fixed: Minor bug in javascript.
Added: Call Of Duty 1 and Call Of Duty: United Offensive support. All maps, map screenshots, gametypes, weapons and names of rcon password variable imported.
Changed: Configuration file with general games settings (maplist.inc.php) was split to individual config files. Default maps and configuration are now located inside games/*.inc.php depending on the game version. Also all references to maplist.inc.php were removed as configuration is loaded anyway via init.inc.php. This might mean slight speed up.
Added: A new variable $disable_whisper was added to cod4 config file. It is set to true for this game. If anyone finds a way to whisper to players (command tell), you may want to change it.
Added: Spanish translation (thx. TaRTeSSio).
Added: Serbian flag - RS.png.
Added: Admins can change their password. Then it is stored safely encrypted in users.inc.php. New variables to be set: $changepass_enable - enable or disable changing the passwords; $changepass_minchars - minimum number of characters for new passwords; and $pw_salt - unique password encryption parameter. Translators, please update your work.
Fixed: If a particular country flag has no image present in folder flags/, display it in text form only.
Fixed: A serious security leak could let unauthorized users control someone else's gameserver in particular case. Everyone using more than one instance of PHP RCon on the same webserver (different configuration and users in different directories) should consider updating immediately. In case the server or browser decides to ignore this fix, another security checking catches the attempt and logs the user out. Then the user may still control more instances, but from different browsers. Server admins can also isolate the session data to individual subdirectories for even more increased security (see validate.inc.php). Thanks goes to Fanatic.
Added: Suggesting commands or variables via Ajax. This new feature displays all default commands and variables along with their default values to the right when typing first letters of any command. This behavior can be easily changed by setting $suggest_partial to true. Then it searches all commands containing your query. Of course, you can choose any of the suggestions by selecting it and modify before sending. If anyone finds this feature bothering, he can turn it off entirely by disabling $suggest_enable. I also took care of waiting for one response before sending another - for those of us, who write at over 230 chars per minute :) Suggests work fine on Opera and IE7, IE6 has some problems with styles.
Fixed: Falsely disabled COD4 command "tell". I tried to use command tell directly in game, but only an error (Unknown function TELL) popped up. Unfortunately I never tried to use it via rcon, which works perfectly. Maybe someone misused it in team games to tell things to enemies, who knows.
Fixed: While importing lists of commands and variables from COD1 and COD1UO linux servers, I found out, that there wasn't the bug, that bothered us for so long. Should any response from server be longer than 1024 chars, the header repeated and overlapped over one character of received response. So now the fix is enabled only for COD2 and COD4.
Fixed: If gameserver is unavailable and returns no reply at all, not even the UDP header, the result box was empty. Now it correctly displays, that the gameserver is offline or changing map - language specific error message.
Added: A few COD4 weapons to the quick setting dialog at the bottom.
Added: Maximum script execution time can be changed in the file init.inc.php.
Changed: Function set_time_limit in init.inc.php is commented out by default, because some of us run their webserver in safe mode.
Updated: German translation (thx. Scratch).
Updated: Italian translation (thx. PietroTC).
Added: Slovak translation (thx. Eddie).

1.9
Added: Logfile now has a PHP header, that protects it against unauthorized access - and supports UTF-8 encoding. The logfile is created automatically and header is copied from a template.
Added: Rcon password protection. If anyone tries to read or write that variable, he gets warned and the attempt is logged.
Added: GeoIP PHP library. No need to use external system command to resolve IPs to country codes. Thanks to Hind-d for the idea. Compatibility massively increased.
Added: GoogleCode library: jQuery Hotkey plugin. Hotkeys now work OK, they don't interfere with text input anymore.
Added: Hotkeys: R refreshes playerlist; S starts/stops refresh timer; M shows/hides map preview; G gets gametype; X deletes last server result message.
Fixed: All server results now get enclosed into a table with Result caption and X button to delete them. Enclosure is done by JavaScript, less data is transferred between server and admin's browser.
Added: Custom commands $custom_cmds can contain variable %m. If they do, an input query for a message pops up. This can be used for PB kicking with reason. Idea by Max.
Added: French translation, thanks to Max.
Added: Div tags enclose specific parts of the tool. Design can be changed more using styles. Idea by Max.
Added: Login page displays a list of Rcon servers for direct access. Idea by Max.
Changed: JavaScript PHP tag endings, function names. Increases code readability.
Added: Captions or hotkey hints were added to almost all buttons and custom commands.
Added: HTTP errors now have a link to Wikipedia for more info on the error code.
Changed: Replacing of corrupted character in long responses from gameserver is now simplified, and the background color at the position is changed.
Changed: Getting g_gametype is no longer logged.
Fixed: A serious bug preventing use of more gameservers fixed. Thanks HPH Janni.
Added: New map Winter Crash for COD4 was added by game patch v1.4.
Added: Norwegian translation (thx. HPH Janni)
Added: Dutch translation (thx. HippoTraxius)
Fixed: A bug causing login page to display always in English was fixed. (thx. HippoTraxius)
Updated: Norwegian translation.
Changed: Languages are in separate files. That ensures better management of specific language updates.
Added: Hungarian translation (thx. Marcelldzso)

1.8
Changed: Page charset encoding is now set to UTF-8 (better translation support for all languages). Forced UTF-8 by sending HTTP header.
Added: Multiple gameserver support - combo-box to change server appears in title only if there are more servers configured.
Added: COD4 support - whispering to players don't work AFAIK (server returns error Unknown function TELL), so I removed the Whisper buttons. New COD4 screenshots of maps and new gametypes imported. Communication on UDP layer stays the same.
Added: Logging of admin commands - watch your admins closely and shoot bad ones.
Added: Cascaded configuration (see help above).
Added: A button to clear last result.
Added: Session path can be defined in validate.inc.php - just uncomment and change the path. Some players were unable to find php.ini, so this is ready just for them.

1.7
Added: German translation, thanks to Papacheata.

1.6e
Fixed: CSS was made compatible with Opera beta 9.50 codename Kestrel.
Changed: background colors of playerlist is now done trough style classes instead of bgcolors.
Added: Support for command 'geoip-lookup IP' returning only country code added. For configuration, see config.inc.php
Fixed: Uninitialized variable caused broken javascript in Firefox.
Fixed: Uninitialized variable error ocurred when retrieving background color for result.
Changed: Graphical working indicator.
Added: Shortcut key R for refreshing the playerlist.
Fixed: Minor fixes in javascript.
Fixed: If result is empty, the output table is hidden.

1.5c
Fixed: A javascript glitch caused some browsers not to work.
Fixed: When data for playerlist and other commands are waited for at the same time, they are assigned to the right fields.
Fixed: When waiting for both data at the same time, and one of them finishes, the working indicator doesn't disappear. It is there always, when you're supposed to get data.
Fixed: If you receive an HTTP error, it is displayed along with text of that error.
Added: AJAX interface (thx. Nazgul for idea) for refreshing only the important parts of page. It has speeded the complete process a lot. Only one piece of code communicates with the server, easier for people to change.
Added: A "working indicator" notifying the user, that the page is waiting for new data. While waiting, you can work with old ones, unlike the old version, there you had to wait for some time without any playerlist to look at.
Added: An error message (if no data are received).
Changed: Almost all forms were removed, they were replaced by javascripts, input-guarded on the client side.
Added: Country codes are now implemeted along with national flag images. See config file for settings.
Added: Clicking any command with Shift button pressed puts the raw code to command line and doesn't send it. This can be used for changing preset commands before exec. 
Fixed: By splitting the main script in two I have caused not to auto-choose current map in map change drop-down box. The default empty line was replaced by Restart command.
Removed: The button to change gametype instantly and those ones to bath disable or enable more weapons - snipers, rifles (executed 2 or more commands in a row) would make things much more complicated. For instant gametype change use Change after map and then restart the map by button below.
Changed: The default refresh time is now 30s (you can now work while refreshing).
Added: More custom commands on one line (for syntax see config file).

1.4b
Added: Italian translation, thanks to Nazgul.
Added: Custom favorite commands (editable in config.inc.php). Waiting a while pointing the cursor at the friendly name of command displays the actual command as hint label.
Added: Custom commands next to all players (config file, hint labels, editable ID offset for PB commands).
Changed: Timeout values, extra-wait failsafe mode, buffer sizes (when problems with full player listing ocurred) and language settings are now editable from within config.inc.php.
Changed: Settings menu is hidden by default, it is displayed (and more php code processed) after clicking one link. Previously, it was shown/hidden by javascript.
Fixed: Arrays are now duplicated when cycling (PHP4 compatible).
Fixed: Minor HTML glitches.
Added: Codepage of the page is now changeable with language.
Added: A map picture is shown via javascript after clicking the map name. To hide it, move the mouse away, or click the picture.
Added: One button to get current gametype was added.

1.3
Changed: Refreshing of the window is now done by javascript, which is stopped/resumed manually or by clicking anywhere to the bottom table (when you start typing a long command or message to send, it is already paused). If an dialog box for message is open and then cancelled, the countdown is resumed right where it has been paused.
Added: The countdown to page refreshing was added.
Added: All weapons are now possible to disable/enable or get their status (the "?" buttons), they are hidden as default, till you click Settings link.
Added: I made a password box for changing public password. It is also hidden by default.
Added: An empty page ready for quick links you may have needed was added. I use it for fast switch to my iptables banning system.

1.2
Fixed: I changed the beginning php tags from short to proper <?php.
Fixed: If return value exceeds limited number of bytes and colorizing is turned off, the background of the character is marked as yellow for easy noticing.
Fixed: The joining substring was changed from national sign of caron to chr(255), it could help to more compatibility.

1.1
Added: A simple login system.
Added: Maps, gametypes changing via dropdown box.
Added: Buttons for changing game settings - Sniper rifles, Shotgun, Smoke grenades.
Added: Javascript and buttons to whisper to any player / say something loud.
Fixed: you can press F5 to refresh the window with list safely - no commands will be re-sent, just the last result and last sent command will be displayed again.
Changed: Kick buttons were changed to javascript links.

1.0
First version, hooray, the communication with gameserver works, now we can begin working on GUI!


Use it and modify it freely, just include my name, as I spent a lot of time developing this tool.

Ashus
php-rcon -at- ashus -dot- net
Updates: http://ashus.ashus.net/viewtopic.php?f=4&t=27
Other applications made by me are here: http://ashus.ashus.net