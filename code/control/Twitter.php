<?php

/**
 *
 *
 *
 */
class Twitter extends Controller
{
    /**
     * Set whether for fetch ssl links (https) or normal links
     *
     * @config
     * @var boolean
     */
    private static $use_https = true;

    /**
     * Pull down latest tweets using the twitter API
     *
     * @return ArrayList
     */
    public function LatestTweets($limit = 3)
    {
        $config = SiteConfig::current_site_config();
        $output = new ArrayList();
        $ssl = Config::inst()->get(self::class, 'use_https');

        if ($ssl) {
            $profile_img = 'profile_image_url_https';
        } else {
            $profile_img = 'profile_image_url';
        }

        if ($config->TwitterConsumerKey) {
            $tmhOAuth = new tmhOAuth(array(
                'consumer_key' => $config->TwitterConsumerKey,
                'consumer_secret' => $config->TwitterConsumerSecret,
                'user_token' => $config->TwitterAccessToken,
                'user_secret' => $config->TwitterAccessTokenSecret,
                'curl_ssl_verifypeer' => false
            ));

            $code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), array(
                'screen_name' => $config->TwitterUsername,
                'count' => $limit
            ));

            $response = $tmhOAuth->response['response'];
            $tweets = json_decode($response, true);

            if (!$tweets) {
                return false;
            }

            if ($this->errorCheck($tweets)) {
                return false;
            }

            foreach ($tweets as &$tweet) {
                $date = new SS_Datetime();
                $date->setValue($tweet['created_at']);

                $output->push(new ArrayData(array(
                    'ID' => $tweet['id'],
                    'Date' => $date,
                    'Content' => $this->tweetConvert($tweet['text']),
                    'User' => new ArrayData(array(
                        'ID' => $tweet['user']['id'],
                        'Name' => $tweet['user']['name'],
                        'ProfileImg' => $tweet['user'][$profile_img],
                        'ScreenName' => $tweet['user']['screen_name']
                    ))
                )));
            }
        }

        return $output;
    }

    /**
     * Use to render our latest tweets into a template file
     *
     * @return String
     */
    public function RenderedLatestTweets($limit = 3)
    {
        $vars = array(
            'Tweets'=>$this->LatestTweets($limit)
        );

        return $this->renderWith(array('LatestTweets'), $vars);
    }

    /**
     * Function to convert links, mentions and hashtags: http://goo.gl/ciKGs
     *
     * @return String
     */
    private function tweetConvert($tweet_string)
    {
        $tweet_string = preg_replace("/((http(s?):\/\/)|(www\.))([\w\.]+)([a-zA-Z0-9?&%.;:\/=+_-]+)/i", "<a href='http$3://$4$5$6' target='_blank'>$2$4$5$6</a>", $tweet_string);
        $tweet_string = preg_replace("/(?<=\A|[^A-Za-z0-9_])@([A-Za-z0-9_]+)(?=\Z|[^A-Za-z0-9_])/", "<a href='http://twitter.com/$1' target='_blank'>$0</a>", $tweet_string);
        $tweet_string = preg_replace("/(?<=\A|[^A-Za-z0-9_])#([A-Za-z0-9_]+)(?=\Z|[^A-Za-z0-9_])/", "<a href='http://twitter.com/search?q=%23$1' target='_blank'>$0</a>", $tweet_string);
        return $tweet_string;
    }

    /**
     * Check if Twitter API returned an error
     *
     * @return Boolean
     */
    private function errorCheck($tweets)
    {
        if (array_key_exists('errors', $tweets)) {
            $message = 'We have encountered ' . count($tweets['errors']) . ' error(s): <br />';

            foreach ($tweets['errors'] as $error) {
                $message .= $error['message'].' Code:'.$error['code'].'<br />';
            }

            if (Director::isDev()) {
                throw new Exception($message, 1);
            }

            return true;
        }

        return false;
    }
}
