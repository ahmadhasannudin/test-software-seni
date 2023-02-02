<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function index()
    {
        try {
            $ch = curl_init();
            $headers[] = "Accept: application/vnd.github+json";
            $headers[] = "Authorization: Bearer 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";
            $headers[] = "X-GitHub-Api-Version: 2022-11-28";
            $headers[] = "User-Agent: hasan";

            $url = 'https://api.github.com/users/ahmadhasannudin/repos';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPGET, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $err = curl_error($ch);  //if you need
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode !== 200) {
                return response()->json($err, $httpcode);
            }
            $data = [];
            foreach (json_decode($response) as $key => $value) {
                $data[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'url' => $value->html_url,
                ];
            }

            return response()->json($data, $httpcode);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
