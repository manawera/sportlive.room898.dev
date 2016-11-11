<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protect extends Model
{
    protected $fillable = [
        'name', 'key',
    ];

    public static function protectUrl($url, $protect_id, $user = null)
    {
    switch ($protect_id) {
        case 1:
            return $url;
            break;
        case 2:
            // Wmspanel Wowza Live
            $today = gmdate("n/j/Y g:i:s A");
            $initial_url = trim($url);

            $start = strpos($initial_url, '/', 7) + 1 ;
            $end = strrpos($initial_url, '/');

            $signed_stream = substr($initial_url, $start, $end - $start);
            $ip = $_SERVER['REMOTE_ADDR'];

            $protect = Protect::findOrFail($protect_id);
            if ($protect) {
                $key = $protect->key;
            } else {
                $key = '';
            }

            $validminutes = 1;
            $str2hash = $ip . $key . $today . $validminutes;
            $md5raw = md5($str2hash, true);
            $base64hash = base64_encode($md5raw);
            $urlsignature = "server_time=" . $today
                            . "&hash_value=" . $base64hash
                            . "&validminutes=$validminutes"
                            . "&agent=" . $user . "(" . $ip . ")" . $_SERVER['HTTP_USER_AGENT'];
            $base64urlsignature = base64_encode($urlsignature);
            $signedurlwithvalidinterval = $initial_url . "?wmsAuthSign=$base64urlsignature";
            return $signedurlwithvalidinterval;
            break;
        case 3:
            // Wmspanel Wowza VOD
            $today = gmdate("n/j/Y g:i:s A");
            $initial_url = trim($url);

            $start = strpos($initial_url, '/', 7) + 1 ;
            $end = strrpos($initial_url, '/');

            $signed_stream = substr($initial_url, $start, $end - $start);
            $ip = $_SERVER['REMOTE_ADDR'];

            $protect = Protect::findOrFail($protect_id);
            if ($protect) {
                $key = $protect->key;
            } else {
                $key = '';
            }

            $validminutes = 240;
            $str2hash = $ip . $key . $today . $validminutes;
            $md5raw = md5($str2hash, true);
            $base64hash = base64_encode($md5raw);
            $urlsignature = "server_time=" . $today
                            . "&hash_value=" . $base64hash
                            . "&validminutes=$validminutes"
                            . "&agent=" . $user . "(" . $ip . ")" . $_SERVER['HTTP_USER_AGENT'];
            $base64urlsignature = base64_encode($urlsignature);
            $signedurlwithvalidinterval = $initial_url . "?wmsAuthSign=$base64urlsignature";
            return $signedurlwithvalidinterval;
            break;
        case 4:
            // Wmspanel Nimble Live
            $today = gmdate("n/j/Y g:i:s A");
            $initial_url = trim($url);

            $start = strpos($initial_url, '/', 7) + 1 ;
            $end = strrpos($initial_url, '/');

            $signed_stream = substr($initial_url, $start, $end - $start);
            $ip = $_SERVER['REMOTE_ADDR'];

            $protect = Protect::findOrFail($protect_id);
            if ($protect) {
                $key = $protect->key;
            } else {
                $key = '';
            }

            $validminutes = 1;
            $str2hash = $ip . $key . $today . $validminutes . $signed_stream;
            $md5raw = md5($str2hash, true);
            $base64hash = base64_encode($md5raw);
            $urlsignature = "server_time=" . $today
                            . "&hash_value=" . $base64hash
                            . "&validminutes=$validminutes"
                            . "&strm_len=" . strlen($signed_stream)
                            . "&agent=" . $user . "(" . $ip . ")" . $_SERVER['HTTP_USER_AGENT'];
            $base64urlsignature = base64_encode($urlsignature);
            $signedurlwithvalidinterval = $initial_url . "?wmsAuthSign=$base64urlsignature";
            return $signedurlwithvalidinterval;
            break;
        case 5:
            // Wmspanel Nimble VOD
            $today = gmdate("n/j/Y g:i:s A");
            $initial_url = trim($url);

            $start = strpos($initial_url, '/', 7) + 1 ;
            $end = strrpos($initial_url, '/');

            $signed_stream = substr($initial_url, $start, $end - $start);
            $ip = $_SERVER['REMOTE_ADDR'];

            $protect = Protect::findOrFail($protect_id);
            if ($protect) {
                $key = $protect->key;
            } else {
                $key = '';
            }

            $validminutes = 240;
            $str2hash = $ip . $key . $today . $validminutes . $signed_stream;
            $md5raw = md5($str2hash, true);
            $base64hash = base64_encode($md5raw);
            $urlsignature = "server_time=" . $today
                            . "&hash_value=" . $base64hash
                            . "&validminutes=$validminutes"
                            . "&strm_len=" . strlen($signed_stream)
                            . "&agent=" . $user . "(" . $ip . ")" . $_SERVER['HTTP_USER_AGENT'];
            $base64urlsignature = base64_encode($urlsignature);
            $signedurlwithvalidinterval = $initial_url . "?wmsAuthSign=$base64urlsignature";
            return $signedurlwithvalidinterval;
            break;
        case 6:
            // TOT
            $protect = Protect::findOrFail($protect_id);
            if ($protect) {
                $secret = $protect->key;
            } else {
                $secret = '';
            }
            $ip = $_SERVER['REMOTE_ADDR'];
            $encode = md5($secret.$ip);
            return $url."?s=$encode";
            break;
        default:
            return '';
    }
}

}
