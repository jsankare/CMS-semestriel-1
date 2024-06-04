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

DROP TABLE IF EXISTS public.esgi_user CASCADE;
CREATE TABLE public.esgi_user (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status SMALLINT NOT NULL,
    validation_code VARCHAR(32),
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS public.esgi_page CASCADE;
CREATE TABLE public.esgi_page (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    content VARCHAR NOT NULL,
    creator_id INT NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (creator_id) REFERENCES public.esgi_user(id),
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS public.esgi_article CASCADE;
CREATE TABLE public.esgi_article (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(50),
    content VARCHAR NOT NULL,
    creator_id SMALLINT NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (creator_id) REFERENCES public.esgi_user(id),
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


DROP TABLE IF EXISTS public.esgi_comment CASCADE;
DROP TYPE IF EXISTS comment_status CASCADE;

-- Créer le type enum
CREATE TYPE comment_status AS ENUM ('pending', 'approved', 'rejected');
CREATE TABLE esgi_comment (
    id SERIAL PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status comment_status DEFAULT 'pending',
    FOREIGN KEY (article_id) REFERENCES public.esgi_article(id),
    FOREIGN KEY (user_id) REFERENCES public.esgi_user(id)
);


COMMIT;
