<?php
// Роли
const ROLE_ADMIN = 1;

const ROLES = array(ROLE_ADMIN);
const ROLE_NAMES = array(ROLE_ADMIN => 'Администратор');
const ROLE_LOCAL_NAMES = array(ROLE_ADMIN => 'admin');

// Типы событий
const EVENT_TYPE_ANNOUNCEMENT = 1;
const EVENT_TYPE_THEATER = 2;
const EVENT_TYPE_USTAV = 3;

const EVENT_TYPES = array(EVENT_TYPE_ANNOUNCEMENT, EVENT_TYPE_THEATER);

// Типы новостей
const NEWS_TYPE_NEWS = 1;
const NEWS_TYPE_MEDIACENTER = 2;
const NEWS_TYPE_USTAV = 3;

const NEW_TYPES = array(NEWS_TYPE_NEWS, NEWS_TYPE_MEDIACENTER);

// Другое
const ISINVALID = ' is-invalid';
?>