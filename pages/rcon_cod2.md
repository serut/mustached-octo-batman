# Commandes RCon CoD 2 :

---

#### Maps

    mp_breakout
    mp_brecourt
    mp_burgundy
    mp_carentan
    mp_dawnville
    mp_decoy
    mp_downtown
    mp_farmhouse
    mp_leningrad
    mp_matmata
    mp_railyard
    mp_toujane
    mp_trainstation 

**/rcon sv_maprotation :** Définis la rotation et le mode des maps. Exemple : gametype dm map mp_brecourt map mp_toujane gametype tdm map mp_carentan

**/rcon sv_pure 1 :** Un serveur pure (1 par défaut) interdit l'utilisation de mods, autres que ceux présents sur le serveur.

**/rcon sv_hostname (nom du serveur) :** Commande rcon permettant de redéfinir le nom du serveur.

**/rcon g_password [password] :** Commande rcon permettant de définir le password d'entrée de serveur.

**/rcon sv_privatepassword :** Commande rcon permettant de définir le password concernant les slots réservés.

**/rcon rcon_password :** Commande rcon permettant de redéfinir le rcon password existant.

**/rcon g_gametype (sd, tdm, dm, hq, ctf) :** Définis le type de jeu

**/rcon sv_maxclients :** Commande rcon permettant de définir le nombre de joueurs maxi visibles.

**/rcon sv_privateclients :** Commande rcon permettant de définir le nombre de slots réservés.

**/rcon sv_maxrate :** Commande rcon permettant de la valeur de rate maximal.

**/rcon sv_kickbantime (60) :** Commande rcon permettant de bannir un joueur pendant un temps definit, dans notre exemple 60 secondes.

**/rcon sv_disableclientconsole :** Commande rcon permettant de désactive l'utilisation de la console par les joueurs

**/rcon sv_minping (0 par défaut) :** Définis le ping minimum pour rejoindre le serveur

**/rcon sv_maxping (0 par défaut) :** Définis le ping maximum pour rejoindre le serveur

**/rcon sv_reconnectlimit (3 par défaut) :** Définis le nombre de secondes pendant lesquelles un joueur doit attendre avant de se reconnecter

**/rcon sv_voice (0 par défaut) :** Commande rcon permettant d'activer ou non le alltalk sur le serveur.

**/rcon sv_voicequality (1 par défaut) :** Commande rcon permettant de définir la qualitée de la voix dans le jeu.

**/rcon sv_allowdownload (1 par défaut) :** Autorise les téléchargements (mods, maps)

**/rcon serverinfo :** Commande rcon permettant de récupérer des informations sur votre serveur.

**/rcon systeminfo :** Commande rcon permettant de récupérer des informations sur le système.

**/rcon status :** Commande rcon permettant de récuperer les informations concernant les joueurs présents sur le serveur.

**/rcon exec "nom du fichier" :** Commande rcon permettant d'exécuter un fichier cfg présent sur le serveur.

**/rcon writeconfig "nom du fichier" :** Commande rcon permettant de sauvegarder le fichier cfg.

**/rcon kick (nom du joueur) :** Commande rcon permettant de kiker un joueur par son pseudo.

**/rcon clientkick (id du joueur) :** Commande rcon permettant de kiker un joueur par son id.

**/rcon banUser (nom du joueur) :** Commande rcon permettant de kiker et de bannir un joueur définitivement par son nom.

**/rcon banClient (id) :** Commande rcon permettant de kiker et de bannir définitivement un joueur par son id.

**/rcon tempBanUser (nom du joueur) :** Commande rcon permettant de kiker et de bannir un joueur temporairement par son id.

**/rcon tempBanClient (id) :** Commande rcon permettant de kiker et de bannir un joueur temporairement par son id.

**/rcon unban (nom du joueur) :** Commande rcon permettant de debannir un joueur par son pseudo.

**/rcon tell (nom du joueur) :** Commande rcon permettant d'envoyer un message privé a un joueur.

**/rcon map (nom de la map):** Commande rcon permettant de faire un change map.

**/rcon map_rotate :** Commande rcon permettant de charger la carte suivante.

**/rcon map_restart :** Commande rcon permettant de relancer la map.

**/rcon fast_restart :** Commande rcon permettant de relancer une map sans la retelecharger entièrement.
