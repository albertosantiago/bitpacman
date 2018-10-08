<?php namespace Chapusoft\SolveMedia\Service;

require_once __DIR__."/../solvemedia.php";

class CheckSolveMedia
{

    public function check($challenge, $response)
    {
        $privKey = app('config')->get('solvemedia.private_key');
        $hashKey = app('config')->get('solvemedia.auth_hash_key');

        $solvemedia_response = solvemedia_check_answer(
            $privKey,
            $_SERVER["REMOTE_ADDR"],
            $challenge,
            $response,
            $hashKey
        );
            
        if ($solvemedia_response->is_valid) {
            return true;
        } else {
            return false;
        }
    }
}
