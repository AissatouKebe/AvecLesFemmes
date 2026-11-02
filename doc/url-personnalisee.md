# URL personnalisée

Le projet est servi sur http://kebeaissatou.test:8000 au lieu de localhost.

## Mise en place (une seule fois)

PowerShell en administrateur :

    Add-Content -Path C:\Windows\System32\drivers\etc\hosts -Value "127.0.0.1 kebeaissatou.test"
    ipconfig /flushdns

## Lancer le site

    symfony server:start -d

Puis ouvrir http://kebeaissatou.test:8000

## Pourquoi .test

Le suffixe .local est réservé par Windows à un autre système de noms (mDNS) et se résout mal.
.test est réservé aux tests et ne pose pas de problème.