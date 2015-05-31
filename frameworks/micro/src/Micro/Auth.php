<?php

interface Micro_Auth
{
    public function authenticate();

    public function isLoggedIn();

    public function getUserId();

    public function getProvider();
}