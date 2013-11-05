plume
=====

Wiki expérimental...

Installation
------------

Vous pouvez installer le logiciel sur votre serveur via git (recommencé) ou, si vous n'avez qu'un simple hébergement, en téléchargeant l'archive.

#### Installation via git

1. Installez git
`sudo apt-get install git-core`
2. Placez vous dans le reprtoire web de votre serveur
`cd /var/www`
3. Installez plume via git
`git clone https://github.com/ldleman/plume.git`
4. Réglez les permission requises par plume
`sudo chown -R www-data:www-data /var/www/plume`

#### Installation via téléchargement

1. Téléchargez [la dernière version](https://github.com/ldleman/plume/archive/master.zip) de l'archive de plume
2. Décompressez l'archive et envoyez la dans votre répertoire web
3. Réglez les permissions requises par plume (chmod 755 sur tous le répertoire OU chown www-data si vous avez accès à cette commande)

Configuration
------------

Pensez à changer le mot de passe administrateur dans la page common.php par mesure de sécurité

