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

-- Table esgi_user
DROP TABLE IF EXISTS public.esgi_user CASCADE;
CREATE TABLE public.esgi_user (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status SMALLINT NOT NULL,
    validation_code VARCHAR(32),
    reset_token VARCHAR(32),
    token_expiration TIMESTAMP,
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table esgi_page
DROP TABLE IF EXISTS public.esgi_page CASCADE;
CREATE TABLE public.esgi_page (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    creator_id INT NOT NULL,
    slug VARCHAR(20) UNIQUE NOT NULL,
    is_main BOOLEAN DEFAULT FALSE,
    CONSTRAINT fk_user FOREIGN KEY (creator_id) REFERENCES public.esgi_user(id),
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table esgi_article
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

-- Table esgi_comment
DROP TABLE IF EXISTS public.esgi_comment CASCADE;
DROP TYPE IF EXISTS comment_status CASCADE;
CREATE TABLE esgi_comment (
    id SERIAL PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    status SMALLINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES public.esgi_article(id),
    FOREIGN KEY (user_id) REFERENCES public.esgi_user(id)
);

-- Table esgi_image
DROP TABLE IF EXISTS public.esgi_image CASCADE;
CREATE TABLE esgi_image (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(100) NOT NULL,
    link VARCHAR(500) NOT NULL,
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table esgi_settings
DROP TABLE IF EXISTS public.esgi_settings CASCADE;
CREATE TABLE esgi_settings(
    id SERIAL PRIMARY KEY,
    background_color VARCHAR(7) NOT NULL,
    font_color VARCHAR(7) NOT NULL,
    font_style VARCHAR(50) NOT NULL,
    date_inserted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

COMMIT;
