# Commandes RCon UT :

---

#### Admin Commands :

---

###### Logging in and out  
Log in as administrator **adminlogin login**  
Log out **adminlogout**  
  
###### Adding and removing actors 
Note: The following commands may work without the admin prefix. This does not hold for rebooting the server ;)  

Add bots **admin addbots number**  
Spawn actor **admin summon class name**  
Remove all monsters **admin killpawns**  
Remove all bots **admin killall Bot**  
Remove redeemer **admin killall WarheadLauncher**  
Remove damage amplifier **admin killall UDamage**  
Remove shield belt **admin killall ut_ShieldBelt**  
Remove invisibility **admin killall ut_Invisibility**  
Remove armor **admin killall Armor2**  
Remove thigh pads **admin killall ThighPads**  
Remove jumpboots **admin killall ut_Jumpboots**  
Kick player **admin kick player name**  
Kickban player **admin kickban player name**  
  
###### Server control  
Reboot the server **admin quit or admin exit**  
Toggle game pause **admin pause or press the pause button**  
Switch map **admin switchlevel map name**  
Change gametype **admin servertravel map name?Game=gametype**  
Change mutator **admin servertravel map name?Mutator=mutator**  
Change both **admin servertravel map name?Game=gametype?Mutator=mutator**  
Note: There is no space between the map name and the question mark, and between the gametype and its corresponding question mark!**  
Restart level **admin servertravel ?restart**  
  
###### Game control 
Note: To retrieve the current value, replace "set" with "get" and remove any trailing parameters. A servertravel is required for changes to take effect with commands containing a gametype.  

Set game password **admin set Engine.GameInfo GamePassword password**  
Reset game password **admin set Engine.GameInfo GamePassword**  
Set time limit **admin set gametype TimeLimit number**  
Set capture limit **admin set gametype GoalTeamScore number**  
Set frag limit **admin set gametype FragLimit number**  
Set minimum players **admin set gametype MinPlayers number**  
Add bots up to minimum players (servertravel!) **admin set UnrealGame.UnrealMPGameInfo MinPlayers number**  
Set maximum players **admin set Engine.GameInfo MaxPlayers number**  
Set maximum spectators **admin set Engine.GameInfo MaxSpectators number**  
Set maximum team size **admin set gametype MaxTeamSize number**  
Set air control **admin set gametype AirControl number**  
Set game speed **admin set Engine.GameInfo GameSpeed number**  
Toggle mute spectators **admin set Engine.GameInfo bMuteSpectators True/False**  
Toggle force respawn **admin set gametype bForceRespawn True/False**  
Toggle tournament mode **admin set gametype bTournament True/False**  
Set bot strength **admin set Botpack.ChallengeBotInfo Difficulty 0-7**  
Toggle translocator **admin set gametype bUseTranslocator True/False**  
Toggle weaponstay **admin set gametype bMultiWeaponStay True/False**  
Set friendly fire scale **admin set gametype FriendlyFireScale 0-100**  
Toggle cheats **admin set Engine.GameInfo bNoCheating True/False**  
Add teams (TDM, DOM) **admin set gametype MaxTeams number**  
Toggle webadmin **admin set UWeb.WebServer bEnabled True/False**  
Toggle team balancing **admin set gametype bPlayersBalanceTeams True/False**  
Full screen message **say #message**  
  
###### Server appearance  
Set server name **admin set Engine.GameReplicationInfo ServerName name**  
Set server short name **admin set Engine.GameReplicationInfo ShortName name**  
Set server MOTD **admin set Engine.GameReplicationInfo MOTDLine1 sentence**  
Set server MOTD **admin set Engine.GameReplicationInfo MOTDLine2 sentence**  
Set server MOTD **admin set Engine.GameReplicationInfo MOTDLine3 sentence**  
Set server MOTD **admin set Engine.GameReplicationInfo MOTDLine4 sentence**  
Set admin name **admin set Engine.GameReplicationInfo AdminName name**  
Set admin email **admin set Engine.GameReplicationInfo AdminEmail email**  
Set tickrate **admin set IPDrv.TCPNetDriver NetServerMaxTickrate number**  
  
###### UTPure related  
Disable UTPure **mutate DisablePure**  
Enable UTPure **mutate EnablePure**  
Toggle NoLockdown (UTPure) **admin set UTPure bNoLockdown True/False**  
Enable hitsounds (UTPure) **mutate EnableHitSounds**  
Disable hitsounds (UTPure) **mutate DisableHitSounds**  
  
###### No admin required  
Change nickname **setname name**  
Disconnect **disconnect**  
Reconnect **reconnect**  
Quit **quit or exit**  
Take a screenshot **shot**  
Connect to a server **open server address[:server port]**  
Toggle framerate counter **timedemo 1/0**  
Set netspeed **netspeed value**  
Set field of view **fov value**  
Open vote menu (BDB) **mutate BDBMapvote Votemenu**  
Show tickrate (UTPure) **ShowTickrate**  
Switch team (UTPure) **NextTeam**  
Show cheat info (UTPure) **CheatInfo**  

#### Gametypes  
  
Capture The Flag (CTF) **Botpack.CTFGame**  
DeathMatch (DM) **Botpack.DeathMatchPlus**  
Team DeathMatch (TDM) **Botpack.TeamGamePlus**  
Last Man Standing (LMS) **Botpack.LastManStanding**  
Domination (DOM) **Botpack.Domination**  
Assault (AS) **Botpack.Assault**  
  
#### Maps  
  
###### Standard  
Eternal Caves **CTF-Eternalcave.unr**  
Coret Facility **CTF-Coret.unr**  
Dreary Outpost **CTF-Dreary.unr**  
The Last Command **CTF-Command.unr**  
Facing Worlds **CTF-Face.unr**  
The Iron Gauntlet **CTF-Gauntlet.unr**  
LavaGiant **CTF-Lavagiant.unr**  
Niven Experimental Lab **CTF-Niven.unr**  
November Sub Pen **CTF-November.unr**  
  
###### Other  
Tombs of the Aztec **CTF-Aztec.unr**  
Temple of Beatitude **CTF-Beatitude.unr**  
Cybrosis][ **CTF-Cybrosis][.unr**  
Darji Outpost #16-A **CTF-Darji16.unr**  
EpicBoy **CTF-Epicboy.unr**  
Facing Worlds Special Edition **CTF-Face-SE.unr**  
Hydro Bases **CTF-Hydro16.unr**  
Noxion Base **CTF-Noxion16.unr**  
Ratchet **CTF-Ratchet.unr**  
Scandinavium **CTF-Scandinavium.unr**  