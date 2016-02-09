echo Enregistrement de php.exe dans le chemin système + GIT

set PATH=%PATH%;C:\Users\Gaetan\Desktop\UwAmp\bin\php\php-5.5.15;C:\progra~2\Git\bin



echo Déplacement dans le dossier du projet microcms

cd C:\Users\gaetan\Desktop\UwAmp\www\MicroStoreMaster



rem echo Création de la commande composer.bat (raccourci de php composer.phar)

echo php ressources\composer.phar %%1 > composer.bat



cmd