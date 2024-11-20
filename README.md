#Database

```
create table articles
(
    Id              int auto_increment
        primary key,
    Titre           varchar(50) null,
    Description     TEXT        null,
    DatePublication date        null,
    Auteur          varchar(50) null,
    ImageRepository           varchar(255) null,
    ImageFileName         varchar(255) null
);

create table users
(
    Id        int auto_increment
        primary key,
    Email     varchar(100) null,
    Password  varchar(255) null,
    NomPrenom varchar(100) null,
    Roles     json         null
);
```

#Create User
Générer un mot de passe en php
```
$hash = password_hash("azerty",PASSWORD_BCRYPT, ["cost" => 10]);
var_dump($hash);
```
Le hash pour azerty est : $2y$10$3P6bqx/asridbL9bgmpAAuutpuauAmBWbmeXnZ48s6C4LUD6YWeLq
Insérez ensuite l'utilisateur en base de données
Pour les roles mettre : ["Administrateur", "Redacteur"]