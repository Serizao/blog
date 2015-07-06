{"title":"montage-dossier-distant"}
J'ai souvent besoin de partager des fichiers entre mes postes et mes VPS. J'ai donc cherché une solution me permettant de monter un dossier distant sur un poste local.
Le cahier des charges, ici, est de monter un fichier distant sur un dossier local grace à ssh.
Après recherche, sshfs correspond à mes besoins.

Pour ça, il me faut plusieurs choses : ssh et sshfs.

J'expliquais dans un autre article comment configurer ssh afin de prendre la main sur un poste.
Le but ici, est de pouvoir se connecter par un simple "ssh nom_d_hote".

Voici le lien vers l'article configuration de SSH.

À ce moment, je suis capable de me connecter grace au nom d'hôte du poste distant (pour l'exemple, on partira du principe que le nom d'hôte est "partage").

J'installe maintenant sshfs.

```bash
sudo apt install sshfs
```

Dès lors, je peux monter un répertoire distant.
Lorsque l'hôte n'est pas défini, la commande est celle-ci :

```bash
sshfs -p PORT USER@IP:REPERTOIRE_DISTANT POINT_DE_MONTAGE
```

Si l'hôte est créé :

```bash
sshfs partage:REPERTOIRE_DISTANT POINT_DE_MONTAGE
```

Dans mon cas, je synchronise le répertoire personnel distant avec mon /home/matthieu/sync_distant/ local.La commande est donc :

```bash
sshfs partage: sync_distant
```

Quand j'ai terminé les manipulations que j'avais à faire, je démonte le répertoire distant avec la commande fusermount :

```bash
fusermount -u sync_distant
```