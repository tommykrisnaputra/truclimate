<?php
namespace App\Http\Controllers;
// require_once "vendor/autoload.php";
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function twitterRedirect(){
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterCallback(){
        $user = Socialite::driver('twitter')->user();
        $this->_registerOrLoginTwitterUser($user);
        
        // OAuth 2.0 providers...
        $token = $user->token;
        $refreshToken = $user->refreshToken;
        $expiresIn = $user->expiresIn;

        // All providers...
        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();

        // return redirect()->route('/dashboard');
        return redirect('http://localhost:3000/dashboard');
    }

    protected function _registerOrLoginTwitterUser($incomingUser) {
        $user = User::where('twitter_id', $incomingUser->id)->first();
        if (!$user) {
            $user = new User();
            $user->name = $incomingUser->name;
            $user->email = $incomingUser->email;
            $user->twitter_id = $incomingUser->id;
            $user->password = encrypt('password');
            $user->save();
        }

        Auth::login($user);
    }

    public function index() {
        $url = 'https://api.twitter.com/2/users/'. $user->getId() . '/following';

        dd ($url);

        $postdata = array(
            'target_user_id' => 'NASA'
        );

        $headers = [
            'Content-type: application/xml',
            'Authorization: Bearer',
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }
}
