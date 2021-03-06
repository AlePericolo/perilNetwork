<?php

    //setto gli elementi del login in session
    function setLoginElementsInSession($id, $username, $password)
    {
        $_SESSION['login']['id'] = $id;
        $_SESSION['login']['username'] = $username;
        $_SESSION['login']['password'] = $password;

        $_SESSION['login']['sessionId'] = session_id();
    }

    function getElementsFromSession($key, $key1 = null)
    {
        if (isset($_SESSION[$key])) {
            if (is_null($key1)) {
                return $_SESSION[$key];
            } else {
                return $_SESSION[$key][$key1];
            }
        }
        else return 'ko';
    }

    function getLoginDataFromSession($key)
    {
        return getElementsFromSession('login', $key);
    }

    //pulisco le variabili in session
    function clearSession()
    {
        session_unset();
        session_regenerate_id();
        return session_destroy();
    }

