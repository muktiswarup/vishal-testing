<!--?php

/**
 * PHPMailer - PHP email creation and transport class.
 * PHP Version 5.5.
 *
 * @see       https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 *
 * @author    Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk--><html><head></head><body>* @author    Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author    Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author    Brent R. Matzelle (original founder)
 * @copyright 2012 - 2020 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace PHPMailer\PHPMailer;

use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

/**
 * OAuth - OAuth2 authentication wrapper class.
 * Uses the oauth2-client package from the League of Extraordinary Packages.
 *
 * @see     http://oauth2-client.thephpleague.com
 *
 * @author  Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 */
class OAuth
{
    /**
     * An instance of the League OAuth Client Provider.
     *
     * @var AbstractProvider
     */
    protected $provider;

    /**
     * The current OAuth access token.
     *
     * @var AccessToken
     */
    protected $oauthToken;

    /**
     * The user's email address, usually used as the login ID
     * and also the from address when sending email.
     *
     * @var string
     */
    protected $oauthUserEmail = '';

    /**
     * The client secret, generated in the app definition of the service you're connecting to.
     *
     * @var string
     */
    protected $oauthClientSecret = '';

    /**
     * The client ID, generated in the app definition of the service you're connecting to.
     *
     * @var string
     */
    protected $oauthClientId = '';

    /**
     * The refresh token, used to obtain new AccessTokens.
     *
     * @var string
     */
    protected $oauthRefreshToken = '';

    /**
     * OAuth constructor.
     *
     * @param array $options Associative array containing
     *                       `provider`, `userName`, `clientSecret`, `clientId` and `refreshToken` elements
     */
    public function __construct($options)
    {
        $this-&gt;provider = $options['provider'];
        $this-&gt;oauthUserEmail = $options['userName'];
        $this-&gt;oauthClientSecret = $options['clientSecret'];
        $this-&gt;oauthClientId = $options['clientId'];
        $this-&gt;oauthRefreshToken = $options['refreshToken'];
    }

    /**
     * Get a new RefreshToken.
     *
     * @return RefreshToken
     */
    protected function getGrant()
    {
        return new RefreshToken();
    }

    /**
     * Get a new AccessToken.
     *
     * @return AccessToken
     */
    protected function getToken()
    {
        return $this-&gt;provider-&gt;getAccessToken(
            $this-&gt;getGrant(),
            ['refresh_token' =&gt; $this-&gt;oauthRefreshToken]
        );
    }

    /**
     * Generate a base64-encoded OAuth token.
     *
     * @return string
     */
    public function getOauth64()
    {
        //Get a new token if it's not available or has expired
        if (null === $this-&gt;oauthToken || $this-&gt;oauthToken-&gt;hasExpired()) {
            $this-&gt;oauthToken = $this-&gt;getToken();
        }

        return base64_encode(
            'user=' .
            $this-&gt;oauthUserEmail .
            "\001auth=Bearer " .
            $this-&gt;oauthToken .
            "\001\001"
        );
    }
}
</phpmailer@synchromedia.co.uk></codeworxtech@users.sourceforge.net></jimjag@gmail.com></body></html>