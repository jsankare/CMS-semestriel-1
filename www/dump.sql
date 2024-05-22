-- pgAdmin SQL Dump
-- version 5.2.1
-- https://www.pgadmin.org/
--
-- Hôte : localhost
-- Généré le : mar. 14 mai 2024 à 13:07
-- Version du serveur : 13
-- Version de PostgreSQL : 13

BEGIN;
SET TIME ZONE 'UTC';

--
-- Base de données : `esgi`
--

-- --------------------------------------------------------

--
-- Structure de la table `esgi_user`
--

DROP TABLE IF EXISTS public.esgi_user;
CREATE TABLE public.esgi_user (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status SMALLINT NOT NULL,
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS public.esgi_page;
CREATE TABLE public.esgi_page (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    content VARCHAR(255) NOT NULL,
--     creator_id INT NOT NULL,
--     CONSTRAINT fk_user FOREIGN KEY (creator_id) REFERENCES public.esgi_user(id),
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- On supprime les lignes concernant les index et AUTO_INCREMENT car déjà gérés par SERIAL

COMMIT;
